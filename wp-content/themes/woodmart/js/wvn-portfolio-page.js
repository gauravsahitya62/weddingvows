(function () {
  'use strict';

  var root = document.querySelector('.wvn-pf');
  if (!root) return;

  var grid = root.querySelector('[data-pf-grid]');
  var cards = grid ? Array.prototype.slice.call(grid.querySelectorAll('.wvn-pf-card')) : [];
  var moreBtn = root.querySelector('[data-pf-more]');
  var pageSize = grid ? parseInt(grid.getAttribute('data-pf-page-size') || '6', 10) : 6;
  var activeFilter = 'all';
  var visibleCount = pageSize;

  function matchesFilter(card, filter) {
    if (filter === 'all') return true;
    var tags = (card.getAttribute('data-pf-tags') || '').split(/\s+/);
    return tags.indexOf(filter) !== -1;
  }

  function applyVisibility() {
    var matched = cards.filter(function (card) {
      return matchesFilter(card, activeFilter);
    });

    cards.forEach(function (card) {
      card.classList.add('is-filtered-out');
      card.classList.add('is-beyond');
    });

    matched.forEach(function (card, i) {
      card.classList.remove('is-filtered-out');
      if (i < visibleCount) {
        card.classList.remove('is-beyond');
      }
    });

    if (moreBtn) {
      moreBtn.hidden = matched.length <= visibleCount;
    }
  }

  function setFilter(filter) {
    activeFilter = filter || 'all';
    visibleCount = pageSize;

    root.querySelectorAll('[data-pf-filter]').forEach(function (btn) {
      var on = btn.getAttribute('data-pf-filter') === activeFilter;
      btn.classList.toggle('is-active', on);
      if (btn.getAttribute('role') === 'tab') {
        btn.setAttribute('aria-selected', on ? 'true' : 'false');
      }
    });

    applyVisibility();

    var stories = document.getElementById('wvn-pf-stories');
    if (stories && filter && filter !== 'all') {
      stories.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  root.querySelectorAll('[data-pf-filter]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      setFilter(btn.getAttribute('data-pf-filter'));
    });
  });

  if (moreBtn) {
    moreBtn.addEventListener('click', function () {
      visibleCount += pageSize;
      applyVisibility();
    });
  }

  applyVisibility();
})();
