(function () {
  'use strict';
  var root = document.querySelector('.wvn-cinematic-test');
  if (!root) return;

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var isSmall = window.matchMedia && window.matchMedia('(max-width: 560px)').matches;
  var reveals = root.querySelectorAll('.wvn-cine-reveal');

  function revealNow(el) { el.classList.add('is-visible'); }

  if (reduceMotion) {
    reveals.forEach(revealNow);
  } else if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        revealNow(entry.target);
        observer.unobserve(entry.target);
      });
    }, { threshold: isSmall ? 0.08 : 0.14, rootMargin: isSmall ? '0px 0px -6% 0px' : '0px 0px -10% 0px' });
    reveals.forEach(function (el, index) {
      el.style.setProperty('--cine-delay', (Math.min(index, 5) * 70) + 'ms');
      observer.observe(el);
    });
  } else {
    reveals.forEach(revealNow);
  }

  var parallaxItems = root.querySelectorAll('[data-cine-parallax]');
  var pinned = root.querySelectorAll('[data-cine-pin]');
  var ticking = false;

  function updateMotion() {
    ticking = false;
    if (reduceMotion) return;
    var viewport = window.innerHeight || 1;

    parallaxItems.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var media = section.querySelector('.wvn-cine-hero-media, .wvn-cine-full-image img');
      if (!media || rect.bottom < -120 || rect.top > viewport + 120) return;
      var progress = (viewport - rect.top) / (rect.height + viewport);
      var strength = isSmall ? 28 : 56;
      var offset = (progress - 0.5) * strength;
      var baseScale = isSmall ? 1.075 : 1.11;
      media.style.transform = 'scale(' + baseScale + ') translate3d(0,' + offset.toFixed(2) + 'px,0)';
    });

    pinned.forEach(function (section) {
      var rect = section.getBoundingClientRect();
      var progress = Math.max(0, Math.min(1, (viewport - rect.top) / Math.max(1, rect.height + viewport)));
      var media = section.querySelector('.wvn-cine-pin-media');
      var heading = section.querySelector('.wvn-cine-pin-heading');
      var copy = section.querySelector('.wvn-cine-pin-copy');
      if (media) media.style.transform = 'scale(' + (1.02 + progress * 0.08).toFixed(3) + ')';
      if (heading) {
        heading.style.transform = 'translate3d(0,' + ((progress - 0.2) * -24).toFixed(1) + 'px,0)';
        heading.style.opacity = String(Math.min(1, Math.max(0, progress * 2.1)));
      }
      if (copy) {
        copy.style.transform = 'translate3d(0,' + ((progress - 0.35) * 36).toFixed(1) + 'px,0)';
        copy.style.opacity = String(Math.min(1, Math.max(0, progress * 2.5 - 0.1)));
      }
    });
  }

  function requestMotion() {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(updateMotion);
    }
  }

  window.addEventListener('scroll', requestMotion, { passive: true });
  window.addEventListener('resize', function () {
    isSmall = window.matchMedia && window.matchMedia('(max-width: 560px)').matches;
    requestMotion();
  }, { passive: true });

  var rail = root.querySelector('[data-cine-rail]');
  var railTrack = rail ? rail.querySelector('.wvn-cine-rail-track') : null;
  if (rail && railTrack && !reduceMotion) {
    function moveRail() {
      var rect = rail.getBoundingClientRect();
      if (rect.top > window.innerHeight || rect.bottom < 0) return;
      var travel = Math.max(0, railTrack.scrollWidth - rail.clientWidth);
      var progress = Math.max(0, Math.min(1, (window.innerHeight - rect.top) / Math.max(1, rect.height + window.innerHeight)));
      railTrack.style.transform = 'translate3d(' + (-travel * progress).toFixed(1) + 'px,0,0)';
    }
    window.addEventListener('scroll', moveRail, { passive: true });
    window.addEventListener('resize', moveRail, { passive: true });
    moveRail();
  }

  requestMotion();
})();
