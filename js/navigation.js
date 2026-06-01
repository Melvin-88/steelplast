/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens.
 */
(function() {
    const button = document.querySelector('.menu-toggle');
    const menu = document.querySelector('#primary-menu');

    if (!button || !menu) {
        return;
    }

    button.addEventListener('click', function() {
        menu.classList.toggle('toggled');
        
        if (button.getAttribute('aria-expanded') === 'true') {
            button.setAttribute('aria-expanded', 'false');
        } else {
            button.setAttribute('aria-expanded', 'true');
        }
    });
}());