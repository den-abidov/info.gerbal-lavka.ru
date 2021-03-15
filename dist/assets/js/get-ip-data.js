console.log("get-ip-data.js");
requestIpData();

function requestIpData() {
  console.log("requestIpData() : Нужно получить ip и его адрес.");

  if (needToUpdateIp() == true) {
    console.log("requestIpData() : Запрошу ip и его адрес с сервера...");
    requestIpDataFromServer();
    let now = new Date();
    localStorage.setItem("ipCallTime", JSON.stringify(now));
  } else {
    console.log("requestIpData(): использую имеющийся ip = " + getIpFromLS());
    console.log("requestIpData(): использую имеющийся ipAddress = " + getIpAddressFromLS());
  }
}

function requestIpDataFromServer() {
  fetch(settings.ip_data_url).then(response => response.json()).then(response => {
    let ip = response.ip;
    let ipAddress = response.ip_address;
    console.log("requestIpDataFromServer() : Получил ip и его адрес с сервера.");
    setIpToLS(ip);
    setIpAddressToLS(ipAddress);
    console.log("requestIpDataFromServer() : Сохранил ip и его адрес в LS.");
  });
}

function minutesFrom(past) {
  let now = new Date();
  let mins = (now - past) * 0.001 / 60;
  return mins;
}

function needToUpdateIp() {
  let canWaitMinutes = 30;
  let result = false;
  let ipLastCallTime = JSON.parse(localStorage.getItem("ipCallTime"));

  if (ipLastCallTime === null) {
    result = true;
  } else {
    let deltaMins = minutesFrom(ipLastCallTime);

    if (deltaMins > canWaitMinutes) {
      result = true;
    }
  }

  return result;
}