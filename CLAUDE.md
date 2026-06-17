# SteelPlast — Project Context

## Project
Custom WordPress theme for **SteelPlast** (industrial/metalworking company).
Goal: high-quality, fast, SEO-optimized site that passes Google Core Web Vitals.

---

## Stack
- **CMS:** WordPress (LocalWP for local dev)
- **Language:** PHP + SCSS (no JS framework — vanilla JS only)
- **Font:** Inter via Google Fonts
- **Build:** `npm run build` (prod) / `npm run watch` (dev)
- **SCSS → CSS:** `assets/scss/main.scss` → `assets/css/main.css`

---

## Build commands
```bash
npm run build   # compile SCSS → CSS (compressed, no source maps)
npm run watch   # watch mode
```
Always run `npm run build` after SCSS changes. CSS version is auto-busted via `filemtime()`.

---

## Installed plugins
| Plugin | Purpose |
|---|---|
| WPML | Multilingual (8 languages) |
| Yoast SEO | Meta, sitemap, schema, hreflang |
| Wordfence | Security |
| UpdraftPlus | Backups |
| WP-Optimize | Cache + CSS/JS compression |
| Burst Statistics | Cookie-free analytics |
| Antispam Bee | Comment spam |
| Complianz | GDPR / cookie consent |
| Redirection | 301 redirects + 404 tracking |

> **Cache:** Always clear WP-Optimize cache after PHP/CSS/JS changes.
> WP Admin → WP-Optimize → Cache → Purge all cache (or admin bar shortcut).

---

## Languages (WPML)
UA (default), EN, DE, IT, LV, LT, PL, CS, SK, HU, TR

Language auto-redirect is implemented in `assets/js/header.js` but **currently disabled** — enable after all WPML translations are set up.

---

## Design
- **Source:** Figma (user shares sections/screenshots per session)
- **Style:** Dark theme — navy/black background, accent `#6de2f7`, uppercase bold headings
- **UI Kit transferred:** colors, spacing, typography

### Colors (from `_variables.scss`)
| Variable | Value |
|---|---|
| `$color-pure-white` | `#f6f6f6` |
| `$color-accent` | `#6de2f7` |
| `$color-background` | `#0f0f0f` |
| `$color-dark-navy` | `#121c2e` |
| `$color-black` | `#090a0c` |

### CSS custom properties (`:root`)
`--Pure-White`, `--color-accent`, `--color-bg`, `--color-navy`, `--color-black`

---

## Layout rules
- **Content wrapper:** `max-width: 1440px; margin: 0 auto; padding: 0 32px` — class `.content-wrapper`
- **Section backgrounds** go full-width (no wrapper on the section itself)
- **Header height:** 80px (fixed/sticky)
- **Body offset:** `.site-main { padding-top: 80px }`

---

## SCSS structure
```
assets/scss/
├── main.scss          # entry point — imports all partials + CSS vars + base reset
├── _variables.scss    # colors, spacing, typography tokens
├── _typography.scss   # heading/body styles
└── _header.scss       # header component styles
```

---

## JS structure
```
assets/js/
└── header.js          # scroll bg, dropdown toggle, active menu by URL, burger, lang redirect
```

---

## File / template structure
```
theme root/
├── front-page.php              # / (Головна)
├── page-about.php              # /about/
├── page-services.php           # /services/
├── page-faq.php                # /faq/
├── page-quality.php            # /quality/
├── page-news.php               # /news/
├── page-contacts.php           # /contacts/
├── page-cnc-machining.php      # /services/cnc-machining/
├── page-cnc-milling.php        # /services/cnc-milling/
├── page-cnc-turning.php        # /services/cnc-turning/
├── page-swiss-turning.php      # /services/swiss-turning/
├── page-templates/
│   └── template-service-inner.php  # shared template for inner service pages
├── header.php
├── footer.php
├── functions.php
└── assets/
    ├── css/main.css
    ├── scss/
    ├── js/header.js
    └── img/
        ├── logo-header.svg
        └── logo-footer.svg
```

---

## Header
- Fixed, full-width background
- Scrolled state: `background: rgba(0,0,0,0.8)` + `backdrop-filter: blur(8px)` — class `is-scrolled`
- 3 sections: Logo | Nav (centered, absolute) | Actions (Контакти + Lang switcher + CTA button)
- Nav uses custom `SteelPlast_Nav_Walker` — renders dropdown toggle as `<button>`
- Dropdown items for "Послуги": 4 inner service pages
- Lang switcher: custom `steelplast_language_switcher()` using `icl_get_languages()`, shows flags + code, 3-col grid dropdown
- CTA button `.btn-contact` — placeholder styles only, full button system TBD

### Nav menu items
Головна / Послуги (dropdown) / Про нас / FAQ / Якість / Новини

### Послуги dropdown
- Механічна обробка металу на верстатах з ЧПУ → `/services/cnc-machining/`
- Фрезерні верстати з ЧПУ → `/services/cnc-milling/`
- Токарні верстати з приводним інструментом → `/services/cnc-turning/`
- Токарні верстати швейцарського типу → `/services/swiss-turning/`

---

## Pages (from Figma)
| Page | Template | Status |
|---|---|---|
| Головна | `front-page.php` | placeholder |
| Послуги | `page-services.php` | placeholder |
| Послуга (inner) | `page-cnc-*.php` / `page-swiss-*.php` | placeholder |
| Про нас | `page-about.php` | placeholder |
| FAQ | `page-faq.php` | placeholder |
| Якість | `page-quality.php` | placeholder |
| Новини | `page-news.php` | placeholder |
| Контакти | `page-contacts.php` | placeholder |

### Recurring blocks (planned)
- **Hero banner** — full-width factory photo bg + large heading
- **CTA section** — dark bg, "Залишились запитання?" + form (name, email, submit)
- **Footer** — logo + description + nav + socials + lang switcher

---

## SEO rules
- `title-tag` managed by WordPress / Yoast
- hreflang: Yoast handles via WPML integration
- No duplicate canonical — `rel_canonical` removed when Yoast active
- All images: explicit `width`/`height`, `loading="lazy"` (except LCP hero image → `loading="eager"`)
- Semantic HTML: one `<h1>` per page, proper heading hierarchy
- `skip-link` for accessibility

---

## Key functions (functions.php)
- `steelplast_scripts()` — enqueue styles/JS with filemtime versioning
- `steelplast_language_switcher()` — custom WPML lang dropdown with flags
- `steelplast_fallback_nav()` — static nav when no WP menu assigned
- `SteelPlast_Nav_Walker` — custom walker, renders parent items as `<button>`
- WPML footer switcher hidden via CSS + `__return_false` filters

---

## Known issues / TODO
- [ ] WPML dev site banner — remove with production key (wpml.org → My Account → Sites)
- [ ] Language auto-redirect in `header.js` — uncomment when all translations ready
- [ ] Button styles system (`_buttons.scss`) — all button variants TBD
- [ ] Footer design — not started
- [ ] All page sections — placeholders only
