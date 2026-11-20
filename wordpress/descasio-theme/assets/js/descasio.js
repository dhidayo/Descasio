/**
 * Descasio theme behaviour: navigation, theme toggle, smooth scroll and the motion layer.
 * Vanilla JS replacements for the Next.js site's React/Motion components.
 * Everything honours prefers-reduced-motion. Descasio.init(root) re-runs on builder previews.
 */
(function () {
  "use strict";

  var html = document.documentElement;
  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var inBuilder = function () {
    return document.body.classList.contains("elementor-editor-active") || document.body.classList.contains("vc_editor") || !!window.vc_iframe;
  };

  /* ---------- Theme toggle ---------- */
  function initThemeToggle() {
    document.querySelectorAll("[data-de-theme-toggle]").forEach(function (btn) {
      if (btn.dataset.ready) return;
      btn.dataset.ready = "1";
      btn.addEventListener("click", function () {
        var next = html.dataset.theme === "dark" ? "light" : "dark";
        html.dataset.theme = next;
        try { localStorage.setItem("theme", next); } catch (e) {}
      });
    });
  }

  /* ---------- Smooth scrolling (Lenis) ---------- */
  function initLenis() {
    if (reduce || inBuilder() || typeof window.Lenis !== "function") return;
    var lenis = new window.Lenis({ lerp: 0.1, smoothWheel: true });
    function raf(t) { lenis.raf(t); requestAnimationFrame(raf); }
    requestAnimationFrame(raf);
    window.DescasioLenis = lenis;
  }

  /* ---------- Navigation ---------- */
  function initNav() {
    var header = document.querySelector("[data-de-nav]");
    if (!header || header.dataset.ready) return;
    header.dataset.ready = "1";
    var bar = header.querySelector("[data-de-bar]");
    var dropdowns = Array.prototype.slice.call(header.querySelectorAll("[data-de-dropdown]"));
    var mobileBtn = header.querySelector("[data-de-mobile-toggle]");
    var timer;
    var scrolled = false;

    function sync() {
      var anyOpen = dropdowns.some(function (d) { return d.classList.contains("is-open"); });
      var mobile = html.classList.contains("de-mobile-open");
      html.classList.toggle("de-menu-open", anyOpen || mobile);
      bar.classList.toggle("is-solid", scrolled || anyOpen || mobile);
    }
    function open(dd) {
      clearTimeout(timer);
      dropdowns.forEach(function (d) {
        var on = d === dd;
        d.classList.toggle("is-open", on);
        d.querySelector("button").setAttribute("aria-expanded", on ? "true" : "false");
      });
      sync();
    }
    function closeAll() {
      dropdowns.forEach(function (d) {
        d.classList.remove("is-open");
        d.querySelector("button").setAttribute("aria-expanded", "false");
      });
      html.classList.remove("de-mobile-open");
      if (mobileBtn) mobileBtn.setAttribute("aria-expanded", "false");
      sync();
    }

    dropdowns.forEach(function (dd) {
      dd.addEventListener("mouseenter", function () { open(dd); });
      dd.addEventListener("mouseleave", function () { timer = setTimeout(closeAll, 160); });
      dd.querySelector("button").addEventListener("click", function () {
        dd.classList.contains("is-open") ? closeAll() : open(dd);
      });
    });
    header.querySelector("[data-de-scrim]").addEventListener("click", closeAll);
    document.addEventListener("keydown", function (e) { if (e.key === "Escape") closeAll(); });

    if (mobileBtn) {
      mobileBtn.addEventListener("click", function () {
        var on = !html.classList.contains("de-mobile-open");
        dropdowns.forEach(function (d) { d.classList.remove("is-open"); });
        html.classList.toggle("de-mobile-open", on);
        mobileBtn.setAttribute("aria-expanded", on ? "true" : "false");
        mobileBtn.setAttribute("aria-label", on ? "Close menu" : "Open menu");
        sync();
      });
    }

    function onScroll() {
      var next = window.scrollY > 24;
      if (next !== scrolled) { scrolled = next; sync(); }
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }

  /* ---------- Scroll reveal ---------- */
  var revealObserver = "IntersectionObserver" in window
    ? new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) {
            e.target.classList.add("is-visible");
            revealObserver.unobserve(e.target);
            countUpWithin(e.target);
          }
        });
      }, { threshold: 0.2 })
    : null;

  function initReveal(root) {
    root.querySelectorAll("[data-reveal]:not(.is-visible)").forEach(function (el) {
      if (reduce || inBuilder() || !revealObserver) {
        el.classList.add("is-visible");
        countUpWithin(el);
      } else {
        revealObserver.observe(el);
      }
    });
  }

  /* ---------- Count-up statistics ---------- */
  function countUpWithin(root) {
    var nodes = root.matches && root.matches("[data-count-to]") ? [root] : [];
    nodes = nodes.concat(Array.prototype.slice.call(root.querySelectorAll ? root.querySelectorAll("[data-count-to]") : []));
    nodes.forEach(function (el) {
      if (el.dataset.counted) return;
      el.dataset.counted = "1";
      var to = parseFloat(el.dataset.countTo) || 0;
      var suffix = el.dataset.suffix || "";
      if (reduce || inBuilder()) { el.textContent = to + suffix; return; }
      var start = performance.now();
      var dur = 1600;
      function tick(now) {
        var p = Math.min(1, (now - start) / dur);
        var eased = 1 - Math.pow(1 - p, 4);
        el.textContent = Math.round(to * eased) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      }
      el.textContent = "0" + suffix;
      requestAnimationFrame(tick);
    });
  }

  /* ---------- Spotlight cards ---------- */
  function initSpotlight(root) {
    if (reduce) return;
    root.querySelectorAll(".de-spotlight").forEach(function (card) {
      if (card.dataset.ready) return;
      card.dataset.ready = "1";
      card.addEventListener("pointermove", function (e) {
        var r = card.getBoundingClientRect();
        card.style.setProperty("--x", e.clientX - r.left + "px");
        card.style.setProperty("--y", e.clientY - r.top + "px");
      });
      card.addEventListener("pointerleave", function () {
        card.style.setProperty("--x", "-400px");
        card.style.setProperty("--y", "-400px");
      });
    });
  }

  /* ---------- Hero parallax ---------- */
  function initParallax(root) {
    if (reduce) return;
    root.querySelectorAll("[data-parallax-root]").forEach(function (section) {
      if (section.dataset.ready) return;
      section.dataset.ready = "1";
      section.addEventListener("pointermove", function (e) {
        var r = section.getBoundingClientRect();
        section.style.setProperty("--px", ((e.clientX - r.left) / r.width - 0.5).toFixed(3));
        section.style.setProperty("--py", ((e.clientY - r.top) / r.height - 0.5).toFixed(3));
      });
    });
  }

  /* ---------- Tabs ---------- */
  function initTabs(root) {
    root.querySelectorAll("[data-de-tabs]").forEach(function (wrap) {
      if (wrap.dataset.ready) return;
      wrap.dataset.ready = "1";
      var tabs = wrap.querySelectorAll("[role=tab]");
      var panels = wrap.querySelectorAll("[role=tabpanel]");
      function select(i) {
        tabs.forEach(function (t, j) {
          var on = i === j;
          t.setAttribute("aria-selected", on ? "true" : "false");
          t.tabIndex = on ? 0 : -1;
        });
        panels.forEach(function (p, j) { p.hidden = i !== j; });
      }
      tabs.forEach(function (t, i) {
        t.addEventListener("click", function () { select(i); });
        t.addEventListener("keydown", function (e) {
          if (e.key === "ArrowRight" || e.key === "ArrowLeft") {
            var n = (i + (e.key === "ArrowRight" ? 1 : tabs.length - 1)) % tabs.length;
            select(n);
            tabs[n].focus();
          }
        });
      });
      select(0);
    });
  }

  function init(root) {
    root = root || document;
    initThemeToggle();
    initReveal(root);
    initSpotlight(root);
    initParallax(root);
    initTabs(root);
  }

  window.Descasio = { init: init, countUpWithin: countUpWithin };

  function boot() {
    initLenis();
    initNav();
    init(document);
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();

  /* Elementor editor: re-run after each widget renders */
  window.addEventListener("elementor/frontend/init", function () {
    if (!window.elementorFrontend || !window.elementorFrontend.hooks) return;
    window.elementorFrontend.hooks.addAction("frontend/element_ready/global", function ($scope) {
      init($scope && $scope[0] ? $scope[0] : document);
    });
  });
})();
