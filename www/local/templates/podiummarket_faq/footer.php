<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
            </div>
        </div>
    </div>
    <?  $APPLICATION->IncludeComponent(
        "bitrix:form.result.new",
        "faq",
        Array(
            "SEF_MODE" => "Y",
            "WEB_FORM_ID" => StockMan\Config::FORM_FAQ_ID,
            "AJAX_MODE" => "Y",
            "AJAX_OPTION_SHADOW" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "LIST_URL" => "",
            "EDIT_URL" => "",
            "SUCCESS_URL" => "",
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "IGNORE_CUSTOM_TEMPLATE" => "Y",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "SEF_FOLDER" => $APPLICATION->GetCurPage(),
            "VARIABLE_ALIASES" => Array()
        )
    );?>
</div>
<?require($_SERVER['DOCUMENT_ROOT'] . StockMan\Config::STOCKMAN_TEMPLATE_PATH . '/footer.php');?>