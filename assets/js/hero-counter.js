/**
 * Hero counters — count up from 0 to the figure already in the markup.
 *
 * Progressive enhancement: the final number is rendered server-side, so
 * without JS (or with reduced motion) the visitor simply sees it straight
 * away. Only when this script runs is the number rewound to 0 and animated.
 *
 * The easing is cubic ease-out, so the count sprints at the start and
 * crawls over the last digits, which is what makes it read as a tally
 * settling rather than a linear ticker.
 */
(function () {
    var DURATION = 3000;

    var elements = document.querySelectorAll('[data-sp-count]');
    if (!elements.length) return;

    var reduceMotion = window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion || !window.requestAnimationFrame) return;

    function render(el, value, decimals, suffix) {
        el.textContent = value.toFixed(decimals) + suffix;
    }

    function run(el) {
        var target = parseFloat(el.getAttribute('data-sp-count'));
        if (isNaN(target)) return;

        var decimals = parseInt(el.getAttribute('data-sp-count-decimals'), 10) || 0;
        var suffix = el.getAttribute('data-sp-count-suffix') || '';
        var started = null;

        // Screen readers get the final value once, not every frame.
        el.setAttribute('aria-label', target.toFixed(decimals) + suffix);

        render(el, 0, decimals, suffix);

        function step(now) {
            if (started === null) started = now;

            var progress = Math.min((now - started) / DURATION, 1);
            var eased = 1 - Math.pow(1 - progress, 3);

            render(el, target * eased, decimals, suffix);

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                render(el, target, decimals, suffix);
            }
        }

        requestAnimationFrame(step);
    }

    if (!('IntersectionObserver' in window)) {
        Array.prototype.forEach.call(elements, run);
        return;
    }

    var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            obs.unobserve(entry.target);
            run(entry.target);
        });
    }, { threshold: 0.4 });

    Array.prototype.forEach.call(elements, function (el) {
        observer.observe(el);
    });
})();
