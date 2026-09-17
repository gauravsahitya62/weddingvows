(function () {
  'use strict';
  var root = document.querySelector('.wvn-cinematic-test');
  if (!root) return;

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isSmall = window.matchMedia && window.matchMedia('(max-width: 560px)').matches;
  var reveals = root.querySelectorAll('.wvn-cine-reveal');

  if (reduceMotion) {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
    return;
  }

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: isSmall ? 0.1 : 0.15, rootMargin: isSmall ? '0px 0px -4% 0px' : '0px 0px -8% 0px' });
    reveals.forEach(function (el) { observer.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }

  var parallaxItems = root.querySelectorAll('[data-cine-parallax]');
  var ticking = false;
  function updateParallax() {
    ticking = false;
    if (reduceMotion) return;
    var viewport = window.innerHeight || 1;
    var strength = isSmall ? 18 : 38;
    parallaxItems.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var media = section.querySelector('.wvn-cine-hero-media, .wvn-cine-full-image img');
      if (!media || rect.bottom < -100 || rect.top > viewport + 100) return;
      var progress = (viewport - rect.top) / (viewport + rect.height);
      var offset = (progress - 0.5) * strength;
      var baseScale = isSmall ? 1.065 : 1.08;
      media.style.transform = 'scale(' + baseScale + ') translate3d(0,' + offset.toFixed(2) + 'px,0)';
    });
  }

  function requestParallax() {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(updateParallax);
    }
  }

  window.addEventListener('scroll', requestParallax, { passive: true });
  window.addEventListener('resize', function () {
    isSmall = window.matchMedia && window.matchMedia('(max-width: 560px)').matches;
    requestParallax();
  }, { passive: true });
  requestParallax();
})();
