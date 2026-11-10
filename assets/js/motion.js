/**
 * Site animations — GSAP + ScrollTrigger.
 *
 * Progressive enhancement: the markup and the CSS describe the finished page.
 * Every starting state (hidden block, zeroed counter, flat steps) is set here,
 * so if GSAP fails to load, or the visitor asked for reduced motion, nothing
 * is hidden and nothing moves.
 *
 * Hooks in the markup:
 *   [data-sp-animate]        block that fades up when scrolled to
 *   [data-sp-animate-group]  its [data-sp-animate] children cascade in
 *   [data-sp-count]          number that counts up from zero
 *   .sp-collab__steps        staircase that grows from a flat row
 */
(function () {
    if (!window.gsap || !window.ScrollTrigger) return;

    gsap.registerPlugin(ScrollTrigger);

    gsap.matchMedia().add('(prefers-reduced-motion: no-preference)', function () {
        reveals();
        counters();
        collaborationSteps();
    });

    // ── Blocks fade up as they are scrolled to ────────────────────────────
    function reveals() {
        gsap.utils.toArray('[data-sp-animate]').forEach(function (el) {
            // Already on screen at load: left as is, so the first paint never
            // flashes hidden-then-visible and LCP is not delayed.
            if (ScrollTrigger.isInViewport(el)) return;

            gsap.set(el, { opacity: 0, y: 28 });

            ScrollTrigger.create({
                trigger: el,
                start: '15% 90%',
                once: true,
                onEnter: function () {
                    gsap.to(el, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: 'expo.out',
                        delay: groupDelay(el),
                        // Hand the element back to the stylesheet, hover transforms included.
                        clearProps: 'opacity,transform',
                    });
                },
            });
        });
    }

    // Cards in a group cascade by their position in the row, first eight only.
    function groupDelay(el) {
        var group = el.parentElement;
        if (!group || !group.hasAttribute('data-sp-animate-group')) return 0;

        var index = Array.prototype.indexOf.call(group.children, el);
        return index < 8 ? index * 0.08 : 0;
    }

    // ── Hero figures count up from zero ───────────────────────────────────
    function counters() {
        gsap.utils.toArray('[data-sp-count]').forEach(function (el) {
            var target = parseFloat(el.getAttribute('data-sp-count'));
            if (isNaN(target)) return;

            var decimals = parseInt(el.getAttribute('data-sp-count-decimals'), 10) || 0;
            var unit = el.getAttribute('data-sp-count-unit') || '%s';
            var point = el.getAttribute('data-sp-count-point') || '.';
            var state = { value: 0 };

            // Same output as steelplast_hero_stat() in PHP: the unit pattern and
            // the decimal mark come from the server, so "10,9 Mio." animates as itself.
            function format(value) {
                return unit.replace('%s', value.toFixed(decimals).replace('.', point));
            }

            function render() {
                el.textContent = format(state.value);
            }

            ScrollTrigger.create({
                trigger: el,
                start: '40% bottom',
                once: true,
                onEnter: function () {
                    // Screen readers get the final value once, not every frame.
                    el.setAttribute('aria-label', format(target));
                    render();
                    // Cubic ease-out: sprints at the start, crawls over the last digits.
                    gsap.to(state, { value: target, duration: 3, ease: 'power2.out', onUpdate: render });
                },
            });
        });
    }

    // ── "How we work" steps grow from a flat row into a staircase ─────────
    function collaborationSteps() {
        var list = document.querySelector('.sp-collab__steps');
        if (!list) return;

        // The staircase heights live in the stylesheet; only the flat start is set here.
        var grow = gsap.from(list.children, {
            minHeight: 180,
            duration: 0.7,
            ease: 'power1.out',
            paused: true,
            clearProps: 'minHeight',
        });

        ScrollTrigger.create({
            trigger: list,
            start: '30% bottom',
            once: true,
            onEnter: function () {
                grow.delay(0.4).restart(true);
            },
        });
    }
})();
