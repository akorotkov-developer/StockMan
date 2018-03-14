<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");?>

    <div class="text-center">
        <div class="fault">404</div>
        <div class="text-secondary">К сожалению, запрашиваемый Вами документ не найден.</div>
        <div class="margin-bottom-9">Вы перешли по несуществующей ссылке или страница была удалена.</div><a href="<?=SITE_DIR?>">На главную </a>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>