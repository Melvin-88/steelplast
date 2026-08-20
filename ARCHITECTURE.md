# SteelPlast Theme — Architecture

Опис поточного стану кастомної WordPress-теми SteelPlast. Це знімок структури проєкту (2026-07-10) — доповнюй цей файл у міру розвитку теми, не покладайся на нього як на єдине джерело правди для деталей коду (дивись сам код).

Бізнес-контекст, дизайн-систему, стек і правила розробки дивись у `CLAUDE.md` — цей файл описує **як усе влаштовано технічно**, `CLAUDE.md` — **за якими правилами писати новий код**.

---

## 1. Огляд

Кастомна тема (без фреймворків, класичний PHP-темплейтинг, без Gutenberg full-site-editing) для промислового сайту SteelPlast (лиття пластмас, прес-форми, механообробка металу). 10 мов через WPML, контент — через ACF, глобальні налаштування — через Customizer.

## 2. Точки входу / bootstrap

- `functions.php` (~1100+ рядків) — головний bootstrap теми: theme support, меню, віджети, enqueue скриптів/стилів, WPML string reєстрація, хелпери (`steelplast_t`, `steelplast_mod`, `steelplast_post_thumbnail`, `steelplast_reading_time`, `steelplast_language_switcher`), кастомний `SteelPlast_Nav_Walker`.
- `functions.php` підключає три файли з `inc/`:
  - `inc/customizer.php` — реєстрація полів WordPress Customizer (соцмережі, телефон, email, адреса — глобальні налаштування сайту).
  - `inc/contact-form.php` — серверна обробка форми контактів (AJAX-ендпойнт, валідація, надсилання email).
  - `inc/acf-fields.php` — реєстрація всіх ACF-груп полів програмно (`acf_add_local_field_group` або аналог), згруповано по сторінках/секціях.
- `header.php` / `footer.php` — глобальний каркас: `<head>`, header з логотипом/навігацією/CTA/мовним перемикачем, footer з колонками (лого+опис, меню, соцмережі+мова), підключення `modal-quick-contact` перед `wp_footer()`.
- `index.php`, `page.php`, `single.php`, `archive.php`, `front-page.php`, `sidebar.php` — стандартна WP template hierarchy.

## 3. Сторінки (page-templates/)

Кожна кастомна сторінка — окремий PHP-файл, обраний через "Шаблон сторінки" в адмінці (WordPress **не** призначає шаблон автоматично для вже існуючих сторінок — треба вручну вибрати в редакторі).

| Файл | Призначення |
|---|---|
| `template-about.php` | Про компанію |
| `template-services.php` | Загальний список послуг (частково stub) |
| `template-service-inner.php` | Спільний шаблон для внутрішніх сторінок послуг (якщо не є окремим файлом) |
| `template-cnc-machining.php`, `template-cnc-milling.php`, `template-cnc-turning.php`, `template-swiss-turning.php` | Механообробка (фрезерування/точіння/швейцарське точіння) |
| `template-metal-stamping.php` | Штампування металу |
| `template-injection-molding.php` | Лиття пластмас |
| `template-mold-manufacturing.php` | Виготовлення прес-форм і штампів |
| `template-custom-tooling.php` | Технологічне оснащення |
| `template-quality.php` | Якість / сертифікація |
| `template-contacts.php` / `page-contacts.php` | Контакти |
| `template-faq.php` | FAQ |
| `template-news.php` / `page-news.php` | Новини (архів) |
| `styleguide.php` | Внутрішній styleguide для розробки |

Усі сторінкові шаблони, що показують секцію контактної форми, мають бути додані до масиву `$contact_form_templates` у `functions.php` — інакше не підʼєднається JS/CSS для поля телефону (intl-tel-input).

### Патерн типової сторінки послуги (service page)

Секції чергують темний/світлий фон (ніколи два однакові підряд), нумеровані лейбли `[01]`, `[02]`... (не завжди наскрізно на сторінці — інколи стартують заново по групах контенту, звіряй з Figma):

1. `page-hero` — заголовок під SEO-ключі, `page_hero_image` (ACF)
2. `section-service-specs` — темна, картки 2×2 (матеріали/процеси/допуски/терміни)
3. `section-service-content` — світла, лонгрід у 2 колонки
4. `section-about-preview` — темна, перевикористання з головної
5. `section-quality` — світла, перевикористання з головної
6. `section-contact` — без оверайдів (уніфікована на всіх сторінках)

## 4. template-parts/ — секції та компоненти

Логіка розбита на дрібні, переважно однопризначені partial-и:

