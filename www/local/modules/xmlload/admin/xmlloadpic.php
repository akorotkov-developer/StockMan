<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
$APPLICATION->SetTitle("Выгрузка картинок");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
$context = new CAdminContextMenu($aMenu);
$context->Show();

define("NEED_AUTH", false);
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);

ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '400M');
ini_set('max_execution_time', '3000');
ini_set('max_input_time', '6000');

if(!CModule::IncludeModule("iblock")) die('IBlock module init error');
if(!CModule::IncludeModule("catalog")) die('Catalog module init error');
?>
    <form method="POST" action="<? echo $APPLICATION->GetCurPage() ?>" ENCTYPE="multipart/form-data" name="post_form">
        <? echo bitrix_sessid_post(); ?>
        <input type="hidden" name="lang" value="<?= LANG ?>">
        <div>
            <?
            if (!empty($_REQUEST['load_xml'])) {
                ini_set('max_execution_time', 0);
                ImportStokMan::processingPictures();

                CAdminMessage::ShowMessage(["MESSAGE" => "Картинки выгружены", "TYPE" => "OK"]);
            }
            ?>
        </div>
        <?if (empty($_REQUEST['load_xml'])) {?>
            <hr>
            <input type="submit" name="load_xml" value="Выгрузить картинки" class="adm-btn-save"/>
        <?}?>
    </form>
<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
