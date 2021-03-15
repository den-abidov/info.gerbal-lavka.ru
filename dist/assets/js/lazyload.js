!function () {
  function lazyload() {
    var images = document.querySelectorAll("img.lazyload");
    var i = images.length;
    !i && window.removeEventListener("scroll", lazyload);

    while (i--) {
      var wH = window.innerHeight;
      var offset = 100;
      var yPosition = images[i].getBoundingClientRect().top - wH;

      if (yPosition <= offset) {
        images[i].src = images[i].getAttribute("data-src");
        images[i].addEventListener('load', function () {
          this.classList.remove("lazyload");
        });
      }
    }
  }

  lazyload();
  window.addEventListener("scroll", lazyload);
}();