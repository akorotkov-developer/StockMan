<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

CModule::IncludeModule('search');
$arFilterSearch = array(
    "SITE_ID" => 's1',
    "TAGS" => false,
    "CHECK_DATES" => "Y",
    "QUERY" => $arResult['DISPLAY_PROPERTIES'][StockMan\Catalog\Config::STIL]["DISPLAY_VALUE"]
);
$exFILTERSearch = array(
    array(
        "=MODULE_ID" => "iblock",
        "PARAM1" => $arParams["IBLOCK_TYPE"],
        "PARAM2" => array(
            $arParams["IBLOCK_ID"]
        )
    )
);
$module_id = "iblock";

$param1=$arParams["IBLOCK_TYPE"];

$param2=$arParams["IBLOCK_ID"];
$obSearch = new CSearch();
$obSearch->Search($arFilterSearch, array(), $exFILTERSearch);

$arIdProductsStil = array();
while($arResultSearch = $obSearch->GetNext())
{
    $arIdProductsStil[] = $arResultSearch["ITEM_ID"];
}

$arIdProductsStil = array_diff($arIdProductsStil, array($arResult["ID"]));
$arProductsStil = array();
if (count($arIdProductsStil) >0 ) {
    $arFilter = Array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE"=>"Y",
        "CATALOG_AVAILABLE"=>"Y",
        "ID" => $arIdProductsStil
    );
    $res = CIBlockElement::GetList(
        Array(
            "SORT"=>"ASC", "PROPERTY_PRIORITY"=>"ASC"
        ),
        $arFilter,
        false,
        false,
        array(
            "ID",
            "NAME",
            "DETAIL_PAGE_URL",
            "DETAIL_PICTURE"
        )
    );
    while($ar_fields = $res->GetNext()) {
        $arProductsStilTemp = array();
        $arProductsStilTemp["NAME"] = $ar_fields["NAME"];
        $arProductsStilTemp["DETAIL_PAGE_URL"] = $ar_fields["DETAIL_PAGE_URL"];
        $arProductsStilTemp["TSVET"] = getTsvetProduct($ar_fields["ID"]);
        if (intval($ar_fields["DETAIL_PICTURE"]) > 0) {
            $arPic = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
            $arPicRes = CFile::ResizeImageGet(
                $arPic,
                array("width" => 50, "height" => 50),
                BX_RESIZE_IMAGE_PROPORTIONAL ,
                true,
                false,
                false,
                75
            );
            $arProductsStilTemp["PIC"] = $arPicRes["src"];
        }
        $arProductsStil[] = $arProductsStilTemp;
    }
}
$arResult["PRODUCTS_LIST_STILE"] = $arProductsStil;

$cp = $this->__component; // объект компонента

if (is_object($cp)) {
    $cp->SetResultCacheKeys(array(
        "PRODUCTS_LIST_STILE"
    ));
}