(function () {
  'use strict';
  var root = document.documentElement;
  root.classList.add('js');

  // Mobile-Navigation
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('primary-nav');
  if (toggle && nav) {
    var setOpen = function (open) {
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      nav.classList.toggle('is-open', open);
    };
    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { setOpen(false); toggle.focus(); }
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) { setOpen(false); }
    });
  }

  // Header-Schatten beim Scrollen
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-stuck', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Einblend-Animation
  var items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && items.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('is-in'); });
  }

  // Inhaltsverzeichnis für lange Seiten (z. B. Datenschutz)
  var toc = document.querySelector('.toc');
  var content = document.getElementById('page-content');
  if (toc && content) {
    var heads = content.querySelectorAll('h2, h3');
    if (heads.length >= 4) {
      var list = toc.querySelector('.toc__list');
      var hasH2 = content.querySelector('h2') !== null;
      heads.forEach(function (h, i) {
        var text = h.textContent.trim();
        if (!text) { return; }
        if (!h.id) { h.id = 'abschnitt-' + (i + 1); }
        var li = document.createElement('li');
        if (hasH2 && h.tagName === 'H3') { li.className = 'toc__sub'; }
        var a = document.createElement('a');
        a.href = '#' + h.id; a.textContent = text;
        li.appendChild(a); list.appendChild(li);
      });
      toc.hidden = false;
      if ('IntersectionObserver' in window) {
        var links = toc.querySelectorAll('a');
        var spy = new IntersectionObserver(function (entries) {
          entries.forEach(function (en) {
            if (en.isIntersecting) {
              links.forEach(function (l) { l.classList.toggle('is-active', l.getAttribute('href') === '#' + en.target.id); });
            }
          });
        }, { rootMargin: '-20% 0px -70% 0px' });
        heads.forEach(function (h) { if (h.id) { spy.observe(h); } });
      }
    }
  }
})();
