function registrationRequest(name, phone, whenToCall, hasSponsor) {
  let data = {
    site: settings.site_name,
    user_name: name,
    user_phone: PhoneNumber(phone).formatted,
    when_to_call: whenToCall,
    has_sponsor: hasSponsor,
    user_time: getUserTime()
  };
  fetch(settings.notify_registration_request_url, {
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
    logEvent("хочет зарегистрироваться");
    window.location.href = "sent.html";
  }).catch(error => {
    console.error('registration-request.js :  Error : ', error);
    const failureMessage = document.getElementById("server-error");
    failureMessage.style.display = "block";
    callAfterDelay(5000, () => {
      failureMessage.style.display = "none";
    });
  }).finally(function () {
    console.log("registration-request.js : Выход из общения с сервером.");
  });
}