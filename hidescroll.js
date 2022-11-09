var loader = document.getElementById("ld");

window.addEventListener("load", function() {
    document.body.style.overflow = "hidden"
    window.setTimeout(() => {
      loader.style.display = "none";
      document.body.style.overflow = "auto"
    }, 2700)
  })