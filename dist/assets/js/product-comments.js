$(document).ready(function () {
  let currentPage = getPageName();
  let name = "";
  let comment = "";
  let allNeededDataGiven = true;
  $("#name-input").click(function () {
    $("#name-input").removeClass("emptyWarning");
    $("#name-input-warning").hide();
  });
  $("#submit").click(function () {
    console.log("Нажал на кнопку 'Добавить комментарий'.");
    name = $("#name-input").val();

    if (isEmpty(name)) {
      allNeededDataGiven = false;
      $("#name-input").addClass("emptyWarning");
      $("#name-input-warning").slideDown();
    }

    comment = $("#comment-input").val();
    console.log("Все данные проверены. Всё в порядке ? " + allNeededDataGiven);

    if (allNeededDataGiven) {
      console.log("Все данные в порядке.");
      let message = `<h3><u>Комментарий от посетителя</u></h3>
                  <p>Страница : ${currentPage}</p>
                  <p>Имя посетителя : ${name}</p>
                  <p>Комментарий    : ${comment}</p>`;
      message = message.replace(/</g, "%3C");
      console.log("Все данные предоставлены. Сейчас их отправим.");
      $("#spinner-icon").show();
      let request = `assets/php/sendMeUserComment.php?message=${message}`;

      let callback = function (serverResponse) {
        console.log("получен serverResponse = " + serverResponse);

        if (serverResponse == "success") {
          $("#spinner-icon").hide();
          $("#success").slideDown();
        } else {
          $("#spinner-icon").hide();
          $("#failure").slideDown();
        }
      };

      runServerCodeAsync(request, callback);
      let user = JSON.parse(localStorage.getItem("userInLS"));

      if (user == null) {
        user = {
          name: name,
          phone: phone,
          email: ""
        };
      } else {
        user.name = name;
        user.phone = phone;
      }

      localStorage.setItem("userInLS", JSON.stringify(user));
      let techMessage = "<p>Имя посетителя : " + name + "</p><p>Его телефон    : " + phone + "</p><p>Откуда он(а)   : " + place + "</p><p>Комментарий    : " + comment + "</p>";
      reportTelemetry("комментарий", techMessage);
    }
  });

  function emulateServerCall(request, callback) {
    let serverResponse = "success";
    setTimeout(2000, callback(serverResponse));
  }

  function isEmpty(x) {
    let result = false;
    if (x == null || x == undefined || x == "" || x == 0) result = true;
    return result;
  }
});

function setPageName(pageName) {
  localStorage.setItem("currentPageInLS", "продуктовая страница - " + pageName);
}

function getPageName() {
  return localStorage.getItem("currentPageInLS");
}