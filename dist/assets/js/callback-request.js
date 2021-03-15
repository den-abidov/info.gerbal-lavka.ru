console.log("callback-request.js : зашёл.");

function callbackRequest(name, phone, whenToCall, hasSponsor, pageName, pageDescription) {
  let data = {
    site: settings.site_name,
    user_name: name,
    user_phone: PhoneNumber(phone).formatted,
    when_to_call: whenToCall,
    has_sponsor: hasSponsor,
    user_time: getUserTime(),
    page_name: pageName,
    page_description: pageDescription
  };
  fetch(settings.notify_callback_request_url, {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json, text-plain, */*",
      "X-Requested-With": "XMLHttpRequest"
    },
    method: 'post',
    credentials: "same-origin",
    body: JSON.stringify(data)
  }).then(response => response.text()).then(data => {
    localStorage.setItem("requestSubmitted", true);
    logEvent("обратный звонок");
  }).then(data => {
    document.querySelector("#call-me").style.display = "none";
    document.querySelector("#submitted").style.display = "block";

    if (settings.zastavka_after_callback) {
      window.location.href = "sent.html";
    }
  }).catch(error => {
    console.error('callback-request.js :  Error : ', error);
    const failureMessage = document.getElementById("server-error");
    failureMessage.style.display = "block";
    callAfterDelay(5000, () => {
      failureMessage.style.display = "none";
    });
  }).finally(function () {
    console.log("callback-request.js : Выход из общения с сервером.");
  });
}