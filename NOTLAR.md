# Proje notları – cyberdefencenord.de yeniden tasarım

Bu dosya, yeni bir oturumda kaldığımız yerden devam edebilmek için yazıldı. Önce bunu, sonra `README.md`'yi oku.

## Durum
- Canlı site: https://cyberdefencenord.de (WordPress 7.1.3, eski tema "Cyber Security Blocks").
- Yeni tema: `cyber-defence-nord/` (klasik WordPress teması, v1.1). Hazır zip: `cyber-defence-nord.zip`.
- Kullanıcı temayı canlı siteye yükledi/yüklüyor; ekran görüntüleriyle geri bildirim veriyor.
- Yerel test: WordPress + SQLite eklentisi ile kuruldu, Playwright (`/opt/node-tools/node_modules/playwright`) ile ekran görüntüsü alınabiliyor. Bu ortam geçici, gerekirse yeniden kurulur.

## Kararlar
- **Logo:** Kartal logosu kalacak (kullanıcı "kartalı koruma taraftarıyız" dedi). Logo geçici olarak konulmuştu, ileride değişebilir. Tema her zaman paketle gelen şeffaf `assets/img/logo.png` dosyasını kullanır (eski Custom Logo yok sayılır).
- **WordPress'te kalınacak, klasik tema** (blok tema / page builder yok).
- Dil: Almanca. Dış font/CDN yok (DSGVO).
- Tasarım yönü kullanıcıya bırakıldı ("sen ne dersen"), AMA son geri bildirim: **"fazla vibecoded duruyor."**
  Yani şu an kalıp şablon gibi (gradyan hero, ikonlu kart ızgarası, genel metinler, gerçek içerik yok).
  Yapılacak: markaya özgü, daha editoryal ve özgün bir tasarım. 21st MCP ile bileşen/ilham alınabilir, ama asıl fark gerçek içerik ve görsel kimlik olmalı.

