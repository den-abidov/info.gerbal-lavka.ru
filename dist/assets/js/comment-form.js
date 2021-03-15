console.log("comment-form.js : зашёл.");

function getCommentFormProps() {
  const subject_ = document.getElementById("subject").value;
  const send = document.getElementById("send-comment");
  const sendingMessage = document.getElementById("sending-comment");
  const successMessage = document.getElementById("comment-sent-success");
  const failureMessage = document.getElementById("comment-sent-failure");
  return {
    subject: subject_,
    site: settings.site_name,
    deviceId: getDeviceIdFromLS(),
    name: getUserNameFromLS(),
    phone: getUserPhoneFromLS(),
    place: '',
    comment: '',
    nameError: false,
    commentError: false,
    errorVisible: false,
    sendVisible: true,
    sendingVisible: false,
    successVisible: false,
    failureVisible: false,
    removeErrorMessages: function () {
      this.nameError = false;
      this.commentError = false;
      this.sendVisible = true;
      this.sendingVisible = false;
      this.successVisible = false;
      this.failureVisible = false;
    },
    whenSendPressed: function () {
      this.sendVisible = false;
      this.sendingVisible = true;
      let nameIsValid = this.name.length > 0;
      let commentIsValid = this.comment.length > 0;
      this.nameError = !nameIsValid;
      this.commentError = !commentIsValid;

      if (this.nameError || this.commentError) {
        this.sendingVisible = false;
        this.sendVisible = true;
        return;
      }

      console.log("comment-form.js : Данные комментария валидны. Буду отправлять комментарий.");
      let comment_ = this.comment;

      if (subject_ === "отзыв покупателя") {
        comment_ = "<u>Откуда пользователь</u> : " + this.place + "<br/><u>Текст комментария</u> : " + this.comment;
      }

      let data = {
        subject: this.subject,
        site: settings.site_name,
        device_id: this.deviceId,
        user_name: this.name,
        user_phone: this.phone,
        comment: comment_
      };
      console.log("Данные для отправки комментария. Проверька их :");
      console.log(data);
      fetch(settings.send_comment_url, {
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
        send.style.display = "none";
        callAfterDelay(20000, () => {
          successMessage.style.display = "none";
          send.style.display = "block";
        });
      }).catch(error => {
        console.error('comment-form.js :  Error : ', error);
        failureMessage.style.display = "block";
        callAfterDelay(5000, () => {
          failureMessage.style.display = "none";
          send.style.display = "block";
        });
      }).finally(function () {
        console.log("comment-form.js : Выход из общения с сервером.");
        sendingMessage.style.display = "none";
      });
      logEvent(subject_);
    }
  };
}

function setPageName(pageName) {
  localStorage.setItem("currentPageInLS", "продуктовая страница - " + pageName);
}

function getPageName() {
  return localStorage.getItem("currentPageInLS");
}