- **Головна**: `home-services.php`
- **Про компанію**: `section-about-intro.php`, `section-about-advantages.php`, `section-about-audience.php`, `section-about-equipment.php`, `section-about-preview.php` (переюзається і на інших сторінках)
- **Якість**: `section-quality.php`, `section-quality-certification.php`, `section-quality-equipment.php`, `section-quality-reliability.php`
- **Послуги**: `section-service-content.php`, `section-service-specs.php`
- **Співпраця**: `section-collaboration.php`
- **Контакти**: `section-contact.php`, `contact-form.php` (форма), `modal-quick-contact.php` (спливаюча форма зі шапки)
- **Новини**: `section-news.php`, `post-card.php`, `content.php`, `content-none.php`
- **Загальне**: `page-hero.php` (хедер сторінки), `component-image-card.php` (картка з фото + placeholder-градієнт якщо фото ще нема)

Секції приймають аргументи (`get_template_part` + `args`), щоб одна секція обслуговувала кілька сторінок з різним контентом (наприклад `section-service-specs` бере масив `cards` з різними типами блоків: `bullets`/`group`/`stat`/`badges`/`text`).

## 5. Дизайн-система / SCSS

`assets/scss/` — один файл на секцію/компонент, підключені через `main.scss`. Спільні токени:

- `_variables.scss` — кольори, брейкпоінти
- `_typography.scss` — шрифти + спільні класи `.sp-section` (padding 60px 0), `.sp-section-title` (64px/700/uppercase), `.sp-section-desc` (16px/400) — обовʼязкові для кожної нової секції
- Решта файлів — layout/оформлення конкретного блоку, без дублювання типографіки

Усі кастомні класи мають префікс `sp-` (уникнення конфліктів з адблокерами/плагінами).

Білд: `npm run build` (sass → `assets/css/main.css`, compressed) — обовʼязково після кожної зміни SCSS. Кеш CSS у браузері — через `filemtime()`. **Важливо**: якщо активний WP-Optimize Minify, після білда треба ще й скинути його кеш ("Reset the minified files" в адмінці) — інакше сайт віддає застарілий CSS bundle навіть після ребілда і хард-релоуду.

## 6. JS

`assets/js/` — vanilla JS, по одному файлу на фічу, підключаються через `wp_enqueue_script` у `functions.php`:

- `header.js` — бургер-меню, мовний auto-redirect (наразі вимкнений)
- `animations.js` — скролл-анімації
- `modal.js` — логіка спливаючого `modal-quick-contact`
- `contact-form.js` — валідація + AJAX-відправка форми контактів, робота з `intl-tel-input` (телефонне поле)
- `collaboration.js`, `faq.js` — інтерактив відповідних секцій
- `vendor/` — сторонні бібліотеки (intl-tel-input)

## 7. Дані: де що зберігати

Три чіткі шари, не змішувати:

| Тип даних | Де | Хелпер |
|---|---|---|
| Глобальні налаштування сайту (соцмережі, телефон, email, адреса) | WordPress **Customizer** (`inc/customizer.php`) | `steelplast_mod( $key )` |
| UI-тексти, що перекладаються (заголовки, підписи, CTA, помилки форми) | **WPML String Translation** | `steelplast_t( $context, $key, $default )`, реєструються через `icl_register_string()` у `steelplast_register_wpml_strings()` (`functions.php`) |
| Контент сторінок / секцій / динамічні блоки (фото, картки, специфікації) | **ACF** (`inc/acf-fields.php`, groups scoped per template) | `get_field()` |

Контекст WPML-рядків завжди `steelplast/{page-slug}/{section}` (ніколи просто `steelplast`), дефолтні значення в PHP — англійською, кирилиця вводиться лише як UA-переклад в адмінці WPML.

## 8. Багатомовність (WPML)

10 мов: UA (дефолтна), EN, PL, FR, IT, LT, LV, ET, CS, DE. Auto-redirect за мовою браузера вимкнений у `header.js` (увімкнути пізніше, коли переклади будуть готові для всіх мов). Переклад сторінок робиться через Classic Translation Editor (не cloud Advanced Translation Editor — той недоступний з автоматизації). Кожна мова має власне окреме меню в Appearance → Menus — зміни в навігації/структурі треба повторювати в кожній мовній версії меню окремо.

## 9. Контактна форма

- `template-parts/contact-form.php` — розмітка форми (спільна для сторінки контактів і модалки)
- `template-parts/modal-quick-contact.php` — спливаюча версія (відкривається кнопкою в хедері, `data-sp-modal-open="quick-contact"`)
- `assets/js/contact-form.js` — клієнтська валідація + AJAX
- `inc/contact-form.php` — серверний обробник (nonce/rate-limit, відправка email)
- `section-contact.php` рендериться **ідентично на кожній сторінці**, без пер-сторінкових оверайдів

## 10. Відомі незавершені місця

- `/services/` (`template-services.php`) — досі загальний stub, має перелічувати/лінкувати всі 5 service-сторінок
- Кнопкова система стилів (`.btn-contact` тощо) ще не побудована повністю як окрема система
- Секція обладнання на сторінці "Про компанію" — 6-й слот (`about_equipment_card_6_*`) зарезервований, але свідомо не заповнений (немає фото/контенту)
- Лазерне різання і порошкове фарбування — є картки на головній, але ще немає окремих service-сторінок (CTA свідомо не показується)
