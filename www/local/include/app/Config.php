<?php

namespace StockMan;


class Config
{
    const STOCKMAN_TEMPLATE_PATH = '/local/templates/podiummarket';

    //Site ID
    const FORM_FAQ_ID = 1;

    //Site ID
    const SITE_ID = "s1";

    //Слайдер
    const SLIDER_ID = 8;
    const SLIDER_TYPE = "news";

    //ID Каталога
    const CATALOG_ID = 10;
    const CATALOG_TYPE = "1c_catalog";

    const CATALOG_PRICE = "Розничная";

    /*----------Меню--------*/
    const INDEX_CATALOG_SECTION_ID_1 = 0;
    const INDEX_CATALOG_SECTION_ID_2 = 1;
    /*----------------------*/

    //Свойства каталога
    const NEW_PRODUCT = "NEWPRODUCT";
    const BREND = "BRAND_REF";

    //ID High-load блока с брендами
    const BRAND_REF_BLOCK_ID = 2;

    public static $arCatalogProperties = array(
        self::BREND,
        self::NEW_PRODUCT,
    );

    public static $monthsRus = array(
        "1" => "января",
        "2" => "февраля",
        "3" => "марта",
        "4" => "апреля",
        "5" => "мая",
        "6" => "июня",
        "7" => "июля",
        "8" => "августа",
        "9" => "сентября",
        "10" => "октября",
        "11" => "ноября",
        "12" => "декабря",
    );
}