# GitHub Copilot Instructions for SteelPlast

## Code Review Guidelines

### WordPress Best Practices
- Always use WordPress helper functions instead of raw PHP globals ($_SERVER, etc.)
- Register widgets on `widgets_init` hook, not `after_setup_theme`
- Use `home_url()`, `site_url()`, `admin_url()` for URLs
- Sanitize all outputs with `esc_html()`, `esc_attr()`, `esc_url()`

### Hooks & Actions
- Prefer `widgets_init` for widget registration
- Use proper priority for SEO-related hooks (hreflang priority 1)
- Check for plugin conflicts (WPML, Polylang, Yoast) before adding functionality

### Accessibility
- Always include `:focus` and `:focus-visible` states for interactive elements
- Use semantic HTML5 tags
- Add ARIA labels where appropriate

### Multilingual Support
- Check for `ICL_SITEPRESS_VERSION` (WPML), `pll_the_languages` (Polylang)
- Prevent duplicate hreflang tags when SEO plugins are active
- Use proper locale formatting (replace `_` with `-`)

## Common Patterns

### Safe URL Building
```php
// ✅ Good
$current_url = home_url( add_query_arg( null, null ) );

// ❌ Bad  
$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
```

### Widget Registration
```php
// ✅ Good
add_action( 'widgets_init', 'theme_widgets_init' );

// ❌ Bad
add_action( 'after_setup_theme', 'theme_widgets_init' );
```

### Template Structure
```php
get_header();
// Content
get_sidebar(); // If theme supports sidebars
get_footer();
```
