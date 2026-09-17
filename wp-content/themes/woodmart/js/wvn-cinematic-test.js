(function () {
  'use strict';
  if (!document.querySelector('.wvn-cinematic-test')) return;

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var reveals = document.querySelectorAll('.wvn-cine-reveal');

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
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
    reveals.forEach(function (el) { observer.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }

  var parallaxItems = document.querySelectorAll('[data-cine-parallax]');
  var ticking = false;
  function updateParallax() {
    ticking = false;
    var viewport = window.innerHeight || 1;
    parallaxItems.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var media = section.querySelector('.wvn-cine-hero-media, .wvn-cine-full-image img');
      if (!media) return;
      if (rect.bottom < -100 || rect.top > viewport + 100) return;
      var progress = (viewport - rect.top) / (viewport + rect.height);
      var offset = (progress - 0.5) * 38;
      media.style.transform = 'scale(1.08) translate3d(0,' + offset.toFixed(2) + 'px,0)';
    });
  }
  function requestParallax() {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(updateParallax);
    }
  }
  window.addEventListener('scroll', requestParallax, { passive: true });
  window.addEventListener('resize', requestParallax);
  requestParallax();
})();
