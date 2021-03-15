'use strict';

let bannerClosed = JSON.parse(sessionStorage.getItem('bannerClosed'));

if (bannerClosed) {
  $('#banner-skidka').hide();
}

function closeBanner() {
  sessionStorage.setItem('bannerClosed', true);
  $('#banner-skidka').slideUp();
}