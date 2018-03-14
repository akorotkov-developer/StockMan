<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?>

<?/*$APPLICATION->IncludeComponent("bitrix:subscribe.edit","",Array(
        "AJAX_MODE" => "N",
        "SHOW_HIDDEN" => "Y",
        "ALLOW_ANONYMOUS" => "Y",
        "SHOW_AUTH_LINKS" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "SET_TITLE" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N"
    )
);*/?>

<?$APPLICATION->IncludeComponent(
	"asd:subscribe.quick.form", 
	"catalog_element",
	array(
		"AJAX_MODE" => "N",
		"SHOW_HIDDEN" => "Y",
		"ALLOW_ANONYMOUS" => "Y",
		"SHOW_AUTH_LINKS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SET_TITLE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"RUBRICS" => array(
			0 => "1",
		),
		"SHOW_RUBRICS" => "N",
		"INC_JQUERY" => "N",
		"NOT_CONFIRM" => "N",
		"FORMAT" => "text"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>