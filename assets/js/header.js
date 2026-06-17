(function () {
    'use strict';

    // Browser language auto-redirect — вмикати після налаштування всіх мов у WPML
    // steelplast_lang_redirect_enable()

    var header = document.getElementById('masthead');
    if (!header) return;

    // Scroll background
    function updateHeaderBg() {
        if (window.scrollY > 0) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    }
    window.addEventListener('scroll', updateHeaderBg, { passive: true });
    updateHeaderBg();

    // Dropdown toggle — nav menu + lang switcher
    var dropdownToggles = document.querySelectorAll('.has-dropdown > .dropdown-toggle, .lang-switcher > .dropdown-toggle');

    function getDropdownParent(btn) {
        return btn.closest('.has-dropdown') || btn.closest('.lang-switcher');
    }

    function closeAllDropdowns() {
        dropdownToggles.forEach(function (btn) {
            btn.setAttribute('aria-expanded', 'false');
            getDropdownParent(btn).classList.remove('is-open');
        });
    }

    dropdownToggles.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = this.getAttribute('aria-expanded') === 'true';
            closeAllDropdowns();
            if (!isOpen) {
                this.setAttribute('aria-expanded', 'true');
                getDropdownParent(this).classList.add('is-open');
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.has-dropdown') && !e.target.closest('.lang-switcher')) {
            closeAllDropdowns();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });

    // Active menu item by current URL
    var currentPath = window.location.pathname;
    document.querySelectorAll('.header-nav__list a').forEach(function (link) {
        var linkPath = new URL(link.href, window.location.origin).pathname;
        if (linkPath === '/' ? currentPath === '/' : currentPath.indexOf(linkPath) === 0 && linkPath !== '/') {
            link.classList.add('is-active');
            var parentDropdown = link.closest('.has-dropdown');
            if (parentDropdown) {
                var toggle = parentDropdown.querySelector('.dropdown-toggle');
                if (toggle) toggle.classList.add('is-active');
            }
        }
    });

    // Mobile burger toggle
    var burger = document.querySelector('.header-burger');
    var nav = document.querySelector('.header-nav');

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            nav.classList.toggle('is-open');
            document.body.classList.toggle('nav-open');
        });
    }
}());
