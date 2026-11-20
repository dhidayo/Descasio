/**
 * Descasio Elements: contact form and AI Readiness Assessment.
 * Submissions post to admin-ajax.php and land in the Leads inbox.
 */
(function () {
  "use strict";

  var cfg = window.DescasioElements || {};

  function post(action, form, extra) {
    var body = new FormData(form);
    body.append("action", action);
    body.append("nonce", cfg.nonce || "");
    Object.keys(extra || {}).forEach(function (k) { body.append(k, extra[k]); });
    return fetch(cfg.ajaxUrl, { method: "POST", body: body, credentials: "same-origin" }).then(function (r) {
      return r.json().catch(function () { return { success: false, data: { message: "Something went wrong. Please try again." } }; });
    });
  }

  function setBusy(form, busy, label) {
    var btn = form.querySelector("button[type=submit]");
    if (!btn) return;
    btn.disabled = busy;
    btn.querySelector(".de-spinner").classList.toggle("hidden", !busy);
    if (label) btn.querySelector(".de-submit-label").textContent = label;
  }

  function showErrors(form, errors, message) {
    form.querySelectorAll("[data-error-for]").forEach(function (p) {
      var name = p.getAttribute("data-error-for");
      var input = form.querySelector('[name="' + name + '"]');
      var msg = errors && errors[name];
      p.textContent = msg || "";
      p.classList.toggle("hidden", !msg);
      if (input) {
        input.setAttribute("aria-invalid", msg ? "true" : "false");
        if (msg) input.setAttribute("aria-describedby", p.id || (p.id = "err-" + name));
      }
    });
    var alert = form.querySelector(".de-form-alert");
    if (alert) {
      alert.textContent = message || "";
      alert.classList.toggle("hidden", !message);
      alert.classList.toggle("flex", !!message);
    }
    var first = form.querySelector('[aria-invalid="true"]');
    if (first) first.focus();
  }

  /* ---------- Contact form ---------- */
  function initContact(root) {
    root.querySelectorAll('[data-de-form="contact"]').forEach(function (wrap) {
      if (wrap.dataset.ready) return;
      wrap.dataset.ready = "1";
      var form = wrap.querySelector("form");
      var label = form.querySelector(".de-submit-label").textContent;
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        setBusy(form, true, "Sending...");
        post("descasio_contact", form).then(function (res) {
          setBusy(form, false, label);
          if (res.success) {
            form.classList.add("hidden");
            var ok = wrap.querySelector(".de-form-success");
            ok.querySelector(".de-success-text").textContent = res.data.message;
            ok.classList.remove("hidden");
            ok.classList.add("flex");
          } else {
            showErrors(form, res.data && res.data.errors, res.data && res.data.message);
          }
        }).catch(function () {
          setBusy(form, false, label);
          showErrors(form, null, "We couldn't send your request. Please check your connection, or email us directly.");
        });
      });
    });
  }

  /* ---------- AI Readiness Assessment ---------- */
  function el(html) {
    var t = document.createElement("template");
    t.innerHTML = html.trim();
    return t.content.firstChild;
  }
  function esc(s) {
    return String(s).replace(/[&<>"']/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]; });
  }

  function score(answers, data) {
    var raw = [0, 0, 0, 0];
    answers.forEach(function (opt, i) {
      if (opt >= 0) raw[data.questions[i].dim] += data.questions[i].options[opt].score;
    });
    var dims = raw.map(function (s) { return Math.round((s / 12) * 25); });
    var total = Math.round(raw.reduce(function (t, s) { return t + (s / 12) * 25; }, 0));
    var verdict = data.verdicts.filter(function (v) { return total >= v.min; })[0];
    var recs = dims.map(function (d, i) { return data.recommendations[i][d <= 6 ? 0 : d <= 12 ? 1 : d <= 18 ? 2 : 3]; });
    return { total: total, dims: dims, verdict: verdict, recs: recs };
  }

  function initAssessment(root) {
    root.querySelectorAll("[data-de-assessment]").forEach(function (wrap) {
      if (wrap.dataset.ready) return;
      wrap.dataset.ready = "1";
      var conf = JSON.parse(wrap.getAttribute("data-config"));
      var data = conf.data;
      var s = conf.strings;
      var qs = data.questions;
      var answers = qs.map(function () { return -1; });
      var step = 0;
      var quiz = wrap.querySelector('[data-step="quiz"]');
      var gate = wrap.querySelector('[data-step="gate"]');
      var results = wrap.querySelector('[data-step="results"]');

      function show(name) {
        quiz.hidden = name !== "quiz";
        gate.hidden = name !== "gate";
        results.hidden = name !== "results";
      }

      function renderQuestion(dir) {
        var q = qs[step];
        var done = answers.filter(function (a) { return a >= 0; }).length;
        var opts = q.options.map(function (o, i) {
          var sel = answers[step] === i;
          return '<button type="button" data-opt="' + i + '" aria-pressed="' + sel + '" class="flex items-center gap-4 rounded-[16px] border px-5 py-4 text-left text-[16px] font-medium transition-[border-color,background-color,transform] duration-300 hover:-translate-y-0.5 active:scale-[0.99] ' +
            (sel ? "border-accent bg-accent-soft text-fg" : "border-line bg-[var(--bg-elevated)]/60 text-fg hover:border-accent/60") + '">' +
            '<span class="grid size-7 shrink-0 place-items-center rounded-full border-2 text-xs font-bold ' + (sel ? "border-accent bg-accent text-white" : "border-line text-muted") + '">' + String.fromCharCode(65 + i) + "</span>" + esc(o.text) + "</button>";
        }).join("");
        quiz.innerHTML =
          '<div class="flex items-center justify-between gap-4 text-sm"><span class="font-bold text-fg">' + s.question.replace("%1$d", step + 1).replace("%2$d", qs.length) + '</span><span class="font-semibold text-accent-strong dark:text-accent">' + esc(data.dimensions[q.dim]) + "</span></div>" +
          '<div class="mt-3 h-1.5 overflow-hidden rounded-full bg-line" role="progressbar" aria-label="Assessment progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="' + Math.round((done / qs.length) * 100) + '"><div class="de-bar h-full rounded-full bg-accent" style="width:' + (done / qs.length) * 100 + '%"></div></div>' +
          '<div class="relative mt-10 min-h-[420px] overflow-hidden"><fieldset class="' + (dir < 0 ? "de-q-enter-back" : "de-q-enter") + '"><legend class="text-2xl font-extrabold leading-snug tracking-tight text-fg md:text-[1.75rem]">' + esc(q.q) + '</legend><p class="mt-2 text-muted">' + esc(q.context) + '</p><div class="mt-7 grid gap-3">' + opts + "</div></fieldset></div>" +
          '<div class="mt-6 flex items-center justify-between"><button type="button" data-prev class="inline-flex items-center gap-2 font-semibold text-muted transition-colors hover:text-fg' + (step === 0 ? " invisible" : "") + '"><i class="ph-bold ph-arrow-left" aria-hidden="true"></i> ' + esc(s.back) + "</button>" +
          (answers[step] >= 0 && step < qs.length - 1 ? '<button type="button" data-next class="inline-flex items-center gap-2 font-semibold text-fg">' + esc(s.next) + ' <i class="ph-bold ph-arrow-right" aria-hidden="true"></i></button>' : "") + "</div>";

        quiz.querySelectorAll("[data-opt]").forEach(function (b) {
          b.addEventListener("click", function () {
            answers[step] = parseInt(b.getAttribute("data-opt"), 10);
            renderQuestion(0);
            setTimeout(function () {
              if (step < qs.length - 1) { step++; renderQuestion(1); }
              else if (answers.every(function (a) { return a >= 0; })) toGate();
            }, 220);
          });
        });
        var prev = quiz.querySelector("[data-prev]");
        if (prev) prev.addEventListener("click", function () { step = Math.max(0, step - 1); renderQuestion(-1); });
        var next = quiz.querySelector("[data-next]");
        if (next) next.addEventListener("click", function () { step++; renderQuestion(1); });
      }

      function toGate() {
        gate.querySelector("[data-score-preview]").textContent = score(answers, data).total + "/100";
        show("gate");
      }

      function renderResults(r) {
        var c = 2 * Math.PI * 70;
        var dims = data.dimensions.map(function (d, i) {
          return '<div class="rounded-[18px] border border-line bg-[var(--bg-elevated)]/60 p-6"><div class="flex items-baseline justify-between gap-3"><h3 class="font-bold text-fg">' + esc(d) + '</h3><p class="text-2xl font-extrabold text-fg">' + r.dims[i] + '<span class="text-sm font-semibold text-muted">/25</span></p></div>' +
            '<div class="de-bar mt-3 h-1.5 rounded-full bg-accent" style="width:0" data-w="' + (r.dims[i] / 25) * 100 + '%"></div><p class="mt-4 text-[15px] leading-relaxed text-muted">' + esc(r.recs[i]) + "</p></div>";
        }).join("");
        results.querySelector("[data-results]").innerHTML =
          '<div class="grid items-center gap-8 md:grid-cols-[auto_1fr]"><div class="relative mx-auto size-44"><svg viewBox="0 0 160 160" class="size-full -rotate-90" aria-hidden="true"><circle cx="80" cy="80" r="70" fill="none" stroke="var(--line)" stroke-width="12"/><circle class="de-ring" cx="80" cy="80" r="70" fill="none" stroke="var(--accent)" stroke-width="12" stroke-linecap="round" stroke-dasharray="' + c + '" stroke-dashoffset="' + c + '" style="transition:stroke-dashoffset 1.4s cubic-bezier(.16,1,.3,1) .2s"/></svg>' +
          '<div class="absolute inset-0 grid place-items-center text-center"><div><p class="text-5xl font-extrabold tracking-[-0.04em] text-fg">' + r.total + '</p><p class="text-xs font-bold text-muted">' + esc(s.outOf) + "</p></div></div></div>" +
          '<div><h2 class="text-3xl font-extrabold tracking-tight text-fg">' + esc(r.verdict.headline) + '</h2><p class="mt-3 max-w-xl leading-relaxed text-muted">' + esc(r.verdict.summary) + "</p></div></div>" +
          '<div class="mt-10 grid gap-4 sm:grid-cols-2">' + dims + "</div>";
        show("results");
        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            results.querySelector(".de-ring").style.strokeDashoffset = c - (r.total / 100) * c;
            results.querySelectorAll("[data-w]").forEach(function (b) { b.style.width = b.getAttribute("data-w"); });
          });
        });
        wrap.scrollIntoView({ behavior: "smooth", block: "start" });
      }

      var form = gate.querySelector("form");
      var label = form.querySelector(".de-submit-label").textContent;
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        setBusy(form, true, "Calculating...");
        post("descasio_assessment", form, { answers: answers.join(",") }).then(function (res) {
          setBusy(form, false, label);
          if (res.success) renderResults(score(answers, data));
          else showErrors(form, res.data && res.data.errors, res.data && res.data.message);
        }).catch(function () {
          // Results are always shown, even if saving the lead fails.
          setBusy(form, false, label);
          renderResults(score(answers, data));
        });
      });
      gate.querySelector("[data-de-back]").addEventListener("click", function () { step = qs.length - 1; show("quiz"); renderQuestion(-1); });
      results.querySelector("[data-de-restart]").addEventListener("click", function () {
        answers = qs.map(function () { return -1; });
        step = 0;
        show("quiz");
        renderQuestion(1);
      });

      show("quiz");
      renderQuestion(1);
    });
  }

  function init(root) {
    initContact(root || document);
    initAssessment(root || document);
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", function () { init(document); });
  else init(document);

  window.addEventListener("elementor/frontend/init", function () {
    if (!window.elementorFrontend || !window.elementorFrontend.hooks) return;
    window.elementorFrontend.hooks.addAction("frontend/element_ready/global", function ($scope) {
      init($scope && $scope[0] ? $scope[0] : document);
    });
  });
})();
