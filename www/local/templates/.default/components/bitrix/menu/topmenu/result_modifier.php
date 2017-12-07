<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$i = 0;
foreach ($arResult as $key => $arItem) {
    if ($arItem["PARAMS"]["section_id"] !== NULL) {
        $sections = array();
        // выборка только активных разделов из инфоблока $IBLOCK_ID, в которых есть элементы
        $arFilter = Array('IBLOCK_ID'=>StockMan\Config::CATALOG_ID, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$arItem["PARAMS"]["section_id"]);
        $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
        $k = 0;
        while($ar_result = $db_list->GetNext())
        {
            $sections[$k]["ID"] = $ar_result['ID'];
            $sections[$k]["NAME"] = $ar_result['NAME'];
            $sections[$k]['SECTION_PAGE_URL'] = $ar_result['SECTION_PAGE_URL'];
            $k++;
        }
        $arResult[$i]["MODAL"] = $sections;
    }
    $i++;
}
?>