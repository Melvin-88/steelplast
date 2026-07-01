(function () {
    'use strict';

    // Browser language auto-redirect — вмикати після налаштування всіх мов у WPML
    // steelplast_lang_redirect_enable()

    var header = document.getElementById('masthead');
    if (!header) return;

    // Scroll background
    function updateHeaderBg() {
        if (window.scrollY > 50) {
            header.classList.add('sp-is-scrolled');
        } else {
            header.classList.remove('sp-is-scrolled');
        }
    }
    window.addEventListener('scroll', updateHeaderBg, { passive: true });
    updateHeaderBg();

    // Dropdown toggle — nav menu + lang switcher
    var dropdownToggles = document.querySelectorAll('.sp-has-dropdown > .sp-dropdown__toggle, .sp-lang > .sp-dropdown__toggle');

    function getDropdownParent(btn) {
        return btn.closest('.sp-has-dropdown') || btn.closest('.sp-lang');
    }

    function closeAllDropdowns() {
        dropdownToggles.forEach(function (btn) {
            btn.setAttribute('aria-expanded', 'false');
            getDropdownParent(btn).classList.remove('sp-is-open');
        });
    }

    function positionDropdown(parent) {
        var dropdown = parent.querySelector('.sp-lang__dropdown, .sp-nav__dropdown');
        if (!dropdown) return;

        parent.classList.remove('sp-drop-up');
        var rect = dropdown.getBoundingClientRect();
        var spaceBelow = window.innerHeight - rect.bottom;

        if (spaceBelow < 0) {
            parent.classList.add('sp-drop-up');
        }
    }

    dropdownToggles.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = this.getAttribute('aria-expanded') === 'true';
            closeAllDropdowns();
            if (!isOpen) {
                this.setAttribute('aria-expanded', 'true');
                var parent = getDropdownParent(this);
                parent.classList.add('sp-is-open');
                positionDropdown(parent);
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.sp-has-dropdown') && !e.target.closest('.sp-lang')) {
            closeAllDropdowns();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });

    // Active menu item by current URL.
    // The home link (data-nav-home, set server-side) always needs an exact
    // match — under WPML with language directories its path (e.g. "/en/")
    // is a prefix of every other page's path, so a "starts with" match
    // would keep it highlighted everywhere. Other links keep prefix
    // matching so e.g. "/news/" stays active on single article pages.
    var currentPath = window.location.pathname;
    document.querySelectorAll('.sp-nav__list a').forEach(function (link) {
        var linkPath = new URL(link.href, window.location.origin).pathname;
        var isHomeLink = link.dataset.navHome === '1';
        var isActive = isHomeLink
            ? currentPath === linkPath
            : linkPath !== '/' && currentPath.indexOf(linkPath) === 0;
        if (isActive) {
            link.classList.add('sp-is-active');
            var parentDropdown = link.closest('.sp-has-dropdown');
            if (parentDropdown) {
                var toggle = parentDropdown.querySelector('.sp-dropdown__toggle');
                if (toggle) toggle.classList.add('sp-is-active');
            }
        }
    });

    // Mobile burger toggle
    var burger = document.querySelector('.sp-header__burger');
    var nav = document.querySelector('.sp-header__nav');

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            nav.classList.toggle('sp-is-open');
            document.body.classList.toggle('sp-nav-open');
        });
    }
}());
