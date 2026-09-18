(function () {
  'use strict';

  if (!document.body.classList.contains('wvn-cin-site')) return;

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function markIn(el) {
    if (el) el.classList.add('is-in');
  }

  /* Scroll reveals for cinematic page elements */
  var revealSel = [
    '.wvn-cin-reveal',
    '.wvn-page-hero',
    '.wvn-money-hero',
    '.wvn-money-intro-copy',
    '.wvn-money-contact-card',
    '.wvn-money-service-card',
    '.wvn-money-section-head',
    '.wvn-money-proof-cta',
    '.wvn-money-final-cta',
    '.wvn-money-faq-grid details',
    '.wvn-svc-intro',
    '.wvn-svc-core-head',
    '.wvn-svc-card',
    '.wvn-svc-tile',
    '.wvn-svc-stats',
    '.wvn-blog-card',
    '.wvn-article-layout',
    '.wvn-article-body',
    '.wvn-wedding-hero',
    '.wvn-wedding-overview',
    '.wvn-wedding-event-section',
    '.wvn-wedding-gallery-section',
    '.wvn-cta-box',
    '.wvn-acc details',
    '.wvn-standard-page-header',
    '.wvn-contact-stage',
    '.wvn-contact-copy',
    '.wvn-contact-panel',
    '.wvn-portfolio > h1',
    '.wvn-portfolio > .wvn-lede',
    '.wvn-mosaic a'
  ].join(',');

  var nodes = document.querySelectorAll(revealSel);
  nodes.forEach(function (el, i) {
    if (!el.classList.contains('wvn-cin-reveal')) {
      el.classList.add('wvn-cin-reveal');
    }
    if (!el.hasAttribute('data-delay') && i % 5 !== 0) {
      el.setAttribute('data-delay', String((i % 4) + 1));
    }
  });

  function inFirstScreen(el) {
    var r = el.getBoundingClientRect();
    return r.top < window.innerHeight * 0.92 && r.bottom > 40;
  }

  if (reduce) {
    nodes.forEach(markIn);
  } else if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          markIn(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    nodes.forEach(function (el) {
      if (inFirstScreen(el)) {
        markIn(el);
      } else {
        io.observe(el);
      }
    });
  } else {
    nodes.forEach(markIn);
  }

  /* Subtle scroll parallax on full-bleed heroes */
  if (!reduce) {
    var heroes = document.querySelectorAll(
      '.wvn-money-hero-media, .wvn-page-hero__media, .wvn-wedding-hero, .wvn-svc-hero'
    );
    var ticking = false;

    function updateParallax() {
      ticking = false;
      var vh = window.innerHeight;
      heroes.forEach(function (el) {
        var parent = el.closest('.wvn-money-hero, .wvn-page-hero, .wvn-wedding-hero, .wvn-svc-hero') || el;
        var rect = parent.getBoundingClientRect();
        if (rect.bottom < 0 || rect.top > vh) return;
        var p = (vh - rect.top) / (vh + rect.height);
        var y = (p - 0.5) * 36;
        if (el.classList.contains('wvn-svc-hero') || el.classList.contains('wvn-wedding-hero')) {
          el.style.backgroundPosition = 'center calc(50% + ' + y.toFixed(1) + 'px)';
        } else {
          el.style.transform = 'translate3d(0,' + (y * 0.35).toFixed(1) + 'px,0) scale(1.04)';
        }
      });
    }

    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(updateParallax);
    }, { passive: true });

    updateParallax();
  }
})();
