const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector(".sidebar").classList.toggle("expand");
});



function checkScreenSize() {
  if (window.matchMedia("(max-width: 992px)").matches) {
    document.querySelector(".sidebar").classList.remove("expand");
  } else {
    document.querySelector(".sidebar").classList.add("expand");
  }
}

// Run on page load
checkScreenSize();

// Run on window resize
window.addEventListener("resize", checkScreenSize);