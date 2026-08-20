/**
 * Generic modal open/close — sitewide, reusable for any modal.
 *
 * Trigger any modal from anywhere by adding `data-sp-modal-open="<id>"`
 * to a link or button, where <id> matches a modal's `data-sp-modal="<id>"`
 * attribute. Elements inside a modal with `data-sp-modal-close` (overlay,
 * close button) close it. Escape closes the currently open modal.
 */
(function () {
    'use strict';

    var lastFocused = null;

    function getModal(id) {
        return document.querySelector('[data-sp-modal="' + id + '"]');
    }

    function openModal(id) {
        var modal = getModal(id);
        if (!modal) return;

        lastFocused = document.activeElement;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('sp-modal-open');

        var focusable = modal.querySelector('input, textarea, button, [href]');
        if (focusable) focusable.focus();
    }

    function closeModal(modal) {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('sp-modal-open');
        if (lastFocused) lastFocused.focus();
    }

    document.addEventListener('click', function (e) {
        var opener = e.target.closest('[data-sp-modal-open]');
        if (opener) {
            e.preventDefault();
            openModal(opener.getAttribute('data-sp-modal-open'));
            return;
        }

        var closer = e.target.closest('[data-sp-modal-close]');
        if (closer) {
            var modal = closer.closest('.sp-modal');
            if (modal) closeModal(modal);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var open = document.querySelector('.sp-modal.is-open');
        if (open) closeModal(open);
    });
})();
