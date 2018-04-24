<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
if($arParams[ADD_JQUERY] == "Y" && $arParams[SHOW_TYPE] == "WEBSITE"){
	$APPLICATION->AddHeadScript('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
}
if($arParams[ADD_PLUGIN] == "Y" && $arParams[SHOW_TYPE] == "WEBSITE"){
	switch($arParams[PLUGIN_TYPE]){
		case "FANCYBOX3":
			$APPLICATION->SetAdditionalCSS("https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css");
			$APPLICATION->AddHeadScript('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js');
			break;
		case "MAGNIFICPOPUP":
			$APPLICATION->SetAdditionalCSS("/bitrix/components/zaiv/instagramgallerylite/templates/.default/plugins/magnific-popup.css");
			$APPLICATION->AddHeadScript('/bitrix/components/zaiv/instagramgallerylite/templates/.default/plugins/jquery.magnific-popup.min.js');
			break;
	}
}