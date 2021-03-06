'use strict';
console.log("callback-form.js : зашёл.");
// обработчик для формы обратного звонка
function initForm()
{
    return{
        showNameError: false,
        showPhoneError: false,
        showSponsorError: false,
        showWarning: false,
        showServerError: false,
        call:true,
        calling:false,
        submitted:false,
        validate(){

            /*this.showNameError = true;
            this.showPhoneError = true;
            this.showWarning = true;*/

            let dataValid = true;

            // получи значения с полей
            let userName = document.querySelector("#name").value;
            let userPhone = document.querySelector("#phone").value;
            let whenToCall = document.querySelector("#when-to-call").value;
            let userHasSponsor = hasSponsor();

            // обработай значения
            if(userName == "")
            {
                dataValid = false;
                this.showNameError = true;
                document.querySelector("#name").classList.add("mark-error");
            }

            if(!isValidPhoneNumber(userPhone))
            {
                dataValid = false;
                this.showPhoneError = true;
                document.querySelector("#phone").classList.add("mark-error");
            }

            if(userHasSponsor == null)
            {
                dataValid = false;
                this.showSponsorError = true;
            }

            if(dataValid)
            {
                console.log("Данные в порядке. Можно отправлять.");
                this.call = false;
                this.calling = true;

                setUserNameToLS(userName);
                setUserPhoneToLS(userPhone);

                //registrationRequest(userName, userPhone, whenToCall, userHasSponsor);
                callbackRequest(userName, userPhone, whenToCall, userHasSponsor, thisPageName(), thisPageDescription());
            }
        }
    }
}

// проверка опций есть ли спонсор
function hasSponsor()
{
    let result = null;
    let optionYes = document.querySelectorAll(".sponsor")[0];
    let optionNo = document.querySelectorAll(".sponsor")[1];

    if(optionYes.checked)
    {
        result = optionYes.value;
    }
    if(optionNo.checked)
    {
        result = optionNo.value;
    }
    return result;
}

function removeErrorClassFrom(id)
{
    document.querySelector(id).classList.remove("mark-error");
}