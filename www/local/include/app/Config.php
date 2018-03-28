<?php

namespace StockMan;


class Config
{
    const STOCKMAN_TEMPLATE_PATH = '/local/templates/podiummarket';

    //Site ID
    const FORM_FAQ_ID = 1;

    //Site ID
    const SITE_ID = "s1";

    //ID Каталога
    const CATALOG_ID = 10;
    const HIGHLOAD_COUNTRY_ID = 98;
    const HIGHLOAD_SEZON_ID = 76;
    const CATALOG_OFFERS = 11;
    const CATALOG_HOME_SECTION_ID = 23;
    const CATALOG_TYPE = "1c_catalog";

    //ID разделов для слайдера баннеров
    const WOMEN_ID = 219;
    const MEN_ID = 218;
    const KIDS_ID = 220;

    //ID подписок
    const SUB_MEN = 9;
    const SUB_WOMEN = 6;
    const SUB_KIDS = 3;

    const CATALOG_PRICE = "Розничная ПМ";

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

    //Новинка (Да\Нет)
    const PROP_NOVINKA_VAL = 26;
    const PROP_NOVINKA = 'NOVINKA';
    //Новинка (Дата)
    const PROP_NOVINKA_DATE = 'NOVINKA_DATE';
    //уже был Новинкой (Да\Нет)
    const PROP_WAS_NOVINKA_VAL = 27;
    const PROP_WAS_NOVINKA = 'WAS_NOVINKA';
    //какой период считать новинкой
    const PROP_PERIOD_NOVINKA = '-2 week';

    public function getFilterNovinka($strData){
        return array(
            "!PROPERTY_" . self::PROP_NOVINKA => false
        );
    }
}