const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

document.addEventListener("DOMContentLoaded", function () {
  const elements = document.querySelectorAll(
    ".animated-left-to-right, .animated-right-to-left, .animated-top-to-bottom, .animated-bottom-to-top, .animated-hidden-to-show"
  );

  if (elements.length === 0) return;

  function checkVisibility() {
    const windowHeight = window.innerHeight || document.documentElement.clientHeight;

    elements.forEach((element) => {
      const rect = element.getBoundingClientRect();

      if (rect.top < windowHeight && rect.bottom > 0) {
        element.classList.add("show");
      }
    });
  }

  window.addEventListener("scroll", checkVisibility);
  checkVisibility();

  const textElement = document.getElementById("animated-text");
  const cursor = document.querySelector(".cursor");

  const text = "ARES AGENCY";
  let index = 0;

  function typeEffect() {
    if (index < text.length) {
      textElement.innerHTML += text[index];
      index++;
      setTimeout(typeEffect, 100);
    } else {
      cursor.style.display = "none";
    }
  }

  typeEffect();

  document.querySelectorAll("button, .button-link").forEach((button) => {
    button.addEventListener("click", (event) => {
      window.open("https://t.me/Aresagency_cpa");
    });
  });

  const menuButton = document.getElementById("menu-mobile");
  const menu = document.getElementById("menu");
  const close = document.getElementById("close");
  
  menuButton.addEventListener("click", () => {
      document.body.classList.toggle("no-scroll");
      menu.classList.toggle("hidden");
  });

  close.addEventListener("click", () => {
    document.body.classList.toggle("no-scroll");
    menu.classList.toggle("hidden");
});
});

window.onload = () => {
  setTimeout(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  }, 0);
};
