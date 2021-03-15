"use strict";

$(document).ready(function () {
  mark("diet");
  $("#result-div").hide();
  $("#calculate-button").click(function () {
    let mass_kg = $("#mass-input").val();
    let water_L = 0.035 * mass_kg;
    let result = water_L.toFixed(1);
    $("#result-p").html(result);
    $("#result-div").slideDown();
  });
});