## Sitede bulunan sorunlar (analiz, ilk tarama)
Tema bunların çoğunu çözüyor; kalanlar WordPress panelinden yapılmalı.
- Kırık/boş linkler: `http://a`, `https://a` (LinkedIn), footer'da 9 adet `#`. Teklif butonları boş. İletişim formu yoktu.
- Test içerikleri yayında: Sample Page, "Hello world!", sahte yorum. Sayfalar birbirinin kopyası. Slug'lar anlamsız: `/a/` (Über uns), `/pra/` (Datenschutz).
- **Impressum yok** (Almanya'da zorunlu). Kullanıcı yazacak; uydurulmadı.
- Karışık dil (DE/EN), marka adı tutarsız ("Cyber Defence Nord" / "Nord Cyber Defence").
- Meta description yok, çift `<h1>`, görsellerin çoğunda alt metni yok, görsel dosya adları anlamsız.
- Güvenlik: güvenlik başlıkları yoktu; `/wp-json/wp/v2/users` ve yazar sayfası admin kullanıcı adını (`sungur_A11`) sızdırıyordu; `readme.html`/`license.txt` açık; sayfa kaynağında WP sürümü; `http://` karışık içerik (Site URL `http` kalmış olabilir).
- Performans: 1–2,3 MB'lık PNG görseller, önbellek başlığı yok.
- Doğrulanamayanlar: gerçek tarayıcıda hız/Core Web Vitals, `wp-login.php` ve `xmlrpc.php` 503 döndü (neden bilinmiyor).

## Bekleyen işler (kullanıcıda)
- [ ] Impressum sayfası (içeriği kendisi yazacak) + Datenschutz slug'ını `datenschutz`, Über uns slug'ını `ueber-uns` yapmak.
- [ ] Telefon numarası `+49 44405254` eski siteden aynen alındı, doğruluğu kontrol edilecek. Adres ve LinkedIn Customizer'dan girilecek.
- [ ] Hizmet metinleri taslak (`inc/content.php`); "24/7", "zertifizierte Experten" gibi iddialar doğrulanmalı.
- [ ] Ayarlar → Genel: WordPress/Site adresi `https` yapılacak. Sample Page ve Hello World silinecek.
- [ ] Menü oluşturulacak (Start, Leistungen, Über uns, Kontakt) ve "Hauptmenü" konumuna atanacak; ana sayfa statik sayfa "Start" yapılacak.
- [ ] Görseller: WP-Optimize ile sıkıştırma + önbellek (ayrıntı `README.md`).
- [ ] İletişim formu için SMTP eklentisi (yerelde gerçek mail gönderimi test edilemedi).

## Bekleyen işler (Claude'da)
- [ ] Tasarımı daha özgün yapmak. Kullanıcıdan şunlar istendi (henüz cevap yok): 2–3 referans site, gerçek materyaller (ekip/ofis/şehir fotoğrafı, sertifika, referans müşteri), yön (ciddi-kurumsal / modern-teknik / sıcak-yerel).
- [ ] Önerilen fikirler: logodaki kartal + Hamburg kilise silüetini ana motif yapmak; daha az kart, asimetrik yerleşim, büyük tipografi, keskin köşeler, sınırlı palet; yapay zekâ görsellerini (`ChatGPT-Image…`) kaldırmak; genel sloganlar yerine somut kısa metinler.
- [ ] İsteğe bağlı: ekip/referans bölümü, blog sayfası tasarımı, İngilizce dil desteği.

## 21st MCP
- `claude mcp add --transport http 21st https://21st.dev/api/mcp --header "x-api-key: …"` bu ortamda çalıştırıldı; `claude mcp list` "Connected" gösteriyor.
- Ama araçlar ancak yeni oturumda yükleniyor. Bu oturumda 21st araçları yoktu.
- Anahtar sohbette düz metin yazıldı → **yenilenmeli**. Kalıcı çözüm: ortam ayarlarında Network secrets + setup script'e anahtarsız `claude mcp add` komutu. Anahtarı repoya veya bu dosyaya YAZMA.

## Geri bildirim geçmişi (tema)
- v1.0 → v1.1: logo küçük/beyaz kenarlıydı (Custom Logo yüzünden) → paketli şeffaf PNG, büyütüldü; hizmetler bölümü fazla beyaz → mavi zemin ve koyu kontrast; Services/Datenschutz sayfaları bozuktu → otomatik şablon + içindekiler menülü geniş düzen; görseller yavaş → WebP, lazy-load, README önerileri.

## v2 – editoryal yeniden tasarım (21st ilhamıyla)
- 21st MCP HTTP üzerinden doğrudan çağrıldı (araçlar oturuma yüklenmedi); "Editorial Hero" (sol küçük slogan, sağ büyük serif başlık, altta tam genişlik görsel) düzeni referans alındı. Kod alınmadı, düzen sıfırdan yazıldı.
- Kart ızgarası/ikon/gradyan kaldırıldı: kâğıt rengi zemin, serif başlıklar (sistem fontu), tek vurgu rengi, numaralı hizmet indeksi, "Haltung" bölümü, çizgili süreç bölümü.
- Hero altında Hamburg silueti (inline SVG, `inc/skyline.php`; Michel, Nikolai, Rathaus, Elbphilharmonie, vinçler – stilize). İstenirse gerçek fotoğrafla değiştirilebilir.
- Hero'daki "24/7" iddiası kaldırıldı; hizmet metinlerindeki iddialar hâlâ doğrulanmalı.
- Anahtar yenilenmeli (sohbette iki kez düz metin paylaşıldı).

## Englisch (v2.1)
- Plugin yok. Tema `inc/lang.php`: `/en/`, `/en/services/`, `/en/contact/` sanal adresleri (rewrite kuralı, tema şablonlarını İngilizce çiziyor). Header'da DE/EN anahtarı, hreflang, `lang="en-US"`, İngilizce başlık/açıklama.
- Metinler: `cdn_t('de','en')` / `cdn_e()`; hizmetlerin İngilizcesi `inc/content.php` → `cdn_services_en()`.
- Über uns, Impressum, Datenschutz Almanca kalıyor (İngilizce menüde "(DE)" etiketli).
- Tema ilk etkinleşince kalıcı bağlantılar kendiliğinden yenilenir; `/en/` 404 verirse Ayarlar → Kalıcı bağlantılar → Kaydet.
- İngilizce metinler benim çevirim; yayından önce bir ana dili konuşan okumalı.
