/**
 * Site motion — GSAP + ScrollTrigger + SplitText.
 *
 * The templates are not touched: everything hangs off classes and the
 * data-sp-* hooks already in the markup.
 *
 * Safety net: an inline script in <head> adds .sp-motion to <html> (unless the
 * visitor asked for reduced motion) and _motion.scss keeps the animated blocks
 * out of the first paint. This file sets its own starting states, then adds
 * .sp-motion-ready. If it never runs, the stylesheet shows the page by itself
 * after 2.5 s; if GSAP is missing, it shows it at once.
 *
 * What moves:
 *   intro          first screen: video settles, headline rises line by line, figures count up
 *   sectionHeaders label wipes in, heading rises out of a mask, the rest follows
 *   media          large photos open like a shutter
 *   photoShapes    the three photo shapes slide in from alternating sides
 *   cardGroups     cards rise in a cascade, their photos zoom out into place
 *   stairs         "How we work" builds itself as the visitor scrolls
 *   contactForm    form fields slide in one after another
 *   footer         columns rise in
 *   tilt           service cards lean towards the cursor (mouse only)
 */
(function () {
    var root = document.documentElement;

    if (!window.gsap || !window.ScrollTrigger || !window.SplitText) {
        root.classList.remove('sp-motion');
        return;
    }

    gsap.registerPlugin(ScrollTrigger, SplitText);
    gsap.defaults({ ease: 'power3.out', duration: 0.9 });

    var desktop = window.matchMedia('(min-width: 1025px)').matches;
    var mouse = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    // Blocks that already have their own animation, so leftovers() skips them.
    var claimed = [];

    // Headings are split into lines, which only works once the webfont has
    // set the line breaks. Capped so a slow font cannot hold the intro back.
    var fonts = document.fonts && document.fonts.ready
        ? Promise.race([document.fonts.ready, new Promise(function (done) { setTimeout(done, 1200); })])
        : Promise.resolve();

    fonts.then(function () {
        gsap.matchMedia().add('(prefers-reduced-motion: no-preference)', function () {
            intro();
            sectionHeaders();
            media();
            photoShapes();
            cardGroups();
            stairs();
            contactForm();
            footer();
            leftovers();
            if (mouse) tilt();

            root.classList.add('sp-motion-ready');
        });
    });

    // ── Helpers ───────────────────────────────────────────────────────────

    function all(selector, scope) {
        return gsap.utils.toArray((scope || document).querySelectorAll(selector));
    }

    // Plays a paused timeline the first time its block is scrolled to.
    function playOnScroll(trigger, timeline, start) {
        ScrollTrigger.create({
            trigger: trigger,
            start: start || 'top 85%',
            once: true,
            onEnter: function () { timeline.play(); },
        });
    }

    // Lines rise out of their own mask. Afterwards the heading goes back to
    // plain text, so it reflows normally when the window is resized.
    function riseLines(timeline, heading, position) {
        var split = SplitText.create(heading, { type: 'lines', mask: 'lines' });

        timeline.from(split.lines, {
            yPercent: 110,
            duration: 1.1,
            ease: 'expo.out',
            stagger: 0.1,
            onComplete: function () { split.revert(); },
        }, position);
    }

    // Reveals a block from one edge. `from` is the inset that hides it.
    function wipe(timeline, el, from, vars, position) {
        timeline.fromTo(el, { clipPath: from }, Object.assign({
            clipPath: 'inset(0% 0% 0% 0%)',
            clearProps: 'clipPath',
        }, vars), position);
    }

    // A figure that counts up from zero to the value the server printed.
    function countUp(el) {
        var target = parseFloat(el.getAttribute('data-sp-count'));
        if (isNaN(target)) return null;

        var decimals = parseInt(el.getAttribute('data-sp-count-decimals'), 10) || 0;
        var unit = el.getAttribute('data-sp-count-unit') || '%s';
        var point = el.getAttribute('data-sp-count-point') || '.';
        var state = { value: 0 };

        // Same output as steelplast_hero_stat() in PHP: the unit pattern and the
        // decimal mark come from the server, so "10,9 Mio." animates as itself.
        function format(value) {
            return unit.replace('%s', value.toFixed(decimals).replace('.', point));
        }

        function render() {
            el.textContent = format(state.value);
        }

        // Screen readers get the final value once, not every frame.
        el.setAttribute('aria-label', format(target));
        render();

        return gsap.to(state, { value: target, duration: 2.4, ease: 'power2.out', onUpdate: render });
    }

    // ── First screen ──────────────────────────────────────────────────────

    function intro() {
        var hero = document.querySelector('.sp-hero');
        var timeline = gsap.timeline({ delay: 0.1 });

        if (hero) {
            timeline.from('.sp-hero__video', { scale: 1.14, duration: 2.4, ease: 'power2.out' }, 0);
            riseLines(timeline, hero.querySelector('.sp-hero__title'), 0.15);
            timeline
                .from('.sp-hero__description', { opacity: 0, y: 24 }, 0.6)
                .from('.sp-hero__stat', { opacity: 0, y: 48, stagger: 0.12 }, 0.75)
                .from('.sp-hero__stat-divider', {
                    scaleX: 0,
                    transformOrigin: 'left center',
                    duration: 1.2,
                    ease: 'expo.out',
                    stagger: 0.12,
                }, 0.95);

            all('[data-sp-count]', hero).forEach(function (el, i) {
                var count = countUp(el);
                if (count) timeline.add(count, 0.85 + i * 0.12);
            });

            // Scrolling away: the copy lifts and dims while the video lags behind.
            gsap.timeline({
                defaults: { ease: 'none' },
                scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true },
            })
                .to('.sp-hero__inner', { yPercent: -12, opacity: 0.1 }, 0)
                .to('.sp-hero__video', { yPercent: 14 }, 0);

            return;
        }

        // Inner pages: banner photo settles, the page title rises.
        var banner = document.querySelector('.sp-page-hero, .sp-single-post__cover, .sp-contacts-page__hero');
        if (!banner) return;

        var photo = banner.querySelector('.sp-page-hero__img, .sp-single-post__cover-img');
        var title = banner.querySelector('h1');
        var lead = banner.querySelector('.sp-contacts-page__intro');

        if (photo) {
            timeline.from(photo, { scale: 1.16, duration: 2.2, ease: 'power2.out' }, 0);
            gsap.to(photo, {
                yPercent: 12,
                ease: 'none',
                scrollTrigger: { trigger: banner, start: 'top top', end: 'bottom top', scrub: true },
            });
        }
        if (title) riseLines(timeline, title, 0.1);
        if (lead) timeline.from(lead, { opacity: 0, y: 24 }, 0.5);
    }

    // ── Section headers ───────────────────────────────────────────────────

    function sectionHeaders() {
        all('[data-sp-animate]').forEach(function (block) {
            var headings = all('.sp-section-title, h2', block);
            if (!headings.length || block.parentElement.hasAttribute('data-sp-animate-group')) return;

            var timeline = gsap.timeline({ paused: true });

            all('.sp-section-label, .sp-about-preview__tag', block).forEach(function (label) {
                wipe(timeline, label, 'inset(0% 100% 0% 0%)', { duration: 0.8, ease: 'power3.inOut' }, 0);
            });

            headings.forEach(function (heading) {
                riseLines(timeline, heading, 0.1);
            });

            var rest = all('.sp-section-desc, .sp-btn, li, .sp-quality-cert__download', block);
            if (rest.length) {
                timeline.from(rest, { opacity: 0, y: 24, duration: 0.8, stagger: 0.07 }, 0.4);
            }

            claimed.push(block);
            playOnScroll(block, timeline);
        });
    }

    // ── Large photos open like a shutter ──────────────────────────────────

    function media() {
        all('.sp-about-audience__image, .sp-quality-reliability__image, .sp-quality-cert__image').forEach(function (frame) {
            var timeline = gsap.timeline({ paused: true });

            wipe(timeline, frame, 'inset(0% 0% 100% 0%)', { duration: 1.3, ease: 'expo.inOut' }, 0);
            timeline.from(all('img', frame), { scale: 1.3, duration: 1.8, ease: 'power3.out', clearProps: 'transform' }, 0);

            claimed.push(frame);
            playOnScroll(frame, timeline, 'top 80%');
        });
    }

    // ── Home page: the three photo shapes ─────────────────────────────────

    function photoShapes() {
        var group = document.querySelector('.sp-about-preview__images');
        if (!group) return;

        var shapes = all('.sp-about-preview__shape', group);
        var timeline = gsap.timeline({ paused: true });

        // Sideways only, from alternating sides: the shapes overlap vertically
        // by design, so any vertical travel pushes them into each other.
        timeline.from(shapes, {
            opacity: 0,
            x: function (i) { return i % 2 ? -90 : 90; },
            duration: 1.2,
            ease: 'expo.out',
            stagger: 0.14,
            clearProps: 'opacity,transform',
        });

        claimed.push(group);
        playOnScroll(group, timeline, 'top 80%');
    }

    // ── Card grids ────────────────────────────────────────────────────────

    function cardGroups() {
        all('[data-sp-animate-group]').forEach(function (group) {
            var cards = all('[data-sp-animate]', group).filter(function (card) {
                return card.parentElement === group;
            });
            if (!cards.length) return;

            var photos = all('.sp-services__card-image img, .sp-about-equipment__card-media img', group);

            gsap.set(cards, { opacity: 0, y: 64 });
            gsap.set(photos, { scale: 1.25 });

            // Cards that scroll in together (a row) cascade together.
            ScrollTrigger.batch(cards, {
                start: 'top 88%',
                once: true,
                onEnter: function (row) {
                    gsap.to(row, { opacity: 1, y: 0, stagger: 0.1, clearProps: 'opacity' });

                    row.forEach(function (card, i) {
                        var photo = photos.filter(function (img) { return card.contains(img); });
                        if (photo.length) {
                            gsap.to(photo, { scale: 1, duration: 1.6, delay: i * 0.1, clearProps: 'transform' });
                        }
                    });
                },
            });

            cards.forEach(function (card) { claimed.push(card); });
        });
    }

    // ── "How we work": the staircase builds itself with the scroll ────────

    function stairs() {
        var list = document.querySelector('.sp-collab__steps');
        if (!list) return;

        var steps = all('.sp-collab__step', list);
        var timeline = gsap.timeline({
            defaults: { ease: 'none' },
            scrollTrigger: {
                trigger: list,
                start: 'top 85%',
                end: desktop ? 'top 30%' : 'bottom 75%',
                scrub: 0.6,
            },
        });

        steps.forEach(function (step, i) {
            // Each column grows up from the baseline, then its text settles in.
            timeline
                .fromTo(step,
                    { clipPath: 'inset(100% 0% 0% 0%)' },
                    { clipPath: 'inset(0% 0% 0% 0%)', duration: 1, ease: 'power2.out' },
                    i * 0.8)
                .from(step.children, { opacity: 0, y: 20, duration: 0.6, stagger: 0.15 }, i * 0.8 + 0.45);
        });

        // The baseline fills from left to right in step with the columns (see _collaboration.scss).
        timeline.fromTo(list,
            { '--sp-collab-progress': '0%' },
            { '--sp-collab-progress': '100%', duration: timeline.duration() },
            0);
    }

    // ── Contact section: the form assembles field by field ────────────────

    function contactForm() {
        all('.sp-contact-section__form-wrap').forEach(function (wrap) {
            var fields = all('.sp-form-field, .sp-contact-form__actions', wrap);
            if (!fields.length) return;

            var timeline = gsap.timeline({ paused: true })
                .from(fields, { opacity: 0, x: 40, duration: 0.8, stagger: 0.08, clearProps: 'opacity,transform' });

            claimed.push(wrap);
            playOnScroll(wrap, timeline, 'top 82%');
        });
    }

    // ── Footer ────────────────────────────────────────────────────────────

    function footer() {
        var columns = all('.sp-footer__col');
        if (!columns.length) return;

        var timeline = gsap.timeline({ paused: true })
            .from(columns, { opacity: 0, y: 32, stagger: 0.1, clearProps: 'opacity,transform' });

        playOnScroll(columns[0].parentElement, timeline, 'top 92%');
    }

    // ── Anything else marked for animation simply rises in ────────────────

    function leftovers() {
        all('[data-sp-animate]').forEach(function (block) {
            if (claimed.indexOf(block) !== -1) return;

            var timeline = gsap.timeline({ paused: true })
                .from(block, { opacity: 0, y: 40, clearProps: 'opacity,transform' });

            playOnScroll(block, timeline, 'top 88%');
        });
    }

    // ── Service cards lean towards the cursor ─────────────────────────────

    function tilt() {
        all('.sp-services__card').forEach(function (card) {
            var tiltX = gsap.quickTo(card, 'rotationX', { duration: 0.6, ease: 'power3.out' });
            var tiltY = gsap.quickTo(card, 'rotationY', { duration: 0.6, ease: 'power3.out' });

            card.addEventListener('pointermove', function (event) {
                var box = card.getBoundingClientRect();
                gsap.set(card, { transformPerspective: 900 });
                tiltY(((event.clientX - box.left) / box.width - 0.5) * 6);
                tiltX(((event.clientY - box.top) / box.height - 0.5) * -6);
            });

            card.addEventListener('pointerleave', function () {
                tiltX(0);
                tiltY(0);
            });
        });
    }
})();
