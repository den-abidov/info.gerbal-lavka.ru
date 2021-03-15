'use strict';

console.log('to-shop-page.js: зашёл.');
const correctCardNumber = settings.client_card_number;

function askCardModalProps() {
  return {
    cardNumber: '',
    error: false,

    checkCardNumber() {
      if (this.cardNumber === correctCardNumber) {
        this.error = false;
        window.location.href = settings.shop_url + '?user_phone=' + correctCardNumber;
      } else {
        this.error = true;
      }
    }

  };
}