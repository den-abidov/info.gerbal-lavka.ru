console.log("get-pricelist-form.js : зашёл.");

function getPricelistFormProps() {
  const send = document.getElementById("send-email");
  const sendingMessage = document.getElementById("sending-email");
  const successMessage = document.getElementById("email-sent-success");
  const failureMessage = document.getElementById("email-sent-failure");
  return {
    email: '',
    emailError: false,
    errorVisible: false,
    sendVisible: true,
    sendingVisible: false,
    successVisible: false,
    failureVisible: false,
    removeErrorMessages: function () {
      this.emailError = false;
      this.sendVisible = true;
      this.sendingVisible = false;
      this.successVisible = false;
      this.failureVisible = false;
    },
    whenSendPressed: function () {
      this.sendVisible = false;
      this.sendingVisible = true;
      let emailIsValid = validateEmail(this.email);
      this.emailError = !emailIsValid;

      if (this.emailError) {
        this.sendingVisible = false;
        this.sendVisible = true;
        return;
      }

      console.log("get-pricelist-form.js : Почта валидна. Буду отправлять каталог.");
      let data = {
        user_email: this.email
      };
      console.log("Электронная почта для отправки каталога. Проверька :");
      console.log(data);
      fetch(settings.send_pricelist_url + '?user_email=' + this.email).then(response => response.text()).then(data => {
        successMessage.style.display = "block";
        send.style.display = "none";
        callAfterDelay(20000, () => {
          successMessage.style.display = "none";
          send.style.display = "block";
        });
      }).catch(error => {
        console.error('get-pricelist-form.js :  Error : ', error);
        failureMessage.style.display = "block";
        callAfterDelay(5000, () => {
          failureMessage.style.display = "none";
          send.style.display = "block";
        });
      }).finally(function () {
        console.log("get-pricelist-form.js : Выход из общения с сервером.");
        sendingMessage.style.display = "none";
      });
      logEvent("отправил каталог на : " + this.email);
    }
  };
}