<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/header.php');
?>
<div class="content">
    <div class="grid-container">
        <div class="grid-x grid-padding-x text-center">
            <div class="cell margin-bottom-13">
                <h1><?$APPLICATION->ShowTitle();?></h1>
            </div>
        </div>
        <div class="text-center margin-bottom-10">