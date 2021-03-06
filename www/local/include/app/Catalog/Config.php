<?php

namespace StockMan\Catalog;

use StockMan\Exception\Exception;

class Config
{
    const ELEMENT_SORT_FIELD = "CATALOG_AVAILABLE";
    const ELEMENT_SORT_ORDER = "desc";

    const ELEMENT_SORT_FIELD2 = \StockMan\Config::SORT_CATALOG_PRICE_ID;
    const ELEMENT_SORT_ORDER2 = "desc";

    const MORE_PHOTO = "MORE_PHOTO";
    const CML2_ARTICLE = "CML2_ARTICLE";
    const DETAILS = "DETAILS";
    const DELEVIRY_PAYS_BACKS = "DELEVIRY_PAYS_BACKS";
    const STILIST_COMMENTS = "STILIST_COMMENTS";

    //Свойства каталога
    const STIL = "STIL";

    //Торговые предложения
    const RAZMER = "RAZMER";
    const ROSSIYSKIY_RAZMER = "ROSSIYSKIY_RAZMER";
    const DISCOUNT = "DISCOUNT";
    const PROP_DISCOUNT = "PROP_DISCOUNT";
    const VALUE_DISCOUNT = "VALUE_DISCOUNT";
}
