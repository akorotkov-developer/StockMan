<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$dom = new DOMDocument;
$dom->loadHTML($arResult["BANNER"]);
foreach ($dom->getElementsByTagName('a') as $node) {
    $arResult["LINK_BANNER"] = $node->getAttribute( 'href' );
}
foreach ($dom->getElementsByTagName('img') as $node) {
    $arResult["IMG_BANNER"] = $node->getAttribute( 'src' );
}



