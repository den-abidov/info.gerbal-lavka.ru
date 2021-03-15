console.log("phone-coupon.js : зашёл.");

function getPhoneCouponProps() {
  const sendButton = document.getElementById("phone-coupon-send");
  const sendingMessage = document.getElementById("phone-coupon-sending");
  const successMessage = document.getElementById("phone-coupon-success");
  const failureMessage = document.getElementById("phone-coupon-failure");
  return {
    phone: '',
    errorVisible: false,
    sendVisible: true,
    sendingVisible: false,
    successVisible: false,
    failureVisible: false,
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

      console.log("phone-coupon.js : телефон валидный. Буду отправлять СМС.");
      let data = {
        site: settings.site_name,
        SMS_text: settings.SMS_text,
        user_phone: PhoneNumber(this.phone).formatted,
        user_time: getUserTime()
      };
      fetch(settings.send_coupon_url, {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest"
        },
        method: 'post',
        credentials: "same-origin",
        body: JSON.stringify(data)
      }).then(response => response.text()).then(data => {
        console.log("phone-coupon.js : Успешно. Сервер ответил : " + data);
        successMessage.style.display = "block";
        sendButton.style.display = "none";
        callAfterDelay(20000, () => {
          successMessage.style.display = "none";
          sendButton.style.display = "block";
        });
      }).catch(error => {
        console.log("phone-coupon.js : Ошибка. Сервер ответил : " + error);
        failureMessage.style.display = "block";
        callAfterDelay(5000, () => {
          failureMessage.style.display = "none";
          sendButton.style.display = "block";
        });
      }).finally(function () {
        console.log("phone-coupon.js : Выход из общения с сервером.");
        sendingMessage.style.display = "none";
      });
      logEvent("подарочный купон");
    }
  };
}