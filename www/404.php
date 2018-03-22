<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

    <div class="content">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center">
                    <h1 class="text-center"><?$APPLICATION->ShowTitle(true);?></h1>
                    <div class="fault">404</div>
                    <div class="text-secondary">К сожалению, запрашиваемый Вами документ не найден.</div>
                    <div class="margin-bottom-9">Вы перешли по несуществующей ссылке или страница была удалена.</div><a href="<?=SITE_DIR?>">На главную </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .top-menu-on-site:nth-child(2) {
            display: none;
        }
    </style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>