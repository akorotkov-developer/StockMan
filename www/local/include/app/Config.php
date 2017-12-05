<?php

namespace StockMan;


class Config
{
  const STOCKMAN_TEMPLATE_PATH = '/local/templates/podiummarket';

  /*
   * Инфоблоки
   * */
    const NEWS_IBLOCK_TYPE = "news";
    const NEWS_IBLOCK_ID = 1;

    //ИБ - баннеры
    const BANNERS_IBLOCK_TYPE = "banners";
    //ИБ - слайдер баннеров на главной
    const BANNERS_IBLOCK_ID_SLIDER = 8;
    //ИБ - Единичный баннер на главной
    const BANNERS_IBLOCK_ID_SINGLE = 9;

    //HB - highloadblock Бренды
    const HB_ID_BRANDS = 7;

    // ID значения "Физическое лицо" свойства UF_PAYER_TYPE "Тип плательщика" - для регистрации
    const UF_PAYER_TYPE_ID = 1;

    /**
     * Каталог
     */
    const CATALOG_IBLOCK_TYPE = "catalog";
    const CATALOG_IBLOCK_ID = CATALOG_IB_ID;
    const CATALOG_OFFERS_IBLOCK_ID = CATALOG_OFFERS_IB_ID;
    // ID цены на сайте
    const CATALOG_PRICE_ID = 77;
    // Для сортировки по цене
    const SORT_CATALOG_PRICE_ID = "CATALOG_PRICE_".self::CATALOG_PRICE_ID;
    // Код базовой цены
    const PRICE_BASE = "1 Дилерская Времекс";
    // Цены
    public static $arPrices = array(
        self::PRICE_BASE
    );

    const CODE_PROP_SEX = "POL";
    const CODE_PROP_MEKHANIZM = "TIP_MEKHANIZMA";
    const CODE_PROP_BREND = "BREND";
    const CODE_PROP_STIL = "STIL";
    const CODE_PROP_STRANA = "STRANA_PROIZVODITEL_MEKHANIZMA";

    const CODE_PROP_ACTION = "AKTSIYA";
    const CODE_PROP_ACTION_VALUE = "1";

    const CODE_PROP_ARTICLE = "CML2_ARTICLE";

    const CODE_PROP_NOVINKA = "NOVINKA";
    const CODE_PROP_REMEN_BRASLET = "REMEN_BRASLET";
    const CODE_PROP_DLINA = "DLINA";
    const CODE_PROP_TOLSHCHINA = "TOLSHCHINA";
    const CODE_PROP_DIAMETR = "DIAMETR";
    const CODE_PROP_MATERIAL_KORPUSA = "MATERIAL_KORPUSA";
    const CODE_PROP_STEKLO = "STEKLO";
    const CODE_PROP_VODOZASHCHITA = "VODOZASHCHITA";

    const CODE_PROP_COLORS_1 = "TSVET_POKRYTIYA";

    public static $arBasketProperties = array(
        "PROPERTY_".self::CODE_PROP_SEX,
        "PROPERTY_".self::CODE_PROP_MEKHANIZM,
        "PROPERTY_".self::CODE_PROP_BREND,
        "PROPERTY_".self::CODE_PROP_STIL,
        "PROPERTY_".self::CODE_PROP_STRANA,
    );

    /** Показать кнопки покупки Неавторизованному пользователю
     * False - не показывать
     * true - показывать
    */
    const SHOW_BASKET_BUTTON_UNAUTHORIZED = false;
    // Массив кодов свойст - для вывода в главном меню
    public static $BASE_MENU_ARRAY_PROP_CODE = array (
        self::CODE_PROP_SEX,
        self::CODE_PROP_MEKHANIZM,
        self::CODE_PROP_BREND,
        self::CODE_PROP_STIL,
    );
    // ID раздела каталога на главной №1
    const INDEX_CATALOG_SECTION_ID_1 = 1421;
    // ID раздела каталога на главной №2
    const INDEX_CATALOG_SECTION_ID_2 = 0;

    /**
     * Адреса страниц
     */
    // Раздел  каталога
    const CATALOG_URL = "/catalog/";
    // Страница авторизации
    const AUTH_URL = "/login/?login=yes";
    // Страница персонального раздела
    const PERSONAL_URL = "/personal/";
    // Данные о доставке
    const DELIVERY_URL = "/personal/delivery/";
    // Страница профиля
    const PROFILE_URL = "/personal/profile/";
    // путь к странице Любимые товары
    const FAV_URL = "/personal/favorite/";
    // путь к странице с корзиной
    const BASKET_URL = "/personal/cart/";
    // Страница - Заказы
    const ORDER_URL = "/personal/order/";
    // Страница оформления заказа
    const ORDER_MAKE_URL = "/personal/order/make/";
    // Страница подключения платежной системы
    const PAYMENT_URL = "/personal/order/payment/";
    // Страница регистрации
    const REGISTER_URL = "/login/?register=yes";

    /**
     * Дополнительное
     */
    // ID формы "Запрос цены"
    const ID_FORM_GET_PRICE = 1;
    // ID формы "Обратная связь"
    const ID_FORM_FEEDBACK = 2;

    // Бесплатная доставка от 20000 рублей - для заказа
    const PRICE_FREE_DELIVERY = 20000;
    // Бесплатная доставка от 7000 рублей - для товара
    const PRICE_PRODUCT_FREE_DELIVERY = 7000;


    const ELEMENT_NO_PHOTO_130 = self::STOCKMAN_TEMPLATE_PATH."/images/no_photo/element_130.jpg";
    const ELEMENT_NO_PHOTO_215 = self::STOCKMAN_TEMPLATE_PATH."/images/no_photo/element_215.jpg";
    const ELEMENT_NO_PHOTO_270 = self::STOCKMAN_TEMPLATE_PATH."/images/no_photo/element_270.jpg";
    const ELEMENT_NO_PHOTO_300 = self::STOCKMAN_TEMPLATE_PATH."/images/no_photo/element_300.jpg";

    const SECTION_NO_PHOTO_215 = self::STOCKMAN_TEMPLATE_PATH."/images/no_photo/section_215.jpg";


    /**
     * PDF
     */
    const PDF_HEADER_SHOW = true;
    const PDF_HEADER_LOGO = self::STOCKMAN_TEMPLATE_PATH."/images/pdf/pdf-header.png";

    const PDF_TITLE = "Угличский Часовой Завод — Прайс"; // dafult = Угличский Часовой Завод — Прайс

    const PDF_COUNT_ELEMENT = 50; // dafult = 50
}