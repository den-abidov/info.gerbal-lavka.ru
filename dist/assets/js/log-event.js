'use strict';

console.log("logEvent.js : зашёл.");

function logEvent(eventName) {
  let event = {
    site: settings.site_name,
    event: eventName,
    user_name: getUserNameFromLS(),
    user_phone: getUserPhoneFromLS(),
    device_id: getDeviceIdFromLS(),
    ip: getIpFromLS(),
    ip_address: getIpAddressFromLS()
  };
  console.log(event);
  fetch(settings.log_events_url, {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json, text-plain, */*",
      "X-Requested-With": "XMLHttpRequest"
    },
    method: 'post',
    credentials: "same-origin",
    body: JSON.stringify(event)
  }).then(response => response.text()).then(data => {
    console.log('logEvent.js : Success. Server reply : ', data);
  }).catch(error => {
    console.error('logEvent.js : Error : ', error);
  }).finally(function () {
    console.log("logEvent.js : finally");
  });
}