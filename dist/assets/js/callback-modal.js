console.log("callback-modal.js : зашёл.");

function getCallbackModalProps() {
  const sendButton = document.getElementById("send");
  const sendingMessage = document.getElementById("sending");
  const successMessage = document.getElementById("success");
  const failureMessage = document.getElementById("failure");
  return {
    name: getUserNameFromLS(),
    phone: getUserPhoneFromLS(),
    whenToCall: 'сейчас',
    errorVisible: false,
    sendVisible: true,
    sendingVisible: false,
    successVisible: false,
    failureVisible: false,
    whenNameChanged: function () {
      localStorage.setItem("userName", this.name);
    },
    whenPhoneChanged: function () {
      this.errorVisible = false;
      this.sendVisible = true;
      this.sendingVisible = false;
      this.successVisible = false;
      this.failureVisible = false;
      localStorage.setItem("userPhone", this.phone);
    },
    whenSendPressed: function () {
      this.sendVisible = false;
      this.sendingVisible = true;
      let phoneIsValid = PhoneNumber(this.phone).valid;
      this.errorVisible = !phoneIsValid;

      if (this.errorVisible) {
        this.sendingVisible = false;
        this.sendVisible = true;
        return;
      }

      console.log("callback-modal.js : телефон валидный. Буду отправлять заявку.");
      let data = {
        site: settings.site_name,
        user_name: this.name,
        user_phone: PhoneNumber(this.phone).formatted,
        when_to_call: this.whenToCall,
        user_time: getUserTime()
      };
      fetch(settings.notify_callback_url, {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest"
        },
        method: 'post',
        credentials: "same-origin",
        body: JSON.stringify(data)
      }).then(response => response.text()).then(data => {
        successMessage.style.display = "block";
        sendButton.style.display = "none";
        callAfterDelay(20000, () => {
          successMessage.style.display = "none";
          sendButton.style.display = "block";
        });
      }).catch(error => {
        console.error('callback-modal.js :  Error : ', error);
        failureMessage.style.display = "block";
        callAfterDelay(5000, () => {
          failureMessage.style.display = "none";
          sendButton.style.display = "block";
        });
      }).finally(function () {
        console.log("callback-modal.js : Выход из общения с сервером.");
        sendingMessage.style.display = "none";
      });
      logEvent("обратный звонок");
    }
  };
}