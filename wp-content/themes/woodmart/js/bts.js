(function () {
  const root = document.documentElement;
  const header = document.querySelector(".wvn-header");
  const storedTheme = localStorage.getItem("wvn-theme") || "light";
  root.setAttribute("data-theme", storedTheme);

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const isMobile = () => window.innerWidth <= 980;

  function clamp(value, min, max) {
    return Math.min(max, Math.max(min, value));
  }

  function pinProgress(section) {
    const rect = section.getBoundingClientRect();
    const travel = section.offsetHeight - window.innerHeight;
    if (travel <= 0) return 0;
    return clamp(-rect.top / travel, 0, 1);
  }

  let headerPeek = false;
  let headerScrolling = false;
  let headerScrollStop;

  function setHeaderTone() {
    if (!header) return;
    header.classList.toggle("is-light", !isOverDark());
  }

  function setHeaderVisibility() {
    if (!header) return;
    const atTop = window.scrollY < 48;
    const show = atTop || (headerPeek && !headerScrolling);
    header.classList.toggle("is-hidden", !show);
    setHeaderTone();
  }

  function isOverDark() {
    const dark = document.querySelectorAll(".wvn-intro, .wvn-achieve, .wvn-showreel, .wvn-hero, .wvn-opening, .wvn-footer, .wvn-svc-hero, .wvn-svc-specials, .wvn-cin-story, .wvn-cin-cites, .wvn-money-hero, .wvn-money-proof, .wvn-money-services, .wvn-money-proof-cta, .wvn-money-final-cta, .wvn-page-hero, .wvn-wedding-hero, .wvn-cin-band, .wvn-cta-box, .wvn-contact-stage, .wvn-pf-hero, .wvn-pf-stories, .wvn-pf-film, .wvn-pf-cta, .wvn-pf-cites");
    for (const el of dark) {
      const r = el.getBoundingClientRect();
      if (r.top < 80 && r.bottom > 50) return true;
    }
    if (document.querySelector(".wvn-opening, .wvn-hero, .wvn-svc-hero")) {
      return window.scrollY < 80;
    }
    return false;
  }

  const opening = document.querySelector('[data-pin="opening"]');
  const hero = document.querySelector(".wvn-hero");
  const heroTravel = opening && opening.querySelector(".wvn-hero-travel");
  const heroFrame = document.querySelector(".wvn-hero-frame");
  const heroImg = heroFrame && heroFrame.querySelector("img, video");

  function easeInOutCubic(t) {
    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  function updateHero() {
    if (!hero) return;
    const travel = Math.max(1, heroTravel ? heroTravel.offsetHeight : window.innerHeight * 1.4);
    const top = opening ? -opening.getBoundingClientRect().top : window.scrollY;
    const p = reduceMotion ? 1 : clamp(top / travel, 0, 1);
    const e = easeInOutCubic(p);
    const mobile = isMobile();
    const insetT = (mobile ? 30 : 36) * (1 - e);
    const insetX = (mobile ? 9 : 21) * (1 - e);
    const insetB = (mobile ? 38 : 42) * (1 - e);
    const radius = (mobile ? 48 : 100) * (1 - e);
    hero.style.setProperty("--hero-t", insetT.toFixed(3) + "vh");
    hero.style.setProperty("--hero-x", insetX.toFixed(3) + "vw");
    hero.style.setProperty("--hero-b", insetB.toFixed(3) + "vh");
    hero.style.setProperty("--hero-r", radius.toFixed(2) + "px");
    if (heroImg) heroImg.style.transform = "scale(" + (1.18 - e * 0.14) + ")";
  }

  const flow = document.querySelector("[data-hscroll]");
  const track = flow && flow.querySelector(".wvn-coverflow-track");
  let cards = [];
  let flowOffset = 0;
  let flowHover = false;
  let flowVel = 0;
  let snapRemain = 0;
  let lastFlowTs = 0;

  function loopWidth() {
    if (!track) return 0;
    return track.scrollWidth / 2;
  }

  function wrapFlowOffset() {
    const width = loopWidth();
    if (width <= 0) return;
    flowOffset = ((flowOffset % width) + width) % width;
  }

  function focusFromDist(dist, radius) {
    const x = clamp(1 - dist / radius, 0, 1);
    return x * x * (3 - 2 * x);
  }

  function applyFlow() {
    if (!track || !flow) return;
    wrapFlowOffset();
    track.style.transform = "translate3d(" + -flowOffset + "px,0,0)";
    const mid = flow.getBoundingClientRect().left + flow.clientWidth / 2;
    const radius = Math.max(160, flow.clientWidth * 0.22);
    let best = cards[0];
    let bestFocus = -1;
    cards.forEach((card) => {
      const r = card.getBoundingClientRect();
      const dist = Math.abs(r.left + r.width / 2 - mid);
      const focus = focusFromDist(dist, radius);
      card.style.setProperty("--focus", focus.toFixed(4));
      if (focus > bestFocus) {
        bestFocus = focus;
        best = card;
      }
    });
    cards.forEach((card) => card.classList.toggle("is-active", card === best));
  }

  if (flow && track && !track.dataset.cloned) {
    track.innerHTML += track.innerHTML;
    track.dataset.cloned = "1";
  }

  if (flow && track) {
    cards = Array.from(track.querySelectorAll(".wvn-card"));
    cards.forEach((card, i) => {
      if (i >= cards.length / 2) card.setAttribute("aria-hidden", "true");
      card.addEventListener("click", (e) => {
        if (card.classList.contains("is-active")) return;
        e.preventDefault();
        const mid = flow.getBoundingClientRect().left + flow.clientWidth / 2;
        const cardMid = card.getBoundingClientRect().left + card.offsetWidth / 2;
        snapRemain += cardMid - mid;
        flowVel = 0;
      });
    });

    flow.addEventListener("mouseenter", () => { flowHover = true; });
    flow.addEventListener("mouseleave", () => {
      flowHover = false;
      flowVel *= 0.35;
    });
    flow.addEventListener("wheel", (e) => {
      if (!flowHover) return;
      e.preventDefault();
      flowVel += e.deltaY * 0.55;
      snapRemain = 0;
    }, { passive: false });

    let touchX = 0;
    flow.addEventListener("touchstart", (e) => {
      flowHover = true;
      touchX = e.changedTouches[0].clientX;
      flowVel = 0;
    }, { passive: true });
    flow.addEventListener("touchmove", (e) => {
      const x = e.changedTouches[0].clientX;
      flowOffset += touchX - x;
      touchX = x;
      applyFlow();
    }, { passive: true });
    flow.addEventListener("touchend", () => { flowHover = false; });

    function tickFlow(ts) {
      if (!lastFlowTs) lastFlowTs = ts;
      const dt = Math.min(0.05, (ts - lastFlowTs) / 1000);
      lastFlowTs = ts;
      if (Math.abs(snapRemain) > 0.35) {
        const eased = snapRemain * 0.16;
        flowOffset += eased;
        snapRemain -= eased;
      } else if (snapRemain) {
        flowOffset += snapRemain;
        snapRemain = 0;
      } else if (flowHover || Math.abs(flowVel) > 0.15) {
        flowOffset += flowVel * dt * 60;
        flowVel *= Math.pow(0.86, dt * 60);
        if (Math.abs(flowVel) < 0.15) flowVel = 0;
      } else if (!reduceMotion) {
        flowOffset += 38 * dt;
      }
      applyFlow();
      requestAnimationFrame(tickFlow);
    }
    applyFlow();
    requestAnimationFrame(tickFlow);
  }

  const servicesPin = document.querySelector('[data-pin="services"]');
  const serviceCards = servicesPin ? Array.from(servicesPin.querySelectorAll("[data-service-card]")) : [];
  const serviceBgs = servicesPin ? Array.from(servicesPin.querySelectorAll("[data-service-bg]")) : [];
  const serviceCount = servicesPin?.querySelector("[data-service-count]");
  let serviceIndex = 0;

  function applyServices(pos) {
    const n = serviceCards.length;
    if (!n) return;
    const max = Math.max(1, n - 1);
    const clamped = clamp(pos, 0, max);
    serviceIndex = Math.round(clamped);
    serviceCards.forEach((card, i) => {
      let y = 0;
      if (i > 0) y = clamp(1 - (clamped - (i - 1)), 0, 1) * 100;
      card.style.transform = "translate3d(0," + y + "%,0)";
      card.style.zIndex = String(i + 1);
    });
    serviceBgs.forEach((bg, i) => {
      let op = i === 0 ? 1 : clamp(clamped - (i - 1), 0, 1);
      bg.style.opacity = String(op);
    });
    if (serviceCount) {
      serviceCount.textContent = String(serviceIndex + 1).padStart(2, "0") + " / " + String(n).padStart(2, "0");
    }
  }

  function servicePosFromScroll() {
    const n = serviceCards.length;
    if (!servicesPin || n < 2) return 0;
    return pinProgress(servicesPin) * (n - 1);
  }

  function updateServices() {
    if (!servicesPin || !serviceCards.length) return;
    applyServices(servicePosFromScroll());
  }

  function scrollToService(index) {
    if (!servicesPin || !serviceCards.length) return;
    const n = serviceCards.length;
    const travel = Math.max(1, servicesPin.offsetHeight - window.innerHeight);
    const top = servicesPin.getBoundingClientRect().top + window.scrollY;
    const y = top + (clamp(index, 0, n - 1) / Math.max(1, n - 1)) * travel;
    window.scrollTo({ top: y, behavior: reduceMotion ? "auto" : "smooth" });
  }

  if (servicesPin && serviceCards.length) {
    servicesPin.querySelector("[data-prev]")?.addEventListener("click", () => {
      scrollToService(Math.max(0, serviceIndex - 1));
    });
    servicesPin.querySelector("[data-next]")?.addEventListener("click", () => {
      scrollToService(Math.min(serviceCards.length - 1, serviceIndex + 1));
    });
    let startY = 0;
    servicesPin.addEventListener("touchstart", (e) => { startY = e.changedTouches[0].clientY; }, { passive: true });
    servicesPin.addEventListener("touchend", (e) => {
      const dy = e.changedTouches[0].clientY - startY;
      if (Math.abs(dy) > 50) scrollToService(serviceIndex + (dy < 0 ? 1 : -1));
    });
    applyServices(0);
  }

  document.querySelectorAll(".wvn-reveal, .wvn-showreel, .wvn-planners-card, .wvn-cta-box, .wvn-quote, .wvn-story, .wvn-mosaic a").forEach((el) => {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-in");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.18 });
    io.observe(el);
  });

  let ticking = false;
  function onScroll() {
    if (window.scrollY >= 48) {
      headerScrolling = true;
      header?.classList.add("is-hidden");
      clearTimeout(headerScrollStop);
      headerScrollStop = setTimeout(() => {
        headerScrolling = false;
        setHeaderVisibility();
      }, 180);
    } else {
      headerScrolling = false;
    }
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => {
      setHeaderVisibility();
      updateHero();
      updateServices();
      ticking = false;
    });
  }

  window.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("resize", () => {
    setHeaderVisibility();
    updateHero();
    updateServices();
  });
  document.addEventListener("mousemove", (e) => {
    headerPeek = e.clientY < 96;
    if (!headerScrolling) setHeaderVisibility();
  });
  setHeaderVisibility();
  updateHero();
  updateServices();

  document.querySelectorAll(".wvn-theme").forEach((btn) => {
    btn.addEventListener("click", () => {
      const next = root.getAttribute("data-theme") === "dark" ? "light" : "dark";
      root.setAttribute("data-theme", next);
      localStorage.setItem("wvn-theme", next);
    });
  });

  const askModal = document.getElementById("wvn-ask-modal");
  const askInput = document.getElementById("wvn-ask-input");
  const askResults = document.getElementById("wvn-ask-results");
  const accItems = document.querySelectorAll(".wvn-acc details");
  accItems.forEach((item) => {
    item.addEventListener("toggle", () => {
      if (!item.open) return;
      accItems.forEach((other) => {
        if (other !== item) other.open = false;
      });
    });
  });
  const faqs = Array.from(accItems).map((d) => ({
    q: d.querySelector("summary")?.textContent || "",
    a: d.querySelector("p")?.textContent || "",
  }));

  function openModal(id) {
    document.getElementById(id)?.classList.add("is-open");
    document.body.style.overflow = "hidden";
  }
  function closeModals() {
    document.querySelectorAll(".wvn-modal").forEach((m) => m.classList.remove("is-open"));
    document.body.style.overflow = "";
  }

  document.querySelectorAll("[data-open-ask]").forEach((el) => {
    el.addEventListener("click", () => {
      openModal("wvn-ask-modal");
      askInput?.focus();
    });
  });
  // Background autoplay for stories videos (silent overlay)
  document.querySelectorAll(".wvn-story video").forEach((v) => {
    v.muted = true;
    v.loop = true;
    v.playsInline = true;
    const playPromise = v.play();
    if (playPromise !== undefined) {
      playPromise.catch(() => {
        // Autoplay policy fallback: starts when user scrolls/taps
      });
    }
  });

  document.querySelectorAll("[data-story-play]").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      const card = btn.closest(".wvn-story");
      const video = card?.querySelector("video");
      if (!video) return;

      const isSoundActive = card.classList.contains("is-playing") && !video.muted;

      if (isSoundActive) {
        // Mute and continue silent background loop
        video.muted = true;
        card.classList.remove("is-playing");
      } else {
        // Mute any other active story videos
        document.querySelectorAll(".wvn-story.is-playing video").forEach((other) => {
          if (other !== video) {
            other.muted = true;
            other.closest(".wvn-story")?.classList.remove("is-playing");
          }
        });

        video.muted = false;
        video.volume = 1;
        video.play();
        card.classList.add("is-playing");
      }

      video.onended = () => {
        video.muted = true;
        card.classList.remove("is-playing");
        video.play();
      };
    });
  });
  document.querySelectorAll("[data-open-showreel]").forEach((el) => {
    el.addEventListener("click", () => {
      openModal("wvn-showreel-modal");
      const video = document.querySelector("#wvn-showreel-modal video");
      if (video) video.play();
    });
  });
  const pressbook = document.querySelector("[data-book]");
  if (pressbook) {
    const sheets = Array.from(pressbook.querySelectorAll(".wvn-pressbook-sheet")).sort(
      (a, b) => Number(a.dataset.sheet) - Number(b.dataset.sheet)
    );
    const prevBtn = pressbook.querySelector("[data-book-prev]");
    const nextBtn = pressbook.querySelector("[data-book-next]");
    let flipped = 0;
    let busy = false;
    const flipMs = reduceMotion ? 0 : 1000;

    function stack() {
      sheets.forEach((sheet, i) => {
        const isFlipped = sheet.classList.contains("is-flipped");
        if (!sheet.classList.contains("is-turning")) {
          sheet.style.zIndex = isFlipped ? String(i + 1) : String(sheets.length - i + 8);
        }
      });
      const open = pressbook.classList.contains("is-open");
      if (prevBtn) prevBtn.disabled = !open;
      if (nextBtn) nextBtn.disabled = !open;
    }

    function turn(sheet, shouldFlip) {
      if (!sheet || busy) return;
      const already = sheet.classList.contains("is-flipped");
      if (already === shouldFlip) return;
      busy = true;
      sheet.classList.add("is-turning");
      sheet.style.zIndex = "80";
      sheet.classList.toggle("is-flipped", shouldFlip);
      window.setTimeout(() => {
        sheet.classList.remove("is-turning");
        busy = false;
        stack();
      }, flipMs);
    }

    function openBook() {
      if (pressbook.classList.contains("is-open") || busy) return;
      busy = true;
      pressbook.classList.add("is-open");
      window.setTimeout(() => {
        busy = false;
        turn(sheets[0], true);
        flipped = 1;
        stack();
      }, reduceMotion ? 0 : 90);
    }

    function closeBook() {
      if (!pressbook.classList.contains("is-open") || busy) return;
      busy = true;
      sheets.forEach((sheet, i) => {
        if (i === 0) return;
        sheet.classList.remove("is-flipped", "is-turning");
      });
      flipped = 0;
      const cover = sheets[0];
      cover.classList.add("is-turning");
      cover.style.zIndex = "80";
      cover.classList.remove("is-flipped");
      window.setTimeout(() => {
        cover.classList.remove("is-turning");
        pressbook.classList.remove("is-open");
        busy = false;
        stack();
      }, flipMs);
    }

    function nextPage() {
      if (busy) return;
      if (!pressbook.classList.contains("is-open")) {
        openBook();
        return;
      }
      if (flipped >= sheets.length) {
        closeBook();
        return;
      }
      turn(sheets[flipped], true);
      flipped += 1;
      stack();
    }

    function prevPage() {
      if (busy) return;
      if (!pressbook.classList.contains("is-open")) return;
      if (flipped <= 1) {
        closeBook();
        return;
      }
      flipped -= 1;
      turn(sheets[flipped], false);
      stack();
    }

    pressbook.querySelector("[data-book-toggle]")?.addEventListener("click", (e) => {
      e.stopPropagation();
      if (pressbook.classList.contains("is-open")) closeBook();
      else openBook();
    });
    prevBtn?.addEventListener("click", prevPage);
    nextBtn?.addEventListener("click", nextPage);
    pressbook.querySelector(".wvn-pressbook-3d")?.addEventListener("click", (e) => {
      if (!pressbook.classList.contains("is-open") || busy) return;
      if (e.target.closest("[data-book-toggle]")) return;
      if (flipped >= sheets.length) {
        nextPage();
        return;
      }
      const face = e.target.closest(".wvn-pressbook-face");
      if (!face) return;
      if (face.classList.contains("is-front")) nextPage();
      if (face.classList.contains("is-back")) prevPage();
    });
    document.addEventListener("keydown", (e) => {
      if (!pressbook.classList.contains("is-open")) return;
      if (e.key === "Escape") closeBook();
      if (e.key === "ArrowRight") nextPage();
      if (e.key === "ArrowLeft") prevPage();
    });
    stack();
  }
  document.querySelectorAll("[data-close-modal]").forEach((el) => el.addEventListener("click", closeModals));
  document.querySelectorAll(".wvn-modal").forEach((modal) => {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) closeModals();
    });
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModals();
  });

  // Testimonial read more / read less toggle
  document.querySelectorAll("[data-quote-toggle]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const card = btn.closest("[data-quote-card]");
      if (!card) return;
      const isExpanded = card.classList.toggle("is-expanded");
      btn.textContent = isExpanded ? "Show less" : "Read full review";
    });
  });

  (function initLightbox() {
    const groups = document.querySelectorAll(".wvn-mosaic, .gallery-lightbox, .wvn-wedding-collage, .wvn-wedding-mosaic, .wvn-pf-card");
    if (!groups.length) return;

    const box = document.createElement("div");
    box.className = "wvn-lightbox";
    box.hidden = true;
    box.setAttribute("role", "dialog");
    box.setAttribute("aria-modal", "true");
    box.setAttribute("aria-label", "Wedding gallery");
    box.innerHTML = '<button class="wvn-lb-btn wvn-lb-close" type="button" aria-label="Close"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 6l12 12M18 6 6 18"/></svg></button>'
      + '<button class="wvn-lb-btn wvn-lb-prev" type="button" aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 5 8 12l7 7"/></svg></button>'
      + '<button class="wvn-lb-btn wvn-lb-next" type="button" aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m9 5 7 7-7 7"/></svg></button>'
      + '<figure class="wvn-lb-stage"><img alt=""><figcaption class="wvn-lb-caption" hidden></figcaption></figure>'
      + '<div class="wvn-lb-dots"></div>';
    document.body.appendChild(box);

    const img = box.querySelector("img");
    const caption = box.querySelector(".wvn-lb-caption");
    const dots = box.querySelector(".wvn-lb-dots");
    let slides = [];
    let index = 0;

    function paint() {
      const slide = slides[index] || {};
      img.src = slide.url || "";
      img.alt = slide.caption || ("Wedding gallery image " + (index + 1));
      if (slide.caption) {
        caption.textContent = slide.caption;
        caption.hidden = false;
      } else {
        caption.textContent = "";
        caption.hidden = true;
      }
      dots.innerHTML = slides.map((_, i) => '<button type="button" class="' + (i === index ? "is-on" : "") + '" aria-label="Image ' + (i + 1) + '"></button>').join("");
      box.classList.toggle("has-many", slides.length > 1);
    }

    function openAt(list, i) {
      slides = (list || []).map((item) => {
        if (typeof item === "string") return { url: item, caption: "" };
        return { url: item && item.url ? item.url : "", caption: item && item.caption ? item.caption : "" };
      }).filter((item) => item.url);
      if (!slides.length) return;
      index = ((i % slides.length) + slides.length) % slides.length;
      paint();
      box.hidden = false;
      document.body.style.overflow = "hidden";
    }

    function closeLb() {
      box.hidden = true;
      document.body.style.overflow = "";
    }

    function step(dir) {
      if (!slides.length) return;
      index = (index + dir + slides.length) % slides.length;
      paint();
    }

    window.wvnOpenLightbox = openAt;

    groups.forEach((group) => {
      const items = [...group.querySelectorAll("[data-wvn-lightbox]")];
      if (!items.length) return;

      const slideList = () => items.map((item) => ({
        url: item.getAttribute("href"),
        caption: item.getAttribute("data-caption") || ""
      }));

      const openFrom = (i) => openAt(slideList(), i);

      items.forEach((link, i) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          openFrom(i);
        });
      });

      const hit = group.querySelector("[data-pf-open-gallery]");
      if (hit) {
        hit.addEventListener("click", (e) => {
          e.preventDefault();
          openFrom(0);
        });
      }
    });

    box.querySelector(".wvn-lb-close").addEventListener("click", closeLb);
    box.querySelector(".wvn-lb-prev").addEventListener("click", () => step(-1));
    box.querySelector(".wvn-lb-next").addEventListener("click", () => step(1));
    dots.addEventListener("click", (e) => {
      const btn = e.target.closest("button");
      if (!btn) return;
      index = [...dots.children].indexOf(btn);
      paint();
    });
    box.addEventListener("click", (e) => {
      if (e.target === box) closeLb();
    });
    document.addEventListener("keydown", (e) => {
      if (box.hidden) return;
      if (e.key === "Escape") closeLb();
      if (e.key === "ArrowLeft") step(-1);
      if (e.key === "ArrowRight") step(1);
    });

    let startX = 0;
    box.addEventListener("touchstart", (e) => { startX = e.changedTouches[0].clientX; }, { passive: true });
    box.addEventListener("touchend", (e) => {
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 40) step(dx < 0 ? 1 : -1);
    });
  })();

  function renderAsk(query) {
    if (!askResults) return;
    const q = (query || "").trim().toLowerCase();
    const hits = faqs.filter((f) => !q || f.q.toLowerCase().includes(q) || f.a.toLowerCase().includes(q));
    askResults.innerHTML = hits.length
      ? hits.map((f) => "<article><strong>" + f.q + "</strong><p>" + f.a + "</p></article>").join("")
      : "<p>Nothing matched. Tell us about your wedding and we will reply within a day.</p>";
  }
  askInput?.addEventListener("input", () => renderAsk(askInput.value));
  if (askModal) renderAsk("");

  document.querySelectorAll("[data-why-more]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const section = btn.closest("[data-why]");
      if (!section) return;
      const open = section.classList.toggle("is-open");
      btn.innerHTML = open ? "Read less <span>−</span>" : (btn.dataset.label || "Read more") + " <span>+</span>";
    });
    btn.dataset.label = btn.textContent.replace(/\s*[+−]\s*$/, "").trim();
  });

  document.getElementById("quickContactForm")?.addEventListener("submit", function (e) {
    e.preventDefault();
    const form = this;
    const data = new FormData(form);
    fetch((window.wvnAjax && window.wvnAjax.url) || "/wp-admin/admin-ajax.php", {
      method: "POST",
      body: data,
    }).then(() => {
      const msg = document.getElementById("form-message");
      if (msg) msg.textContent = "Thank you. We will be in touch shortly.";
      form.reset();
    }).catch(() => {
      const msg = document.getElementById("form-message");
      if (msg) msg.textContent = "Please email us directly if this form does not send.";
    });
  });
})();
