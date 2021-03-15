'use strict';

console.log('get-from-LS.js : зашёл.');

function getIpFromLS() {
  return JSON.parse(localStorage.getItem("ip"));
}

function setIpToLS(ip) {
  localStorage.setItem("ip", JSON.stringify(ip));
}

function getIpAddressFromLS() {
  return JSON.parse(localStorage.getItem("ipAddress"));
}

function setIpAddressToLS(ipAddress) {
  localStorage.setItem("ipAddress", JSON.stringify(ipAddress));
}

function getUserFromLS() {
  return JSON.parse(localStorage.getItem("user"));
}

function getProductsFromLS() {
  return JSON.parse(localStorage.getItem("products"));
}

function getProductsCount() {
  return JSON.parse(localStorage.getItem("products")).length;
}

function getCartFromLS() {
  return JSON.parse(localStorage.getItem("cart"));
}

function getCartCountFromLS() {
  return JSON.parse(localStorage.getItem("cartCount"));
}

function getCartPVFromLS() {
  return JSON.parse(localStorage.getItem("cartPV"));
}

function getCartSumFromLS() {
  return JSON.parse(localStorage.getItem("cartSum"));
}

function getCartSumNZMFromLS() {
  return JSON.parse(localStorage.getItem("cartSumNZM"));
}

function getFreeDeliveryFromLS() {
  let hasFreeDelivery = JSON.parse(localStorage.getItem("hasFreeDelivery"));

  if (hasFreeDelivery == null) {
    hasFreeDelivery = false;
  }

  return hasFreeDelivery;
}

function getDeliveryNameFromLS() {
  let name = localStorage.getItem("deliveryName");

  if (name == null) {
    name = "";
  }

  return name;
}

function getDeliveryAddressFromLS() {
  let address = localStorage.getItem("deliveryAddress");

  if (address == null) {
    address = "";
  }

  return address;
}

function getDeliveryCostFromLS() {
  let cost = JSON.parse(localStorage.getItem("deliveryCost"));

  if (cost == null) {
    cost = 0;
  }

  return cost;
}

function getFinalDeliveryCostFromLS() {
  let finalDeliveryCost = JSON.parse(localStorage.getItem("finalDeliveryCost"));

  if (finalDeliveryCost == null) {
    finalDeliveryCost = 0;
  }

  return finalDeliveryCost;
}

function getTotalCostFromLS() {
  let totalCost = JSON.parse(localStorage.getItem("totalCost"));

  if (totalCost == null) {
    totalCost = 0;
  }

  return totalCost;
}

function setUserNameToLS(userName) {
  localStorage.setItem("userName", userName);
}

function getUserNameFromLS() {
  let name = localStorage.getItem("userName");

  if (name == null) {
    name = "";
  }

  return name;
}

function setUserPhoneToLS(userPhone) {
  localStorage.setItem("userPhone", userPhone);
}

function getUserPhoneFromLS() {
  let phone = localStorage.getItem("userPhone");

  if (phone == null) {
    phone = "";
  }

  return phone;
}

function setRecipientCheckToLS(recipientCheck) {
  localStorage.setItem("recipientCheck", recipientCheck);
}

function getRecipientCheckFromLS() {
  let recipientCheck = JSON.parse(localStorage.getItem("recipientCheck"));

  if (recipientCheck == null) {
    recipientCheck = false;
  }

  return recipientCheck;
}

function setRecipientContactsToLS(recipientContacts) {
  localStorage.setItem("recipientContacts", recipientContacts);
}

function getRecipientContactsFromLS() {
  let recipientContacts = localStorage.getItem("recipientContacts");

  if (recipientContacts == null) {
    recipientContacts = "";
  }

  return recipientContacts;
}