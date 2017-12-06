<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?/*
    <div class="grid-container position-relative">
        <div class="grid-x directory" id="responsive-menu" data-toggler="js-open">
            <div class="subheader" data-toggler="js-open" id="subheader1">
                <button class="subheader__back" data-toggle="subheader1"><i class="fa fa-chevron-left"></i>Назад</button>
                <ul class="trousers">
                    <li class="trousers__item"><a class="trousers__link" href="#">Вся одежда</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Водолазки</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Джинсы</a></li>
                </ul>
            </div>
            <div class="subheader" data-toggler="js-open" id="subheader2">
                <button class="subheader__back" data-toggle="subheader2"><i class="fa fa-chevron-left"></i>Назад</button>
                <ul class="trousers">
                    <li class="trousers__item"><a class="trousers__link" href="#">Вся одежда</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Шорты</a></li>
                    <li class="trousers__item"><a class="trousers__link" href="#">Джинсы</a></li>
                </ul>
            </div>
            <button class="close-button show-for-small-only" aria-label="Close alert" type="button"><span aria-hidden="true" data-toggle="responsive-menu">×</span></button>
            <div class="cell text-center medium-text-left">
                <ul class="people show-for-small-only">
                    <li class="people__item"><a class="people__link" href="#">Женщинам</a></li>
                    <li class="people__item"><a class="people__link people__link_active" href="#">Мужчинам</a></li>
                    <li class="people__item"><a class="people__link" href="#">Детям</a></li>
                </ul>
            </div>
            <div class="small-12 medium-9 large-9 cell" id="menu">
                <ul class="menu-base text-left medium-text-right">
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/new.svg" alt="">Новинки</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"> <img class="show-for-small-only" src="./images/brands.svg" alt="">Бренды</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" data-toggle-hover-dd="menu_item_2" data-toggle="subheader1"><img class="show-for-small-only" src="./images/clothes.svg" alt="">Одежда<i class="fa fa-chevron-right show-for-small-only"></i></a></li>
                    <li class="menu-base__item"><a class="menu-base__link" data-toggle-hover-dd="menu_item_2" data-toggle="subheader2"><img class="show-for-small-only" src="./images/shoes.svg" alt="">Обувь<i class="fa fa-chevron-right show-for-small-only"></i></a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/bags.svg" alt="">Сумки</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/accessories.svg" alt="">Аксессуары</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/underwear.svg" alt="">Белье</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/sale.svg" alt="">Sale</a></li>
                    <li class="menu-base__item"><a class="menu-base__link" href="shop-catalog.html"><img class="show-for-small-only" src="./images/blog.svg" alt="">Блог</a></li>
                </ul>
            </div>
            <div class="hide-for-small-only large-3 cell medium-3 text-center medium-text-left">
                <form class="search-top input-group" action="shop-search.html" method="get">
                    <input class="search-top__input input-group-field" type="text" value="" placeholder="Поиск">
                    <div class="input-group-button">
                        <button class="search-top__button fa fa-search" type="submit"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="dd hide-for-small-only" id="menu_item_2" data-toggler-hover-dd="dd_show">
        <div class="dd__content">
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="small-6 medium-5 large-6 cell">
                        <h5>По категориям</h5>
                        <div class="grid-x grid-padding-x">
                            <div class="small-6 cell">
                                <ul>
                                    <li><a href="#" title="">Платья</a></li>
                                    <li><a href="#" title="">Брюки</a></li>
                                    <li><a href="#" title="">Кофты</a></li>
                                    <li><a href="#" title="">Юбки</a></li>
                                    <li><a href="#" title="">Костюмы</a></li>
                                    <li><a href="#" title="">Деним</a></li>
                                </ul>
                            </div>
                            <div class="small-6 cell">
                                <ul>
                                    <li><a href="#" title="">Шорты</a></li>
                                    <li><a href="#" title="">Нижнее белье</a></li>
                                    <li><a href="#" title="">Пальто</a></li>
                                    <li><a href="#" title="">Трикотаж</a></li>
                                    <li><a href="#" title="">Комбинезоны</a></li>
                                    <li><a href="#" title="">Пляжная одежда</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="small-6 medium-4 large-3 cell">
                        <h5>По дизайнерам</h5>
                        <ul>
                            <li><a href="#" title="">BURBERRY</a></li>
                            <li><a href="#" title="">CHLOE</a></li>
                            <li><a href="#" title="">DOLCE &amp; GABBANA</a></li>
                            <li><a href="#" title="">DSQUARED2</a></li>
                            <li><a href="#" title="">ETRO</a></li>
                            <li><a href="#" title="">GIVENCHY</a></li>
                            <li><a href="#" title="">ISABEL MARANT</a></li>
                            <li><a href="#" title="">LANVIN</a></li>
                            <li><a href="#" title="">MARC JACOBS</a></li>
                            <li><a href="#" title="">MAX MARA</a></li>
                        </ul><a class="font-bold text-decoration-none" href="#">Все дизайнеры</a>
                    </div>
                    <div class="small-6 medium-3 large-3 cell text-center">
                        <div class="margin-bottom-9"><a href="#"><img src="./i/dress.png" alt=""></a></div>
                        <h3 class="margin-bottom-0">Платья</h3><a class="anchor" href="#">смотреть все    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
*/?>
<?if (!empty($arResult)):?>


        <?foreach($arResult as $arItem){?>


        <?}?>


<?endif?>