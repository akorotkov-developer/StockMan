<?php

namespace StockMan;


class Config
{
    const STOCKMAN_TEMPLATE_PATH = '/local/templates/podiummarket';

    //Слайдер
    const SLIDER_ID = 8;
    const SLIDER_TYPE = "news";

    //ID Каталога
    const CATALOG_ID = 6;
    const CATALOG_TYPE = "catalog";

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
}