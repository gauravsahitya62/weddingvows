(function () {
  var nav = document.querySelector("[data-wvn-venue-nav]");
  if (!nav) return;

  var links = Array.prototype.slice.call(nav.querySelectorAll("a[href^='#']"));
  var sections = links
    .map(function (link) {
      var id = link.getAttribute("href").slice(1);
      return document.getElementById(id);
    })
    .filter(Boolean);

  function setActive() {
    var y = window.scrollY + 96;
    var current = sections[0];
    sections.forEach(function (section) {
      if (section.offsetTop <= y) current = section;
    });
    links.forEach(function (link) {
      var on = current && link.getAttribute("href") === "#" + current.id;
      link.classList.toggle("is-active", !!on);
    });
  }

  links.forEach(function (link) {
    link.addEventListener("click", function (e) {
      var id = link.getAttribute("href").slice(1);
      var target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });

  window.addEventListener("scroll", setActive, { passive: true });
  setActive();
})();
