(function () {
  const anchorLinks = document.querySelectorAll('a[href^="#"], a[href*="/#"]');

  anchorLinks.forEach((link) => {
    link.addEventListener("click", () => {
      document.documentElement.classList.remove("menu-open");
    });
  });
})();
