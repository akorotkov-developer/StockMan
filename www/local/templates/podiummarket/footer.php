<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<?if ($APPLICATION->GetCurPage() != "/") {?>
</div>
<?}?>

<?/*if ($APPLICATION->GetCurPage() != "/") {?>
            </div>
        </div>
    </div>
</div>
<?}*/?>

<div class="reveal" id="enter-popup" data-reveal data-deep-link="true">
    <div class="grid-x grid-padding-x">
        <div class="cell text-center">
            <h2 class="reveal__title">Войти</h2>
            <div>
                <div class="reveal__enter">Войти через</div><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x fa-inverse"> </i></a><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-vk fa-stack-1x fa-inverse"> </i></a><a class="fa-stack text-asphalt soc" href="#" title=""><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"> </i></a>
            </div>
        </div>
        <div class="cell">
            <form action="shop-user-account.html">
                <label>Ваш email
                    <input type="email">
                </label>
                <label>Пароль
                    <input type="password">
                </label>
                <p class="text-right"><a href="shop-user-recover.html" title="">Забыли пароль?</a></p>
                <div class="text-center"> </div>
                <div class="grid-x align-center">
                    <div class="cell large-7">
                        <button class="button expanded">Войти &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
                    </div>
                </div>
            </form>
            <p class="text-center"><a href="shop-user-registration.html" title="">Зарегистрироваться</a></p>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
</div>
<div class="reveal" id="reg-popup" data-reveal data-deep-link="true">
    <div class="grid-x grid-padding-x">
        <div class="cell text-center">
            <h2 class="reveal__title">Регистрация</h2>
        </div>
        <div class="cell">
            <form action="shop-user-account.html">
                <label>
                    <input type="text" placeholder="Имя">
                </label>
                <label>
                    <input type="text" placeholder="Фамилия">
                </label>
                <div class="check">
                    <input class="check__input" type="radio" name="gend" id="a11" checked>
                    <label class="check__label" for="a11">Женские      </label>
                </div>
                <div class="check">
                    <input class="check__input" type="radio" name="gend" id="a21">
                    <label class="check__label" for="a21">Мужские </label>
                </div>
                <div class="grid-x grid-padding-x">
                    <div class="cell medium-9">
                        <label>
                            <input type="tel" placeholder="Телефон">
                        </label>
                        <label>
                            <input type="text" placeholder="Дата рождения">
                        </label>
                        <label>
                            <input type="password" placeholder="Пароль*">
                        </label>
                        <p class="help-text">Пароль должен быть не менее 6 символов</p>
                    </div>
                    <div class="cell">
                        <div class="check">
                            <input class="check__input" type="checkbox" id="y1">
                            <label class="check__label" for="y1">Я ознакомлен и принимаю условия &nbsp;<a href="shop-regular.html" title="">Соглашения об использовании сайта</a>, в том числе в части обработки и использования моих персональных данных</label>
                        </div>
                    </div>
                </div>
                <div class="grid-x align-center">
                    <div class="cell large-7">
                        <button class="button expanded">Регистрация &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
                    </div>
                </div>
            </form>
            <p class="text-center"><a href="shop-index.html#enter-popup" title="">Войти</a></p>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
</div>
<div class="reveal" id="recover-popup" data-reveal data-deep-link="true">
    <div class="grid-x grid-padding-x">
        <div class="cell text-center">
            <h2 class="reveal__title">Забыли пароль</h2>
        </div>
        <div class="cell">
            <form action="shop-user-account.html">
                <div>Если вы забыли пароль, введите логин или E-Mail.</div>
                <input type="text" placeholder="">
                <p>
                    Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по E-Mail.</p>
                <div class="grid-x align-center">
                    <div class="cell large-7">
                        <button class="button expanded">Восстановить &nbsp;<i class="fa fa-envelope-o fa-lg"></i></button>
                    </div>
                </div>
            </form>
            <p class="text-center"><a href="#">Войти</a></p>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
</div>
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
            <div class="margin-bottom-5 show-for-small-only"></div>
            <div class="subscribe">Подписаться на рассылку</div>
            <?$APPLICATION->IncludeComponent("bitrix:subscribe.form","subscribe",Array(
                    "USE_PERSONALIZATION" => "Y",
                    "PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",
                    "SHOW_HIDDEN" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600"
                )
            );?>
            <a class="margin-right-4" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/visa-bordered.svg" alt=""></a><a class="margin-right-4" href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/mastercard-bordered.svg" alt=""></a><a href="#"><img src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/images/mir-bordered.svg" alt=""></a>
        </div>
    </div>
</footer>

<script src="<?=StockMan\Config::STOCKMAN_TEMPLATE_PATH?>/js/app.js" type="text/javascript"></script>

</body>
</html>