/* Footer: Hamburg-Silhouette als geordnetes Dither (Bayer) mit ziehendem Elbnebel.
   Ein Canvas, keine externen Ressourcen. Läuft nur, solange der Footer sichtbar ist. */
(function () {
  'use strict';
  var scene = document.querySelector('[data-footer-scene]');
  if (!scene) { return; }
  var canvas = scene.querySelector('canvas');
  var ctx = canvas && canvas.getContext('2d');
  if (!ctx) { return; }

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var P = 2; // Größe eines Dither-Pixels in CSS-px
  var HEX = ['#06141f', '#0a2236', '#0f3150', '#17476f', '#2a6490', '#5189b3', '#9fc4dc'];
  var PAL = HEX.map(function (h) {
    var n = parseInt(h.slice(1), 16);
    return ((255 << 24) | ((n & 255) << 16) | (((n >> 8) & 255) << 8) | (n >> 16)) >>> 0;
  });
  var N = PAL.length;

  /* ---- Hilfsfunktionen ---- */
  var BAYER = (function () {
    var m = [[0]];
    while (m.length < 8) {
      var s = m.length, r = [], y, x;
      for (y = 0; y < s * 2; y++) {
        r[y] = [];
        for (x = 0; x < s * 2; x++) {
          var q = m[y % s][x % s] * 4;
          r[y][x] = q + (y < s ? (x < s ? 0 : 2) : (x < s ? 3 : 1));
        }
      }
      m = r;
    }
    var flat = [];
    m.forEach(function (row) { row.forEach(function (v) { flat.push((v + 0.5) / 64); }); });
    return flat;
  })();
  function hash(x, y, s) {
    var h = Math.imul(x | 0, 374761393) + Math.imul(y | 0, 668265263) + Math.imul(s | 0, 1442695041);
    h = Math.imul(h ^ (h >>> 13), 1274126177);
    h ^= h >>> 16;
    return (h >>> 0) / 4294967296;
  }
  function noise(x, y, s) {
    var xi = Math.floor(x), yi = Math.floor(y), xf = x - xi, yf = y - yi;
    var u = xf * xf * (3 - 2 * xf), v = yf * yf * (3 - 2 * yf);
    var a = hash(xi, yi, s), b = hash(xi + 1, yi, s), c = hash(xi, yi + 1, s), d = hash(xi + 1, yi + 1, s);
    return a + (b - a) * u + (c - a) * v + (a - b - c + d) * u * v;
  }
  function fbm(x, y, s) {
    var sum = 0, amp = 0.5, norm = 0, o;
    for (o = 0; o < 3; o++) { sum += noise(x, y, s + o * 31) * amp; norm += amp; x *= 2.03; y *= 2.03; amp *= 0.5; }
    return sum / norm;
  }
  function smooth(a, b, x) {
    var t = b === a ? (x < a ? 0 : 1) : Math.min(1, Math.max(0, (x - a) / (b - a)));
    return t * t * (3 - 2 * t);
  }
  function ease(t) { t = t < 0 ? 0 : t > 1 ? 1 : t; return 1 - Math.pow(1 - t, 3); }
  function rng(seed) {
    return function () {
      seed |= 0; seed = (seed + 0x6D2B79F5) | 0;
      var t = Math.imul(seed ^ (seed >>> 15), 1 | seed);
      t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
      return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
  }

  /* ---- Zustand ---- */
  var cols = 1, rows = 1, s = 1, yb = 1, water = 1;
  var masks = [], img = null, buf = null, fog = null, fw = 1, fh = 1;
  var revealAt = null, visible = true, raf = 0, last = 0, tick = performance.now();
  var px = 0, py = 0, ex = 0, ey = 0, inside = false, clear = 0;
  var SEED = 23;

  function makeMask(draw) {
    var c = document.createElement('canvas');
    c.width = cols; c.height = rows;
    var g = c.getContext('2d');
    g.fillStyle = '#000'; g.strokeStyle = '#000'; g.lineCap = 'butt';
    draw(g);
    var d = g.getImageData(0, 0, cols, rows).data, m = new Uint8Array(cols * rows), i;
    for (i = 0; i < m.length; i++) { m[i] = d[i * 4 + 3] > 70 ? 1 : 0; }
    return m;
  }
  function R(g, x, w, h) { g.fillRect(x, yb - h, w, h); }
  function tri(g, x1, y1, x2, y2, x3, y3) { g.beginPath(); g.moveTo(x1, y1); g.lineTo(x2, y2); g.lineTo(x3, y3); g.closePath(); g.fill(); }
  function crane(g, x0, k) {
    var lw = Math.max(1.3, 1.5 * s);
    g.lineWidth = lw;
    g.beginPath();
    g.moveTo(x0, yb); g.lineTo(x0, yb - 66 * s * k);
    g.moveTo(x0 + 7 * s, yb); g.lineTo(x0 + 7 * s, yb - 58 * s * k);
    g.stroke();
    g.fillRect(x0 - 24 * s, yb - 70 * s * k, 62 * s, Math.max(1.4, 2.4 * s));
    g.beginPath();
    g.moveTo(x0 + 2 * s, yb - 82 * s * k); g.lineTo(x0 - 24 * s, yb - 69 * s * k);
    g.moveTo(x0 + 2 * s, yb - 82 * s * k); g.lineTo(x0 + 36 * s, yb - 69 * s * k);
    g.moveTo(x0 + 2 * s, yb - 82 * s * k); g.lineTo(x0 + 2 * s, yb - 66 * s * k);
    g.stroke();
    g.fillRect(x0 - 3 * s, yb - 70 * s * k, 9 * s, 12 * s * k);
  }

  function build() {
    var r;
    // Ferne Stadt: viele niedrige Blöcke
    masks[0] = makeMask(function (g) {
      r = rng(SEED + 1);
      for (var x = 0; x < cols;) {
        var bw = (5 + r() * 11) * s, bh = (16 + r() * 30) * s;
        R(g, x, bw, bh);
        if (r() < 0.12) { R(g, x + bw * 0.4, 2.2 * s, bh + (10 + r() * 16) * s); }
        x += bw * (0.55 + r() * 0.6);
      }
    });
    // Mittlere Ebene: Wahrzeichen
    masks[1] = makeMask(function (g) {
      r = rng(SEED + 2);
      var x;
      for (x = 0; x < cols;) {
        var bw = (8 + r() * 14) * s, bh = (12 + r() * 14) * s;
        R(g, x, bw, bh);
        x += bw * (0.8 + r() * 0.4);
      }
      var u;
      // Nikolaikirche: schlanke Turmspitze
      u = cols * 0.16;
      R(g, u - 4 * s, 8 * s, 66 * s);
      tri(g, u - 4 * s, yb - 66 * s, u + 4 * s, yb - 66 * s, u, yb - 124 * s);
      // Michel: Kirchenschiff, Turm, Haube, Laterne, Spitze
      u = cols * 0.34;
      R(g, u - 34 * s, 68 * s, 30 * s);
      R(g, u - 9 * s, 18 * s, 78 * s);
      g.beginPath(); g.arc(u, yb - 78 * s, 10 * s, Math.PI, 0); g.fill();
      R(g, u - 3.5 * s, 7 * s, 98 * s);
      tri(g, u - 3.5 * s, yb - 98 * s, u + 3.5 * s, yb - 98 * s, u, yb - 120 * s);
      // Rathaus: Körper, Turm, Kupferdach, Erker
      u = cols * 0.56;
      R(g, u - 38 * s, 76 * s, 32 * s);
      R(g, u - 6.5 * s, 13 * s, 80 * s);
      tri(g, u - 8 * s, yb - 80 * s, u + 8 * s, yb - 80 * s, u, yb - 100 * s);
      R(g, u - 36 * s, 6 * s, 44 * s); R(g, u + 30 * s, 6 * s, 44 * s);
      // Elbphilharmonie: Sockel mit Wellendach
      u = cols * 0.78;
      g.beginPath();
      g.moveTo(u - 42 * s, yb);
      g.lineTo(u - 42 * s, yb - 30 * s);
      g.quadraticCurveTo(u - 26 * s, yb - 50 * s, u - 8 * s, yb - 34 * s);
      g.quadraticCurveTo(u + 8 * s, yb - 54 * s, u + 26 * s, yb - 38 * s);
      g.lineTo(u + 42 * s, yb - 44 * s);
      g.lineTo(u + 42 * s, yb);
      g.closePath(); g.fill();
    });
    // Vordergrund: Speicher und Hafenkräne
    masks[2] = makeMask(function (g) {
      r = rng(SEED + 3);
      for (var x = -10 * s; x < cols;) {
        var w = (10 + r() * 20) * s, h = (7 + r() * 9) * s;
        R(g, x, w, h);
        tri(g, x - 1.5 * s, yb - h, x + w + 1.5 * s, yb - h, x + w / 2, yb - h - (4 + r() * 4) * s);
        x += w * (0.9 + r() * 0.35);
      }
      crane(g, cols * 0.06, 1);
      crane(g, cols * 0.93, 0.92);
      if (cols > 520) { crane(g, cols * 0.88, 0.7); }
    });
  }

  function layout() {
    var rect = scene.getBoundingClientRect();
    cols = Math.max(40, Math.ceil(rect.width / P));
    rows = Math.max(40, Math.ceil(rect.height / P));
    canvas.width = cols; canvas.height = rows;
    canvas.style.width = cols * P + 'px';
    canvas.style.height = rows * P + 'px';
    s = rows / 190;
    water = Math.round(20 * s);
    yb = rows - water;
    img = ctx.createImageData(cols, rows);
    buf = new Uint32Array(img.data.buffer);
    fw = (cols >> 1) + 2; fh = (rows >> 1) + 2;
    fog = new Float32Array(fw * fh);
    build();
  }

  var LT = [0.27, 0.13, 0.035];   // Tonwert je Ebene (ferner = heller)
  var MK = [0.9, 0.55, 0.25];       // wie stark der Nebel die Ebene aufhellt

  function draw(now) {
    var dt = Math.min(64, now - tick); tick = now;
    var age = revealAt === null ? 0 : now - revealAt;
    var ease1 = 1 - Math.pow(0.82, dt / 16.7);
    ex += (px - ex) * ease1; ey += (py - ey) * ease1;
    clear += ((inside ? 1 : 0) - clear) * (1 - Math.pow(0.93, dt / 16.7));
    var ft = reduced ? 3.1 : (now / 1000) * 0.045;
    var sx = 9 / cols, sy = 4.4 / rows, gx, gy;
    for (gy = 0; gy < fh; gy++) {
      for (gx = 0; gx < fw; gx++) {
        var nx = gx * sx + ft, ny = gy * sy;
        var wp = noise(nx * 0.45 - ft * 0.6, ny * 0.8, 77) * 0.6;
        fog[gy * fw + gx] = smooth(0.3, 0.74, fbm(nx + wp, ny + wp * 0.4, 31));
      }
    }
    var rev = [ease((age - 250) / 1200), ease((age - 600) / 1200), ease((age - 950) / 1200)];
    if (reduced) { rev = [1, 1, 1]; }
    var fadeTop = Math.max(rows * 0.2, 60 / P), r2 = Math.pow(120 / P, 2);
    var x, y;
    for (y = 0; y < rows; y++) {
      var fade = smooth(0, fadeTop, y);
      var hz = 0.5 * smooth(rows * 0.12, yb, Math.min(y, yb));
      var frow = (y >> 1) * fw, by = (y & 7) * 8;
      for (x = 0; x < cols; x++) {
        var i = y * cols + x, L = -1;
        if (masks[2][i]) { L = 2; } else if (masks[1][i]) { L = 1; } else if (masks[0][i]) { L = 0; }
        var m = fog[frow + (x >> 1)];
        var tone;
        if (y >= yb) {
          var d = (y - yb) / water;
          var rip = noise(x * 0.18, y * 0.9 + ft * 40, 5);
          tone = (0.1 + 0.1 * rip) * (1 - 0.55 * d) * (0.6 + 0.4 * rev[2]);
          tone += m * 0.06;
        } else if (L < 0) {
          tone = hz + m * 0.2 * smooth(rows * 0.2, yb, y);
          tone *= (0.35 + 0.65 * rev[0]);
        } else {
          var base = hz + m * 0.2 * smooth(rows * 0.2, yb, y);
          var tgt = LT[L] + m * 0.2 * MK[L] + 0.2 * smooth(yb - 22 * s, yb, y) * (L === 2 ? 0.5 : 1);
          tone = base + (tgt - base) * rev[L];
        }
        if (clear > 0.01) {
          var dx = x - ex, dy = (y - ey) * 1.5, q = (dx * dx + dy * dy) / r2;
          if (q < 4) { tone -= clear * Math.exp(-q) * m * 0.2; }
        }
        tone *= fade;
        var v = Math.floor(Math.min(1, Math.max(0, tone)) * (N - 1) + BAYER[by + (x & 7)]);
        buf[i] = PAL[v > N - 1 ? N - 1 : v];
      }
    }
    ctx.putImageData(img, 0, 0);
  }

  function loop(now) {
    raf = 0;
    if (!visible || revealAt === null) { return; }
    if (now - last > 40) { draw(now); last = now; }
    raf = requestAnimationFrame(loop);
  }
  function wake() { if (!raf && visible && !reduced) { raf = requestAnimationFrame(loop); } }

  layout();
  draw(performance.now());

  var io = new IntersectionObserver(function (entries) {
    visible = entries[0] ? entries[0].isIntersecting : true;
    if (visible && revealAt === null) {
      revealAt = reduced ? -1e9 : performance.now();
      draw(performance.now());
    }
    if (visible) { tick = performance.now(); wake(); }
  }, { threshold: 0.15 });
  io.observe(scene);

  if (!reduced) {
    scene.addEventListener('pointermove', function (e) {
      var b = scene.getBoundingClientRect();
      px = (e.clientX - b.left) / P; py = (e.clientY - b.top) / P;
      if (!inside) { ex = px; ey = py; }
      inside = true;
    });
    scene.addEventListener('pointerleave', function () { inside = false; });
  }
  var t = 0;
  new ResizeObserver(function () {
    clearTimeout(t);
    t = setTimeout(function () { layout(); draw(performance.now()); }, 120);
  }).observe(scene);
})();
