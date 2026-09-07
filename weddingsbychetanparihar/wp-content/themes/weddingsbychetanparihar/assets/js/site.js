(function () {
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const header = document.querySelector("[data-header]");
  const menu = document.querySelector("[data-menu]");
  const nav = document.querySelector("[data-nav]");
  const progress = document.querySelector("[data-progress]");
  const parallaxLayers = document.querySelectorAll("[data-parallax] img, [data-parallax] video");
  let lastY = window.scrollY;

  requestAnimationFrame(() => document.body.classList.add("is-ready"));

  function onScroll() {
    const y = window.scrollY;
    const max = document.documentElement.scrollHeight - window.innerHeight;
    if (header) {
      header.classList.toggle("is-scrolled", y > 16);
    }
    if (progress && max > 0) {
      progress.style.width = Math.min(100, (y / max) * 100) + "%";
    }
    if (!reduce) {
      parallaxLayers.forEach((media) => {
        const box = media.closest("[data-parallax]") || media.parentElement;
        const boxH = box.clientHeight || 1;
        const slack = Math.max(24, boxH * 0.32);
        const raw = box.getBoundingClientRect().top * 0.18;
        const offset = Math.round(Math.max(-slack, Math.min(slack, raw)));
        media.style.transform = "translate3d(0, " + offset + "px, 0)";
      });
    }
    lastY = y;
  }
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });

  if (menu && nav) {
    menu.addEventListener("click", () => {
      const open = document.body.classList.toggle("is-nav-open");
      menu.setAttribute("aria-expanded", open ? "true" : "false");
    });
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        document.body.classList.remove("is-nav-open");
        menu.setAttribute("aria-expanded", "false");
      });
    });
  }

  document.querySelectorAll("[data-film]").forEach((scroller) => {
    const track = scroller.querySelector(".wbc-film-track");
    if (!track || track.children.length < 2) return;

    const originals = Array.from(track.children);
    originals.forEach((card) => track.appendChild(card.cloneNode(true)));

    let origin = 0;
    let start = 0;
    let dragging = false;
    let moved = false;
    let paused = false;
    let timer = 0;

    function gap() {
      return parseFloat(window.getComputedStyle(track).gap) || 18;
    }

    function cardWidth() {
      const card = track.querySelector(".wbc-film-card");
      return card ? card.getBoundingClientRect().width + gap() : 420;
    }

    function cycleWidth() {
      return cardWidth() * originals.length;
    }

    function wrap() {
      const cycle = cycleWidth();
      if (!cycle) return;
      if (scroller.scrollLeft >= cycle) scroller.scrollLeft -= cycle;
      if (scroller.scrollLeft < 0) scroller.scrollLeft += cycle;
    }

    function advance() {
      if (paused || dragging || reduce) return;
      wrap();
      scroller.scrollTo({
        left: scroller.scrollLeft + cardWidth(),
        behavior: "smooth",
      });
      window.setTimeout(wrap, 700);
    }

    function play() {
      stop();
      if (reduce) return;
      timer = window.setInterval(advance, 3200);
    }

    function stop() {
      if (timer) window.clearInterval(timer);
      timer = 0;
    }

    scroller.addEventListener("pointerdown", (event) => {
      if (event.pointerType === "touch") {
        paused = true;
        stop();
        return;
      }
      dragging = true;
      moved = false;
      paused = true;
      stop();
      start = scroller.scrollLeft;
      origin = event.clientX;
      scroller.classList.add("is-drag");
      scroller.setPointerCapture(event.pointerId);
    });

    scroller.addEventListener("pointermove", (event) => {
      if (!dragging) return;
      if (Math.abs(event.clientX - origin) > 6) moved = true;
      scroller.scrollLeft = start - (event.clientX - origin);
      wrap();
    });

    const stopDrag = () => {
      dragging = false;
      scroller.classList.remove("is-drag");
      paused = false;
      wrap();
      window.setTimeout(play, 1200);
    };

    scroller.addEventListener("pointerup", stopDrag);
    scroller.addEventListener("pointercancel", stopDrag);
    scroller.addEventListener("mouseenter", () => {
      paused = true;
      stop();
    });
    scroller.addEventListener("mouseleave", () => {
      if (dragging) return;
      paused = false;
      play();
    });
    scroller.addEventListener("click", (event) => {
      if (!moved) return;
      event.preventDefault();
      event.stopPropagation();
      moved = false;
    }, true);

    if ("IntersectionObserver" in window) {
      new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
          paused = false;
          play();
        } else {
          paused = true;
          stop();
        }
      }, { threshold: 0.2 }).observe(scroller);
    } else {
      play();
    }
  });

  document.querySelectorAll("[data-coverflow]").forEach((root) => {
    const cards = Array.from(root.querySelectorAll(".wbc-coverflow-card"));
    if (!cards.length) return;
    let index = 0;

    function place() {
      const total = cards.length;
      cards.forEach((card, i) => {
        let delta = i - index;
        if (delta > total / 2) delta -= total;
        if (delta < -total / 2) delta += total;
        card.classList.toggle("is-center", delta === 0);
        card.classList.toggle("is-prev", delta === -1);
        card.classList.toggle("is-next", delta === 1);
        card.classList.toggle("is-far", Math.abs(delta) > 1);
        let x = 0;
        let rotate = 0;
        let scale = 0.72;
        if (delta === 0) {
          x = 0;
          rotate = 0;
          scale = 1;
        } else if (delta === -1) {
          x = -92;
          rotate = 36;
          scale = 0.88;
        } else if (delta === 1) {
          x = 92;
          rotate = -36;
          scale = 0.88;
        } else {
          x = delta * 90;
          rotate = delta < 0 ? 40 : -40;
        }
        card.style.transform = "translateX(" + x + "%) rotateY(" + rotate + "deg) scale(" + scale + ")";
      });
    }

    function step(dir) {
      index = (index + dir + cards.length) % cards.length;
      place();
    }

    root.querySelector("[data-coverflow-prev]")?.addEventListener("click", () => step(-1));
    root.querySelector("[data-coverflow-next]")?.addEventListener("click", () => step(1));
    cards.forEach((card, i) => {
      card.addEventListener("click", (event) => {
        if (i === index) return;
        event.preventDefault();
        index = i;
        place();
      });
    });
    place();
  });

  if (!reduce && "IntersectionObserver" in window) {
    const targets = document.querySelectorAll([
      ".wbc-intro > *",
      ".wbc-section-head",
      ".wbc-kind-copy > *",
      ".wbc-planner-card",
      ".wbc-dest-card",
      ".wbc-stats > *",
      ".wbc-svc-tiles article",
      ".wbc-service-list article",
      ".wbc-service",
      ".wbc-steps li",
      ".wbc-timeline li",
      ".wbc-editorial > *",
      ".wbc-quote",
      ".wbc-faq details",
      ".wbc-cta-mark",
      ".wbc-frame-box",
      ".wbc-contact-intro",
      ".wbc-list-card",
      ".wbc-story-card",
      ".wbc-svc-cover",
      ".wbc-pillar",
      ".wbc-gallery a",
      ".wbc-details",
      ".wbc-note",
      ".wbc-page-hero > *",
      ".wbc-contact-grid > *",
    ].join(","));

    targets.forEach((el, index) => {
      el.classList.add("wbc-reveal");
      el.style.setProperty("--d", ((index % 5) * 70) + "ms");
    });

    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-in");
        io.unobserve(entry.target);
      });
    }, { threshold: 0.16, rootMargin: "0px 0px -8% 0px" });

    document.querySelectorAll(".wbc-reveal").forEach((el) => io.observe(el));
  }

  document.querySelectorAll(".wbc-faq details").forEach((detail) => {
    detail.addEventListener("toggle", () => {
      if (!detail.open) return;
      document.querySelectorAll(".wbc-faq details").forEach((other) => {
        if (other !== detail) other.removeAttribute("open");
      });
      // Accordion height changes — refresh parallax offsets without waiting for scroll.
      onScroll();
    });
  });

  document.querySelectorAll("[data-filters]").forEach((bar) => {
    const cards = document.querySelectorAll("[data-city]");
    bar.addEventListener("click", (event) => {
      const button = event.target.closest("button");
      if (!button) return;
      bar.querySelectorAll("button").forEach((item) => item.classList.toggle("is-active", item === button));
      const filter = button.dataset.filter;
      cards.forEach((card) => {
        const show = filter === "all" || card.dataset.city === filter;
        card.classList.toggle("is-out", !show);
        card.hidden = !show;
      });
    });
  });

  document.querySelectorAll("[data-lightbox] a").forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault();
      const overlay = document.createElement("div");
      overlay.className = "wbc-lightbox";
      overlay.innerHTML = '<button type="button" aria-label="Close">×</button><img alt="">';
      overlay.querySelector("img").src = link.href;
      const close = () => {
        overlay.remove();
        document.removeEventListener("keydown", onKey);
      };
      const onKey = (keyEvent) => {
        if (keyEvent.key === "Escape") close();
      };
      overlay.addEventListener("click", close);
      document.addEventListener("keydown", onKey);
      document.body.appendChild(overlay);
    });
  });

  document.querySelectorAll("[data-contact-form]").forEach((form) => {
    const message = form.querySelector("[data-form-message]");
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const button = form.querySelector("button[type='submit'], button:not([type])");
      const data = new FormData(form);
      if (button) button.disabled = true;
      if (message) message.textContent = "Sending…";
      try {
        const response = await fetch(wbcAjax.url, { method: "POST", credentials: "same-origin", body: data });
        const result = await response.json();
        if (result.success) {
          form.reset();
          if (message) message.textContent = result.data.message || "Thank you. Your enquiry has been received.";
        } else if (message) {
          message.textContent = result.data?.message || "Please check the form and try again.";
        }
      } catch (error) {
        if (message) message.textContent = "Something went wrong. Please call or WhatsApp the studio.";
      } finally {
        if (button) button.disabled = false;
      }
    });
  });
})();
