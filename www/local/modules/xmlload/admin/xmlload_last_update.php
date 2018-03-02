<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
COption::SetOptionString("sale", "last_update_catalog_xml", time());
?>