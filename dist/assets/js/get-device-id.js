'use strict';

console.log('get-device-id.js : зашёл.');

function getDeviceIdFromLS() {
  let deviceId = localStorage.getItem("deviceId");

  if (deviceId === null) {
    deviceId = generateDeviceId();
    localStorage.setItem("deviceId", deviceId);
  }

  return deviceId;
}

function generateDeviceId() {
  const site = window.location.hostname;
  const now = new Date();
  const year = now.getFullYear();
  const month = now.getMonth();
  const date = now.getDate();
  const hours = now.getHours();
  const minutes = now.getMinutes();
  const seconds = now.getSeconds();
  const alphabet = "abcdefghijklmnopqrstuvwxyz";
  const letter = alphabet[Math.floor(Math.random() * alphabet.length)];
  const separator = "|";
  const deviceId = site + separator + year + "." + month + "." + date + separator + hours + ':' + minutes + ':' + seconds + separator + letter;
  return deviceId;
}