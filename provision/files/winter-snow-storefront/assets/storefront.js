(function () {
  "use strict";

  function mountMenuToggle(root) {
    var toggle = root.querySelector(".wss-menu-toggle");
    if (!toggle) {
      return;
    }

    var panelId = toggle.getAttribute("aria-controls");
    var panel = panelId ? root.querySelector("#" + panelId) : null;
    if (!panel) {
      return;
    }

    toggle.addEventListener("click", function () {
      var isExpanded = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", isExpanded ? "false" : "true");
      panel.hidden = isExpanded;
    });

    panel.querySelectorAll("a").forEach(function (item) {
      item.addEventListener("click", function () {
        toggle.setAttribute("aria-expanded", "false");
        panel.hidden = true;
      });
    });
  }

  function updateCountdown(node) {
    var target = Date.parse(node.getAttribute("data-expiry") || "");
    if (!target) {
      return;
    }

    var dayNode = node.querySelector("[data-unit='days']");
    var hourNode = node.querySelector("[data-unit='hours']");
    var minuteNode = node.querySelector("[data-unit='minutes']");
    var secondNode = node.querySelector("[data-unit='seconds']");

    if (!dayNode || !hourNode || !minuteNode || !secondNode) {
      return;
    }

    var render = function () {
      var now = Date.now();
      var remaining = Math.max(0, target - now);

      var seconds = Math.floor(remaining / 1000);
      var days = Math.floor(seconds / 86400);
      seconds -= days * 86400;
      var hours = Math.floor(seconds / 3600);
      seconds -= hours * 3600;
      var minutes = Math.floor(seconds / 60);
      seconds -= minutes * 60;

      dayNode.textContent = String(days).padStart(2, "0");
      hourNode.textContent = String(hours).padStart(2, "0");
      minuteNode.textContent = String(minutes).padStart(2, "0");
      secondNode.textContent = String(seconds).padStart(2, "0");
    };

    render();
    window.setInterval(render, 1000);
  }

  document.querySelectorAll(".wss-site-shell").forEach(function (shell) {
    mountMenuToggle(shell);
    shell.querySelectorAll(".wss-countdown").forEach(updateCountdown);
  });
})();
