<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$APPLICATION->IncludeComponent(
	"bitrix:eshop.socnet.links", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"FACEBOOK" => "https://www.facebook.com/podiummarket",
		"VKONTAKTE" => "https://vk.com/podiummarket1",
		"TWITTER" => "",
		"GOOGLE" => "",
		"INSTAGRAM" => "https://www.instagram.com/podiummarket/"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>