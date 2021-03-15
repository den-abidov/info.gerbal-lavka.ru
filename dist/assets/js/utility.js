"use strict";

function runServerCode(requestURL) {
  var result = null;
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      result = this.responseText;
    }
  };

  xmlhttp.open("GET", requestURL, false);
  xmlhttp.send();
  return result;
}

function runServerCodeAsync(requestURL, callback) {
  let xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      callback(this.responseText);
    }
  };

  xmlhttp.open("GET", requestURL, true);
  xmlhttp.send();
}

function runFetch(requestURL) {
  let result = null;
  fetch(requestURL).then(response => response.text()).then(response => {
    result = response;
    return result;
  });
}

function runFetchWithCallback(requestURL, callback) {
  fetch(requestURL).then(response => response.text()).then(response => {
    callback(response);
  });
}

function checkMobility() {
  var mobileOnly = false;

  if (mobileOnly) {
    document.getElementById("open").classList.add("show-for-small-only");
  } else {}
}

function checkSiteStatus() {
  var checkSiteStatus = false;

  if (checkSiteStatus) {
    var request = "assets/php/getStatus.php";
    var x = runServerCode(request);
    console.log("checkSiteStatus() : проверка ВКЛ ючена.");
    console.log("checkSiteStatus() : получил ответ от getStatus.php : " + x);
    $("#loading").hide();

    if (x == "on") {
      $("#open").show();
    } else {
      $("#closed").show();
    }
  } else {
    console.log("checkSiteStatus() : проверка ОТКЛ ючена.");
    $("#loading").hide();
    $("#open").show();
  }
}

function useConfig() {
  var request = "assets/php/readFile.php?fileName=config.json";
  var response = JSON.parse(runServerCode(request));
  var siteIsOn = response.siteIsOn;
  var mobileOnly = response.mobileOnly;
  var filterIp = response.filterIp;
  console.log("useConfig(): Проверка. response.siteIsOn = " + response.siteIsOn);
  console.log("useConfig(): Проверка. response.mobileOnly = " + response.mobileOnly);
  console.log("useConfig(): Проверка. response.filterIp = " + response.filterIp);

  if (mobileOnly == "true") {
    document.getElementById("open").classList.add("show-for-small-only");
  }

  $("#loading").hide();

  if (siteIsOn == "true") {
    console.log("useConfig() : сайт ВКЛ ючен.");
    $("#open").show();
  } else {
    console.log("useConfig() : сайт ОТКЛ ючен.");
    $("#open").hide();
    $("#closed").show();
  }
}

function mark(menuItemID) {
  $("#topNav-" + menuItemID).addClass("top-menu-item-selected");
  $("#footer-" + menuItemID).addClass("footer-menu-item-selected");
}

$(document).ready(function () {
  $(".open-Jivo").click(function () {
    jivo_api.open();
  });
  $("#open-Jivo-best-sellers").click(function () {
    jivo_api.open();
  });
});

function isEmpty(x) {
  let result = false;

  switch (x) {
    case 0:
      result = true;
      break;

    case "":
      result = true;
      break;

    case undefined:
      result = true;
      break;

    case null:
      result = true;
      break;
  }

  return result;
}

function emptyIfUnset(x) {
  let result = "";

  if (x == null || x == undefined) {} else {
    result = x;
  }

  return result;
}

function validateEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function checkIfPricelistSent() {
  console.log("checkIfPricelistSent() : вход.");
  let checkResult = localStorage.getItem("pricelistSentInLS");
  console.log("checkIfPricelistSent() : checkResult =" + checkResult);

  if (checkResult == "true") {
    console.log("checkIfPricelistSent() : переадресация на pricelistSent.html");
    window.location.replace("pricelistSent.html");
    console.log("checkIfPricelistSent() : переадресация запрошена");
  }

  console.log("checkIfPricelistSent() : выход.");
}

function delay(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

function callAfterDelay(ms, f) {
  delay(ms).then(() => f());
}

function isValidPhoneNumber(inputString) {
  let result = false;
  let onlyDigits = inputString.replace(/[^\n\d]+/g, '');

  if (onlyDigits.length == 10 || onlyDigits.length == 11) {
    result = true;
  }

  return result;
}

function formatPhoneNumber(inputString) {
  let result = inputString;
  const onlyDigits = inputString.replace(/[^\n\d]+/g, '');
  result = onlyDigits;
  const char1 = onlyDigits.charAt(0);
  const char2 = onlyDigits.charAt(1);

  if (onlyDigits.length === 10 && char1 === '9') {
    result = '8' + onlyDigits;
  }

  if (onlyDigits.length === 11 && char2 === '9') {
    result = '8' + onlyDigits.substring(1, 11);
  }

  return result;
}

function PhoneNumber(inputString) {
  let valid = false;
  let phone = inputString;
  const onlyDigits = inputString.replace(/[^\n\d]+/g, '');
  phone = onlyDigits;
  const char1 = onlyDigits.charAt(0);
  const char2 = onlyDigits.charAt(1);

  if (onlyDigits.length === 10 && char1 === '9') {
    valid = true;
    phone = '8' + onlyDigits;
  }

  if (onlyDigits.length === 11 && char2 === '9') {
    valid = true;
    phone = '8' + onlyDigits.substring(1, 11);
  }

  return {
    'valid': valid,
    'formatted': phone
  };
}

function getUserTime() {
  let now = new Date();
  let hours = now.getHours();
  let minutes = now.getMinutes();
  return hours + ':' + minutes;
}

function redirectIfRequestSubmitted() {
  console.log("redirectIfRequestSubmitted() : вход.");
  let checkResult = JSON.parse(localStorage.getItem("requestSubmitted"));

  if (checkResult === true && settings.zastavka_after_callback) {
    window.location.replace("sent.html");
  }

  console.log("redirectIfRequestSubmitted() : выход.");
}