<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>
<div class="content">
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h1 class="text-center"><?$APPLICATION->ShowTitle();?></h1>