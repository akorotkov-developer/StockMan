<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?>

<?
$sections = array();



        $arFilter = Array('IBLOCK_ID'=>StockMan\Config::CATALOG_ID, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>1);
        $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);

        while($ar_result = $db_list->GetNext())
        {
            echo $ar_result['NAME'];
        }


?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>