/**
 * Flow:
 * 1) Mosaic splits
 * 2) The instant tiles clear → VOWS cutout (film + mask snap on together; no black hold, no video leak)
 * 3) Scroll zooms VOWS larger
 * 4) Cutout opens into full video → caption
 */
(function () {
  "use strict";

  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function clamp(n, a, b) {
    return Math.max(a, Math.min(b, n));
  }

  function lerp(a, b, t) {
    return a + (b - a) * t;
  }

  function easeOutCubic(t) {
    var u = clamp(t, 0, 1);
    return 1 - Math.pow(1 - u, 3);
  }

  function easeInOutCubic(t) {
    var u = clamp(t, 0, 1);
    return u < 0.5 ? 4 * u * u * u : 1 - Math.pow(-2 * u + 2, 3) / 2;
  }

  function rangeProgress(p, a, b, easeFn) {
    if (b === a) return p >= b ? 1 : 0;
    var t = clamp((p - a) / (b - a), 0, 1);
    return (easeFn || easeOutCubic)(t);
  }

  function pinProgress(el) {
    var rect = el.getBoundingClientRect();
    var travel = el.offsetHeight - (window.innerHeight || document.documentElement.clientHeight);
    if (travel <= 0) return 0;
    return clamp(-rect.top / travel, 0, 1);
  }

  function playVideo(video) {
    if (!video) return;
    var p = video.play();
    if (p && typeof p.catch === "function") p.catch(function () {});
  }

  /**
   * 0.00–0.14  start card
   * 0.05–0.28  mosaic splits (curtain stays solid underneath)
   * 0.28       VOWS film + mask snap on; curtain off (no black beat, no premature film)
   * 0.30–0.70  VOWS zooms 1 → 22
   * 0.66–0.80  mask dissolves → full video
   * 0.76–0.94  caption
   */
  function initMergedStory() {
    var root = document.querySelector("[data-wvn-cin-story]");
    if (!root || root.__wvnBound) return null;
    root.__wvnBound = true;

    var storyFilm = root.querySelector("[data-wvn-cin-story-film]");
    var vowsFilm = root.querySelector("[data-wvn-cin-vows-film]");
    var vowsShade = root.querySelector(".wvn-cin-story__vows-shade");
    var mask = root.querySelector("[data-wvn-cin-vows-mask]");
    var caption = root.querySelector("[data-wvn-cin-vows-caption]");
    var tilesWrap = root.querySelector("[data-wvn-cin-story-tiles]");
    var tiles = Array.prototype.slice.call(root.querySelectorAll(".wvn-cin-story__tile"));
    var start = root.querySelector("[data-wvn-cin-story-start]");
    var cue = root.querySelector("[data-wvn-cin-story-cue]");
    var vignette = root.querySelector("[data-wvn-cin-story-vignette]");
    var curtain = root.querySelector("[data-wvn-cin-story-curtain]");
    var storyVideo = root.querySelector(".wvn-cin-story__film video");
    var vowsVideo = root.querySelector(".wvn-cin-story__vows-film video");

    playVideo(storyVideo);
    playVideo(vowsVideo);

    if (vowsFilm) {
      vowsFilm.style.transform = "scale(1)";
      vowsFilm.style.opacity = "0";
    }
    if (mask) {
      mask.style.transform = "scale(1)";
      mask.style.opacity = "0";
    }

    if (reduce) {
      if (caption) caption.classList.add("is-live");
      if (vowsFilm) vowsFilm.style.opacity = "1";
      if (mask) mask.style.opacity = "0";
      if (curtain) curtain.style.opacity = "0";
      return null;
    }

    return function update() {
      var p = pinProgress(root);

      /* 1) Start card out */
      if (start) {
        var startT = rangeProgress(p, 0.03, 0.14);
        start.style.opacity = String(1 - startT);
        start.style.transform = "translate3d(0," + lerp(0, -48, startT).toFixed(2) + "px,0)";
        start.style.visibility = startT >= 0.999 ? "hidden" : "visible";
      }

      if (cue) {
        var cueT = rangeProgress(p, 0.02, 0.1);
        cue.style.opacity = String(lerp(0.7, 0, cueT));
        cue.style.visibility = cueT >= 0.999 ? "hidden" : "visible";
      }

      /* Hide story film early so mosaic gaps never show it */
      if (storyFilm) {
        var storyFade = rangeProgress(p, 0.06, 0.16);
        storyFilm.style.opacity = String(1 - storyFade);
        storyFilm.style.transform = "scale(1.06)";
      }

      /* Mosaic splits — tiles clear by ~0.28 */
      var tileFade = rangeProgress(p, 0.18, 0.28);
      var mobile = window.matchMedia("(max-width: 767px)").matches;
      tiles.forEach(function (tile, i) {
        var stagger = (i % 3) * 0.008;
        var localMove = rangeProgress(p, 0.05 + stagger, 0.27 + stagger);
        var up = mobile ? i < 3 : tile.getAttribute("data-row") === "top";
        tile.style.transform = "translate3d(0," + lerp(0, up ? -140 : 140, localMove).toFixed(2) + "%,0)";
        tile.style.opacity = String(1 - tileFade);
        var img = tile.querySelector("img");
        if (img) img.style.transform = "scale(" + lerp(1, 1.08, localMove).toFixed(4) + ")";
      });
      if (tilesWrap) {
        var tilesGone = tileFade >= 0.999;
        tilesWrap.style.pointerEvents = tilesGone ? "none" : "auto";
        tilesWrap.style.visibility = tilesGone ? "hidden" : "visible";
      }

      /*
       * Snap VOWS on the instant mosaic ends.
       * Never fade multiply-mask opacity (that leaks full video).
       * Film + mask both 0 or both 1; curtain is the inverse.
       */
      var vowsLive = p >= 0.28 ? 1 : 0;

      if (curtain) curtain.style.opacity = String(1 - vowsLive);

      if (vowsFilm) {
        vowsFilm.style.opacity = String(vowsLive);
        vowsFilm.style.transform = "scale(1)";
      }

      if (vowsShade) {
        vowsShade.style.opacity = String(
          vowsLive * 0.12 * (1 - rangeProgress(p, 0.58, 0.76))
        );
      }

      var maskZoom = rangeProgress(p, 0.3, 0.7, easeInOutCubic);
      var maskOut = rangeProgress(p, 0.66, 0.8, easeInOutCubic);

      if (mask) {
        mask.style.transform = "scale(" + lerp(1, 22, maskZoom).toFixed(4) + ")";
        /* Stay fully opaque while live so cutout stays clean; only dissolve at end */
        mask.style.opacity = String(vowsLive * (1 - maskOut));
      }

      if (vignette) {
        var vig = lerp(0.28, 0.1, rangeProgress(p, 0.52, 0.8));
        vignette.style.opacity = String(vig);
      }

      if (caption) {
        var capOp = rangeProgress(p, 0.76, 0.88);
        var capY = rangeProgress(p, 0.76, 0.93);
        caption.style.opacity = String(capOp);
        caption.style.transform = "translate3d(0," + lerp(36, 0, capY).toFixed(2) + "px,0)";
        if (capOp > 0.05) caption.classList.add("is-live");
        else caption.classList.remove("is-live");
      }
    };
  }

  function initCites() {
    var root = document.querySelector("[data-wvn-cin-cites]");
    if (!root || root.__wvnBound) return;
    root.__wvnBound = true;

    var cards = Array.prototype.slice.call(root.querySelectorAll("[data-wvn-cin-cites-card]"));
    var dots = Array.prototype.slice.call(root.querySelectorAll("[data-wvn-cin-cites-dot]"));
    var deck = root.querySelector("[data-wvn-cin-cites-deck]");
    var prev = root.querySelector("[data-wvn-cin-cites-prev]");
    var next = root.querySelector("[data-wvn-cin-cites-next]");
    var total = cards.length;
    var index = 0;
    var timer = null;
    var duration = 5500;
    var dragging = false;
    var startX = 0;
    var deltaX = 0;

    if (!total) return;

    function wrap(n) {
      return ((n % total) + total) % total;
    }

    function shortestOffset(i, active) {
      var raw = i - active;
      if (raw > total / 2) raw -= total;
      if (raw < -total / 2) raw += total;
      return raw;
    }

    function render() {
      var vw = window.innerWidth || 1200;
      var cardW = Math.min(380, vw * 0.82);
      if (vw < 900) cardW = Math.min(340, vw * 0.78);
      if (vw < 640) cardW = Math.min(300, vw * 0.78);
      var gap = vw < 640 ? 18 : 28;
      var step = cardW + gap;

      cards.forEach(function (card, i) {
        var o = shortestOffset(i, index);
        var abs = Math.abs(o);
        var x = o * step;
        var s = abs === 0 ? 1 : Math.max(0.88, 1 - abs * 0.06);
        var opacity = abs === 0 ? 1 : Math.max(0.4, 1 - abs * 0.28);
        var z = abs === 0 ? 40 : 30 - abs * 5;

        if (abs > 2 || (vw < 640 && abs > 1)) {
          opacity = 0;
          z = 1;
        }

        card.style.setProperty("--o", String(o));
        card.style.setProperty("--x", x.toFixed(1) + "px");
        card.style.setProperty("--s", s.toFixed(3));
        card.style.opacity = String(opacity);
        card.style.zIndex = String(z);
        card.dataset.abs = String(abs);
        card.dataset.far = opacity === 0 ? "1" : "0";
        card.classList.toggle("is-active", o === 0);
        card.setAttribute("aria-hidden", o === 0 ? "false" : "true");
      });
      dots.forEach(function (dot, i) {
        var on = i === index;
        dot.classList.toggle("is-active", on);
        if (on) dot.setAttribute("aria-current", "true");
        else dot.removeAttribute("aria-current");
      });
    }

    function go(to) {
      index = wrap(to);
      render();
    }

    function step(dir) {
      go(index + dir);
    }

    function stopAuto() {
      if (timer) {
        window.clearInterval(timer);
        timer = null;
      }
    }

    function startAuto() {
      stopAuto();
      if (reduce || total < 2) return;
      timer = window.setInterval(function () {
        step(1);
      }, duration);
    }

    if (prev) prev.addEventListener("click", function () {
      step(-1);
      startAuto();
    });
    if (next) next.addEventListener("click", function () {
      step(1);
      startAuto();
    });

    cards.forEach(function (card) {
      card.addEventListener("click", function () {
        if (dragging || Math.abs(deltaX) > 8) return;
        var i = parseInt(card.getAttribute("data-index"), 10);
        if (!isNaN(i) && i !== index) {
          go(i);
          startAuto();
        }
      });
    });

    dots.forEach(function (dot) {
      dot.addEventListener("click", function () {
        var i = parseInt(dot.getAttribute("data-index"), 10);
        if (!isNaN(i)) {
          go(i);
          startAuto();
        }
      });
    });

    root.querySelectorAll(".wvn-cin-cites__card-media video").forEach(function (video) {
      playVideo(video);
    });

    window.addEventListener("resize", function () {
      render();
    }, { passive: true });

    function onPointerDown(x) {
      dragging = true;
      startX = x;
      deltaX = 0;
      if (deck) deck.classList.add("is-dragging");
      stopAuto();
    }

    function onPointerMove(x) {
      if (!dragging) return;
      deltaX = x - startX;
    }

    function onPointerUp() {
      if (!dragging) return;
      dragging = false;
      if (deck) deck.classList.remove("is-dragging");
      if (Math.abs(deltaX) > 48) step(deltaX < 0 ? 1 : -1);
      deltaX = 0;
      startAuto();
    }

    if (deck) {
      deck.addEventListener("pointerdown", function (e) {
        if (e.button && e.button !== 0) return;
        onPointerDown(e.clientX);
        try { deck.setPointerCapture(e.pointerId); } catch (err) {}
      });
      deck.addEventListener("pointermove", function (e) {
        onPointerMove(e.clientX);
      });
      deck.addEventListener("pointerup", onPointerUp);
      deck.addEventListener("pointercancel", onPointerUp);
    }

    root.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") {
        e.preventDefault();
        step(-1);
        startAuto();
      } else if (e.key === "ArrowRight") {
        e.preventDefault();
        step(1);
        startAuto();
      }
    });
    if (!root.hasAttribute("tabindex")) root.setAttribute("tabindex", "0");

    render();

    if ("IntersectionObserver" in window) {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              root.classList.add("is-in");
              startAuto();
              io.unobserve(root);
            }
          });
        },
        { threshold: 0.25 }
      );
      io.observe(root);
    } else {
      root.classList.add("is-in");
      startAuto();
    }
  }

  var updateStory = initMergedStory();
  initCites();
  if (!updateStory) return;

  var ticking = false;
  function tick() {
    ticking = false;
    updateStory();
  }
  function onScroll() {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(tick);
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("resize", onScroll, { passive: true });
  tick();
})();
