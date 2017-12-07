<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$aMenuLinks = Array(
    Array(
        "Новинки",
        "about/howto/",
        Array(),
        Array("image" => StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/new.svg"),
        ""
    ),
    Array(
        "Бренды",
        "about/delivery/",
        Array(),
        Array("image" => StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/brands.svg"),
        ""
    ),
    Array(
        "Одежда",
        "about/contacts/",
        Array(),
        Array("section_id"=>StockMan\Config::INDEX_CATALOG_SECTION_ID_1, "image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/clothes.svg"),
        ""
    ),
    Array(
        "Обувь",
        "personal/",
        Array(),
        Array("section_id"=>StockMan\Config::INDEX_CATALOG_SECTION_ID_2, "image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/shoes.svg"),
        ""
    ),
    Array(
        "Сумки",
        "catalog/",
        Array(),
        Array("image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/bags.svg")
    ),
    Array(
        "Аксессуары",
        "catalog/",
        Array(),
        Array("image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/accessories.svg")
    ),
    Array(
        "Белье",
        "catalog/",
        Array(),
        Array("image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/underwear.svg")
    ),
    Array(
        "SALE",
        "catalog/",
        Array(),
        Array("image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/sale.svg")
    ),
    Array(
        "Блог",
        "catalog/",
        Array(),
        Array("image" =>  StockMan\Config::STOCKMAN_TEMPLATE_PATH."/images/blog.svg")
    )
);
?>