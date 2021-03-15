function thisPageName() {
  let path = window.location.pathname;
  let page = path.substring(path.lastIndexOf('/') + 1);
  let nameOnly = page.replace(".html", "");
  return nameOnly;
}

function thisPageDescription() {
  let pageName = thisPageName();
  let description = pageName;

  switch (pageName) {
    case "index":
      description = "/ страница";
      break;

    case "main":
      description = "главная страница";
      break;

    case "katalog":
      description = "каталог, цены 25% и 35%, карта клиента";
      break;

    case "skidki":
      description = "скидки 25% и 35%, до 42% и 50%, карта клиента";
      break;

    case "how-to-buy":
      description = "как купить";
      break;

    case "payment":
      description = "как оплатить";
      break;

    case "dostavka":
      description = "доставка";
      break;

    case "track-order":
      description = "отслеживание";
      break;

    case "garantii":
      description = "гарантии / защита покупателей";
      break;

    case "comments":
      description = "отзывы покупателей";
      break;

    case "contacts":
      description = "контакты";
      break;

    case "to-shop-page":
      description = "переход в магазин";
      break;

    case "Herbalife-why-register":
      description = "зачем регистрироваться в Гербалайф, преимущества";
      break;

    case "Herbalife-how-to-buy":
      description = "как покупать после регистрации, есть видео";
      break;

    case "register":
      description = "как зарегистрироваться, видео";
      break;

    case "Herbalife-skidki":
      description = "скидки в Гербалайф";
      break;

    case "buy-options-compared":
      description = "регистрироваться или купить через нас";
      break;

    case "results":
      description = "результаты клиентов";
      break;

    case "weightloss":
      description = "как Гербалайф помогает похудеть";
      break;

    case "Herbalife-breakfast":
      description = "завтрак Гербалайф";
      break;

    case "water":
      description = "питьевой режим";
      break;

    case "diet":
      description = "план питания";
      break;

    case "diary":
      description = "дневник питания";
      break;

    case "programs":
      description = "программы похудения";
      break;

    case "product-turbo-drink":
      description = "турбо-напиток";
      break;

    case "for-moms":
      description = "можно ли Гербалайф беременным или кормящим";
      break;

    case "product-aloe":
      description = "Алоэ";
      break;

    case "product-formula1":
      description = "коктейль Формула 1";
      break;

    case "product-formula1-night":
      description = "вечерний коктейль";
      break;

    case "product-formula2":
      description = "витамины Формула 2";
      break;

    case "product-formula3":
      description = "белок Формула 3";
      break;

    case "product-kpv":
      description = "КПВ";
      break;

    case "product-protein-coffee":
      description = "протеиновый кофе";
      break;

    case "product-tea":
      description = "чай";
      break;

    case "product-Termokomplit":
      description = "Термо Комплит";
      break;

    case "product-yellow-pills":
      description = "жёлтые таблетки";
      break;
  }

  return description;
}