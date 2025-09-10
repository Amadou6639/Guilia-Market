document.addEventListener("DOMContentLoaded", () => {
  // --- Mobile Menu Logic ---
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", () => {
      mobileMenu.classList.toggle("scale-y-0");
      mobileMenu.classList.toggle("scale-y-100");
    });
  }
});
