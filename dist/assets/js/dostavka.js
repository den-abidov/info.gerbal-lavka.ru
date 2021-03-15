$(document).ready(function () {
  mark("dostavka");
  $(".hide-link").click(function () {
    $(".answer").css("display", "none");
  });
  $("#dostavka-link").removeAttr("href");
  $("#dostavka-link").addClass("inactive");
});