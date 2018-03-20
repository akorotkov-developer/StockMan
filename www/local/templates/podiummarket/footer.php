<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>

<?
if (strpos($APPLICATION->GetCurPage(), "personal/order/make") > 0) {
?>
    </div>
<?}?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
        "REGISTER_URL" => "register.php",
        "FORGOT_PASSWORD_URL" => "",
        "PROFILE_URL" => "profile.php",
        "SHOW_ERRORS" => "Y",
        "STORE_PASSWORD" => "N"
    )
);?>

    <div class="reveal" id="reg-popup" data-reveal data-deep-link="true">
        <?$APPLICATION->IncludeComponent("bitrix:main.register","",Array(
                "USER_PROPERTY_NAME" => "",
                "SEF_MODE" => "Y",
                "SHOW_FIELDS" => Array("NAME", "LAST_NAME", "SECOND_NAME", "PERSONAL_GENDER", "PERSONAL_BIRTHDAY", "PERSONAL_PHONE", "UF_SUBSCRIBE"),
                "REQUIRED_FIELDS" => Array("NAME","PERSONAL_PHONE"),
                "AUTH" => "Y",
                "USE_BACKURL" => "Y",
                "SUCCESS_PAGE" => "",
                "SET_TITLE" => "N",
                "USER_PROPERTY" => Array(),
                "SEF_FOLDER" => "/",
                "VARIABLE_ALIASES" => Array(),
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_MODE" => "Y",
            )
        );?>
    </div>

    <?/*<div class="reveal" id="recover-popup" data-reveal data-deep-link="true">
        <?$APPLICATION->IncludeComponent( "bitrix:system.auth.forgotpasswd",
            ".default",
            Array(
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_MODE" => "Y",
            )
        );?>
    </div>*/?>

    <footer class="footer">
        <div class="grid-x grid-padding-x text-center medium-text-left">
            <div class="large-2 cell large-offset-1 medium-4">
                <div class="footer__title" data-toggle="foot1 title1" data-toggler="js-show" id="title1">Коллекции<i class="fa fa-chevron-right show-for-small-only"></i></div>
                <ul class="bag" data-toggler="js-open" id="foot1">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottommenu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "Y",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => "",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "collection",
                            "USE_EXT" => "Y"
                        )
                    );?>
                </ul>
                <hr class="show-for-small-only">
            </div>
            <div class="large-2 cell medium-4">
                <div class="footer__title" data-toggle="foot2 title2" data-toggler="js-show" id="title2">Покупателю<i class="fa fa-chevron-right show-for-small-only"></i></div>
                <ul class="bag" data-toggler="js-open" id="foot2">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottommenu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "Y",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => "",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "buyer",
                            "USE_EXT" => "Y"
                        )
                    );?>
                </ul>
                <hr class="show-for-small-only">
            </div>
            <div class="large-2 cell medium-4">
                <div class="footer__title" data-toggle="foot3 title3" data-toggler="js-show" id="title3">Условия работы<i class="fa fa-chevron-right show-for-small-only"></i></div>
                <ul class="bag" data-toggler="js-open" id="foot3">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottommenu",
                        Array(
                            "ALLOW_MULTI_SELECT" => "Y",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => "",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "conditions",
                            "USE_EXT" => "Y"
                        )
                    );?>
                </ul>
                <hr class="show-for-small-only">
            </div>
            <div class="large-2 cell medium-4">
                <div class="footer__title" data-toggle="foot4 title4" data-toggler="js-show" id="title4">Связь с нами<i class="fa fa-chevron-right show-for-small-only"></i></div>
                <div class="footer__block" data-toggler="js-open" id="foot4">
                    <div class="text-size-small margin-bottom-4">
                        Тел.:
                        <a class="text-decoration-none" href="tel:88003331257">8 (800) 333-12-57</a>
                    </div>
                    <div class="text-size-small margin-bottom-11">
                        E-mail:
                        <a class="text-decoration-none" href="mailto:mail@brendsalon.ru">mail@brendsalon.ru</a>
                    </div><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x fa-inverse"> </i></a><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-vk fa-stack-1x fa-inverse"> </i></a><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"> </i></a>
                </div>
                <hr class="show-for-small-only">
            </div>
            <div class="small-12 medium-6 large-3 cell">
                <?$APPLICATION->IncludeComponent(
                    "asd:subscribe.quick.form",
                    "footersubscribe",
                    array(
                        "AJAX_MODE" => "N",
                        "SHOW_HIDDEN" => "Y",
                        "ALLOW_ANONYMOUS" => "Y",
                        "SHOW_AUTH_LINKS" => "Y",
                        "CACHE_TYPE" => "N",
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

                <a class="margin-right-4" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/visa-bordered.svg" alt=""></a><a class="margin-right-4" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/mastercard-bordered.svg" alt=""></a><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/mir-bordered.svg" alt=""></a>
            </div>
        </div>
    </footer>

    <script src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/js/app.js" type="text/javascript"></script>

    </body>
 </html>