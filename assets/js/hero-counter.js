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

    // Same output as steelplast_hero_stat() in PHP: the unit pattern and the
    // decimal mark come from the server, so "10,9 Mio." animates as itself.
    function format(value, decimals, unit, point) {
        return unit.replace('%s', value.toFixed(decimals).replace('.', point));
    }

    function run(el) {
        var target = parseFloat(el.getAttribute('data-sp-count'));
        if (isNaN(target)) return;

        var decimals = parseInt(el.getAttribute('data-sp-count-decimals'), 10) || 0;
        var unit = el.getAttribute('data-sp-count-unit') || '%s';
        var point = el.getAttribute('data-sp-count-point') || '.';
        var started = null;

        function render(value) {
            el.textContent = format(value, decimals, unit, point);
        }

        // Screen readers get the final value once, not every frame.
        el.setAttribute('aria-label', format(target, decimals, unit, point));

        render(0);

        function step(now) {
            if (started === null) started = now;

            var progress = Math.min((now - started) / DURATION, 1);
            var eased = 1 - Math.pow(1 - progress, 3);

            render(target * eased);

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                render(target);
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
