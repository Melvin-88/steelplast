# SteelPlast — Project Context

## Project
Custom WordPress theme for SteelPlast (industrial/metalworking company).

Goal:
High-performance, SEO-optimized, Core Web Vitals compliant WordPress site with scalable architecture and multilingual support.

---

# Stack

- CMS: WordPress (LocalWP for local development)
- Language: PHP 8+ + SCSS + Vanilla JavaScript
- No frameworks (no React, no Vue, no jQuery unless absolutely required)
- Build: npm (SCSS compilation only)

---

# Build Commands

npm run build   # compile SCSS → CSS (production, compressed)
npm run watch   # development watcher

Always run npm run build after SCSS changes.

CSS cache busting is handled via filemtime().

---

# Installed Plugins

WPML — Multilingual (10 languages)
Yoast SEO — SEO, sitemap, schema
Wordfence — Security
UpdraftPlus — Backups
WP-Optimize — Cache + optimization
Burst Statistics — Analytics
Antispam Bee — Spam protection
Complianz — GDPR / cookies
Redirection — 301 redirects + 404 tracking

---

# Languages (WPML)

UA (default), EN, PL, FR, IT, LT, LV, ET, CS, DE

Language auto-redirect is disabled in assets/js/header.js (enable later).

---

# Design System

Source: Figma
Style: Industrial dark theme
Accent: #6de2f7
Font: Inter

Colors:
- #f6f6f6
- #6de2f7
- #0f0f0f
- #121c2e
- #090a0c

---

# Layout Rules

- max-width: 1440px
- .content-wrapper padding: 0 32px
- full-width sections
- header height: 80px
- main padding-top: 80px

---

# SCSS Structure

assets/scss/
- main.scss
- _variables.scss
- _typography.scss
- _header.scss

Max nesting depth: 3

---

# JS Rules

- Vanilla JS only
- Event delegation preferred
- No jQuery unless required
- Keep scripts minimal and non-blocking

---

# WordPress Structure

theme/
- front-page.php
- header.php
- footer.php
- functions.php
- page-templates/
- template-parts/
- assets/

---

# Header

- fixed + blur on scroll
- Logo | Nav | Actions
- custom walker menu
- WPML language switcher
- CTA button placeholder

---

# SEO Rules

- one H1 per page
- proper heading hierarchy
- Yoast SEO handles metadata
- images must have width/height
- lazy load images (except hero)

---

# PERFORMANCE RULES (CRITICAL)

Core Web Vitals:
- LCP < 2.5s
- CLS < 0.1
- INP < 200ms

Rules:
- minimize DOM
- avoid layout shifts
- lazy load images
- preload hero image if needed
- defer non-critical JS

---

# WORDPRESS RULES

- no DB queries inside loops
- use WP_Query instead of get_posts
- escape all output (esc_html, esc_attr, esc_url)
- use WordPress APIs only
- keep templates thin

---

# SECURITY

- sanitize all input
- never trust user data
- avoid raw SQL
- escape output always

---

# ACF RULES

- use get_field safely
- flexible content for landing pages
- group fields logically
- WPML compatible

---

# WPML RULES

- no hardcoded text
- use translation functions
- all UI must be multilingual

---

# TEMPLATE GENERATION MODE

When generating templates:
- production-ready code only
- semantic HTML
- responsive design
- accessibility (ARIA if needed)
- include get_header/get_footer
- no dummy placeholders

---

# SEO + STRUCTURE

- one H1 per page
- schema.org where needed
- clean heading hierarchy
- valid semantic HTML

---

# IMAGE RULES

- always width/height
- lazy load by default
- optimize LCP image
- prefer WebP/AVIF

---

# PRINCIPLE

Think like a Senior WordPress Performance Engineer:
optimize for performance, SEO, security, scalability, and maintainability.