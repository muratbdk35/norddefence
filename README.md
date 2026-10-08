# Cyber Defence Nord – WordPress-Theme

Klassisches WordPress-Theme (kein Page-Builder) für https://cyberdefencenord.de.
Ordner: `cyber-defence-nord/`

## Installation
1. Backup erstellen (UpdraftPlus ist schon installiert).
2. `cyber-defence-nord.zip` unter *Design → Themes → Neu hinzufügen → Theme hochladen* installieren und aktivieren
   (oder den Ordner per FTP nach `wp-content/themes/` kopieren).
3. *Einstellungen → Lesen*: „Startseite zeigt: statische Seite“ → Seite „Start“.
4. Seiten anlegen/anpassen:
   - **Leistungen** → Seiten-Template „Leistungen“ (Slug `leistungen`)
   - **Kontakt** → Seiten-Template „Kontakt“ (Slug `kontakt`)
   - **Impressum** (Slug `impressum`) – **rechtlich erforderlich, Inhalt selbst erstellen**
   - Datenschutz (`/pra/`) → Slug auf `datenschutz` ändern; „Über uns“ (`/a/`) → `ueber-uns`
5. *Design → Menüs*: Hauptmenü anlegen (Start, Leistungen, Über uns, Kontakt) und „Hauptmenü“ zuweisen.
   Ohne Menü greift ein eingebautes Fallback-Menü.
6. *Design → Customizer → Kontaktdaten*: Telefon, E-Mail, Anschrift, LinkedIn, Formular-Empfänger.
7. „Sample Page“, „Hello world!“ und die Test-Kommentare löschen.
8. *Einstellungen → Allgemein*: WordPress- und Website-Adresse auf `https://cyberdefencenord.de` setzen (aktuell `http://`).

## Was das Theme mitbringt
- Neues Design (Hero, Leistungen, Vorgehen, CTA, Kontakt), responsiv, ohne externe Schriften/CDNs (DSGVO).
- Kontaktformular ohne Plugin: Nonce, Honeypot, Zeitprüfung, Rate-Limit, Einwilligungs-Checkbox.
  E-Mail-Versand läuft über `wp_mail` – für zuverlässige Zustellung ein SMTP-Plugin einrichten.
- SEO: ein `<h1>` pro Seite, Meta-Description, Open-Graph, JSON-LD (Organisation).
- Härtung: Versionsangaben, XML-RPC, öffentliche Benutzerliste (REST/Autorenseiten/Sitemap) abgeschaltet;
  Header `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, HSTS (nur über HTTPS).
- Barrierefrei: Skip-Link, Fokus-Markierung, `prefers-reduced-motion`.

## Hinweise
- Texte zu Leistungen sind Entwürfe auf Basis der bisherigen Website und müssen fachlich geprüft werden
  (u. a. Aussagen zu „24/7“, Zertifizierungen). Inhalte: `cyber-defence-nord/inc/content.php`.
- Die Telefonnummer `+49 44405254` wurde unverändert von der alten Seite übernommen – bitte prüfen.
- Bilder in der Mediathek: sprechende Dateinamen und Alt-Texte vergeben; Standardseiten-Inhalte bleiben unverändert.
- Eine Content-Security-Policy ist bewusst nicht gesetzt (hängt von den aktiven Plugins ab); HSTS/CSP ggf. zusätzlich am Server.

## Bilder & Ladezeit
Die größten Bilder der alten Seite sind 1–2,3 MB große PNGs (z. B. `CDN-Background-web-site.png`, `ChatGPT-Image-…png`, `image.png`).
- Das Theme erzeugt **neue** Uploads automatisch als WebP (Qualität 80) und skaliert Riesenbilder auf max. 2000 px.
- Bestehende Bilder: Plugin **WP-Optimize** (ist installiert) → Tab „Images“ → komprimieren; alternativ „Regenerate Thumbnails“ + „Converter for Media“ (WebP).
  Besser: Originale vor dem Upload mit squoosh.app als WebP/JPEG (Breite max. 1600 px, < 200 KB) speichern.
- WP-Optimize → „Caching“ aktivieren (Seiten-Cache, GZIP, Browser-Cache), dazu „Minify“ für CSS/JS.
- Das Logo ist ein 15-KB-PNG und wird mit hoher Priorität geladen; alle Bilder im Seitentext laden per Lazy-Loading.
- Optional in der `.htaccess` (vor `# BEGIN WordPress`) Browser-Caching setzen:
```
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/webp "access plus 1 year"
ExpiresByType image/png "access plus 1 year"
ExpiresByType image/jpeg "access plus 1 year"
ExpiresByType text/css "access plus 1 month"
ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```
