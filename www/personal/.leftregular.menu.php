<?
$current =array();
if ($_GET["CANCEL"] == "Y") {
	$current = array("Отмененные заказы","/?CANCEL=Y",array("SELECT_Y"=>"Y",),array(),"");
}
$aMenuLinks = Array(
    $current,
	Array(
        "Текущие заказы",
		"/personal/orders/",
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Внутренний счет",
		"/personal/account/",
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Личные данные",
		"/personal/private/",
		Array(), 
		Array(), 
		"" 
	),
    Array(
        "Завершенные заказы",
        "/personal/orders/?filter_history=Y",
        Array(),
        Array(),
        ""
    ),
    Array(
        "Профили заказов",
        "/personal/profiles/",
        Array(),
        Array(),
        ""
    ),
	Array(
		"Корзина",
		"/personal/cart/",
		Array(), 
		Array(), 
		"" 
	),
    Array(
        "Подписки",
        "/personal/subscribe/",
        Array(),
        Array(),
        ""
    )
);
?>
