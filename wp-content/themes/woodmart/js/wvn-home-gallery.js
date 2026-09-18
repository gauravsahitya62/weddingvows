(function () {
  'use strict';

  var root = document.querySelector('.wvn-hg');
  if (!root) return;

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var mobileMq = window.matchMedia('(max-width: 768px)');
  var collage = root.querySelector('[data-hg-collage]');
  var cards = Array.prototype.slice.call(root.querySelectorAll('[data-hg-card]'));
  var filters = Array.prototype.slice.call(root.querySelectorAll('[data-hg-filter]'));
  var dotsWrap = root.querySelector('[data-hg-dots]');
  var progressEl = root.querySelector('[data-hg-progress]');
  var activeIndex = 0;
  var railIo = null;

  function visibleCards() {
    return cards.filter(function (card) {
      return !card.classList.contains('is-filtered-out');
    });
  }

  function isMobile() {
    return mobileMq.matches;
  }

  function revealDesktop() {
    if (reduce || !('IntersectionObserver' in window)) {
      cards.forEach(function (card) {
        card.classList.add('is-in');
      });
      return;
    }

    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-in');
          io.unobserve(entry.target);
        });
      },
      { rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
    );

    cards.forEach(function (card) {
      io.observe(card);
    });
  }

  function buildDots() {
    if (!dotsWrap) return;
    var list = visibleCards();
    dotsWrap.innerHTML = list
      .map(function (_, i) {
        return (
          '<button type="button" class="' +
          (i === activeIndex ? 'is-on' : '') +
          '" aria-label="Go to gallery story ' +
          (i + 1) +
          '" data-hg-dot="' +
          i +
          '"></button>'
        );
      })
      .join('');
  }

  function updateProgress() {
    var list = visibleCards();
    if (!list.length) return;
    if (progressEl) {
      progressEl.textContent =
        String(activeIndex + 1).padStart(2, '0') +
        ' / ' +
        String(list.length).padStart(2, '0');
    }
    if (dotsWrap) {
      Array.prototype.forEach.call(dotsWrap.children, function (dot, i) {
        dot.classList.toggle('is-on', i === activeIndex);
      });
    }
  }

  function setActive(index, scrollIntoView) {
    var list = visibleCards();
    if (!list.length) return;
    activeIndex = Math.max(0, Math.min(index, list.length - 1));

    cards.forEach(function (card) {
      card.classList.remove('is-active');
    });
    list.forEach(function (card, i) {
      card.classList.add('is-in');
      if (i === activeIndex) card.classList.add('is-active');
    });

    updateProgress();

    if (scrollIntoView && collage && list[activeIndex]) {
      list[activeIndex].scrollIntoView({
        behavior: reduce ? 'auto' : 'smooth',
        inline: 'center',
        block: 'nearest'
      });
    }
  }

  function nearestCardIndex() {
    if (!collage) return 0;
    var list = visibleCards();
    if (!list.length) return 0;
    var mid = collage.scrollLeft + collage.clientWidth / 2;
    var best = 0;
    var bestDist = Infinity;
    list.forEach(function (card, i) {
      var center = card.offsetLeft + card.offsetWidth / 2;
      var dist = Math.abs(center - mid);
      if (dist < bestDist) {
        bestDist = dist;
        best = i;
      }
    });
    return best;
  }

  function onRailScroll() {
    if (!isMobile()) return;
    var next = nearestCardIndex();
    if (next !== activeIndex) setActive(next, false);
  }

  function bindRailObserver() {
    if (railIo) {
      railIo.disconnect();
      railIo = null;
    }
    if (!isMobile() || !('IntersectionObserver' in window) || !collage) return;

    railIo = new IntersectionObserver(
      function (entries) {
        var best = null;
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          if (!best || entry.intersectionRatio > best.intersectionRatio) {
            best = entry;
          }
        });
        if (!best) return;
        var list = visibleCards();
        var idx = list.indexOf(best.target);
        if (idx >= 0) setActive(idx, false);
      },
      { root: collage, threshold: [0.45, 0.6, 0.75] }
    );

    visibleCards().forEach(function (card) {
      railIo.observe(card);
    });
  }

  function setupMode() {
    cards.forEach(function (card) {
      card.classList.remove('is-active');
    });

    if (isMobile()) {
      cards.forEach(function (card) {
        card.classList.add('is-in');
      });
      buildDots();
      setActive(0, false);
      bindRailObserver();
      if (collage) {
        collage.scrollLeft = 0;
      }
    } else {
      if (railIo) {
        railIo.disconnect();
        railIo = null;
      }
      revealDesktop();
    }
  }

  function setFilter(key) {
    filters.forEach(function (btn) {
      var on = btn.getAttribute('data-hg-filter') === key;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-selected', on ? 'true' : 'false');
    });

    if (collage) {
      collage.classList.toggle('is-filtering', key !== 'all');
    }

    cards.forEach(function (card) {
      var tags = (card.getAttribute('data-hg-tags') || '').split(/\s+/);
      var show = key === 'all' || tags.indexOf(key) !== -1;
      card.classList.toggle('is-filtered-out', !show);
      if (show) card.classList.add('is-in');
    });

    activeIndex = 0;
    if (isMobile()) {
      buildDots();
      setActive(0, true);
      bindRailObserver();
    }
  }

  filters.forEach(function (btn) {
    btn.addEventListener('click', function () {
      setFilter(btn.getAttribute('data-hg-filter') || 'all');
    });
  });

  root.addEventListener('click', function (e) {
    var openLb = e.target.closest('[data-hg-open-lb]');
    if (openLb && root.contains(openLb)) {
      e.preventDefault();
      var card = openLb.closest('[data-hg-card]');
      var media = card && card.querySelector('a.wvn-hg-card__media[data-wvn-lightbox]');
      if (media) media.click();
      return;
    }

    var dot = e.target.closest('[data-hg-dot]');
    if (dot && root.contains(dot)) {
      e.preventDefault();
      setActive(parseInt(dot.getAttribute('data-hg-dot'), 10) || 0, true);
    }
  });

  if (collage) {
    var scrollTick = false;
    collage.addEventListener(
      'scroll',
      function () {
        if (scrollTick) return;
        scrollTick = true;
        window.requestAnimationFrame(function () {
          scrollTick = false;
          onRailScroll();
        });
      },
      { passive: true }
    );
  }

  // Desktop featured parallax only.
  if (!reduce) {
    var feature = root.querySelector('.wvn-hg-card--feature img');
    if (feature && 'IntersectionObserver' in window) {
      var activeFeat = false;
      var featCard = feature.closest('.wvn-hg-card');
      var pio = new IntersectionObserver(
        function (entries) {
          activeFeat = entries.some(function (en) {
            return en.isIntersecting;
          });
        },
        { threshold: 0.15 }
      );
      if (featCard) pio.observe(featCard);

      window.addEventListener(
        'scroll',
        function () {
          if (!activeFeat || isMobile()) return;
          var rect = feature.getBoundingClientRect();
          var mid = rect.top + rect.height / 2 - window.innerHeight / 2;
          var shift = Math.max(-14, Math.min(14, mid * -0.04));
          feature.style.transform = 'scale(1.04) translate3d(0,' + shift + 'px,0)';
        },
        { passive: true }
      );
    }
  }

  if (typeof mobileMq.addEventListener === 'function') {
    mobileMq.addEventListener('change', setupMode);
  } else if (typeof mobileMq.addListener === 'function') {
    mobileMq.addListener(setupMode);
  }

  setupMode();
})();
