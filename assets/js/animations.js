/**
 * Scroll-reveal animations.
 *
 * Progressive enhancement: without JS every [data-sp-animate] element is
 * fully visible (default CSS has no hidden state). Only once this script
 * runs do we mark <html> with .js-animate, which is what actually hides
 * elements before they are revealed — so a slow/failed script load never
 * leaves content invisible.
 *
 * Elements already inside the viewport on load are revealed immediately
 * without a transition, so hero/above-the-fold content never delays LCP
 * or flashes hidden-then-visible. Only below-the-fold content animates
 * in as the user scrolls to it.
 */
(function () {
    var elements = document.querySelectorAll('[data-sp-animate]');
    if (!elements.length) return;

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion || !('IntersectionObserver' in window)) {
        elements.forEach(function (el) {
            el.classList.add('sp-in-view');
        });
        return;
    }

    document.documentElement.classList.add('js-animate');

    var viewportHeight = window.innerHeight;

    var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('sp-in-view');
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -10% 0px',
    });

    elements.forEach(function (el) {
        var rect = el.getBoundingClientRect();
        var alreadyVisible = rect.top < viewportHeight && rect.bottom > 0;

        if (alreadyVisible) {
            el.classList.add('sp-in-view', 'sp-no-transition');
            return;
        }

        observer.observe(el);
    });
})();
