<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
$APPLICATION->SetTitle("Выгрузка каталога XML");
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

CJSCore::Init(array("fx",'ajax', 'window', 'jquery'));

$_SESSION["BX_CML2_IMPORT"]["NS"]["STEP"]=0;

$urlFile = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME;
$urlFileOffers = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME_OFFERS;

$urlFileData = ImportStokMan::$FILE_IMPORT_N;
$urlFileOffersData = ImportStokMan::$FILE_OFFERS_N;

if((file_exists($urlFile))and(file_exists($urlFileOffers))) {
    $last_updateFile = filemtime($_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME);
    $last_updateFileOffers = filemtime($_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME_OFFERS);

    $mLastUpdate = max($last_updateFileOffers, $last_updateFile);

    $mLastUpdateXml = COption::GetOptionString("sale", "last_update_catalog_xml");
    ?>
    <p>Дата последнего обновление файлов выгрузки: <b><?=date('Y-m-d H:i:s', $mLastUpdate)?></b></p>
    <?if ($mLastUpdateXml > 0) {?>
        <p>Дата последней выгрузки товаров: <b><?=date('Y-m-d H:i:s', $mLastUpdateXml)?></b></p>
    <?}?>
    <form method="POST" action="<? echo $APPLICATION->GetCurPage() ?>" ENCTYPE="multipart/form-data" name="post_form">
        <? echo bitrix_sessid_post(); ?>
        <input type="hidden" name="lang" value="<?= LANG ?>">
        <div>
            <?
            if (!empty($_REQUEST['load_xml'])) {
                ini_set('max_execution_time', 0);
                ImportStokMan::processing();

                CAdminMessage::ShowMessage(["MESSAGE" => "Файлы выгрузки обработаны, производится выгрузка товаров!", "TYPE" => "OK"]);
                ?><script>
                    var //переменные таймера
                        m_second = 0,
                        seconds = 0,
                        minute = 0,
                        proccess = true;

                    function start_timer() {
                        if (m_second == 60) {
                            m_second = 0;
                            minute += 1;
                        }
                        if (proccess == true) {
                            seconds += 1;
                            m_second += 1;

                            setTimeout("start_timer()", 1000);
                        }
                    }

                    (function ($) {
                        "use strict";

                        $(function () {
                            var $log = $('.xml-log'),
                                $timer = $('.xml-timer'),
                                $load = $('.xml-load'),
                                $main = $('.xml-main'),
                                //переменные импорта
                                i = 1,
                                a = '',
                                status = "continue";

                            function createHttpRequest() {
                                var httpRequest;
                                if (window.XMLHttpRequest)
                                    httpRequest = new XMLHttpRequest();
                                else if (window.ActiveXObject) {
                                    try {
                                        httpRequest = new ActiveXObject('Msxml2.XMLHTTP');
                                    } catch (e) {
                                    }
                                    try {
                                        httpRequest = new ActiveXObject('Microsoft.XMLHTTP');
                                    } catch (e) {
                                    }
                                }
                                return httpRequest;
                            }
                            function start(file) {
                                $main.show();
                                $load.html("<b>Загрузка</b>...");
                                i = 1;
                                a = "";
                                m_second = 0;
                                seconds = 0;
                                proccess = true;
                                start_timer();
                                $timer.html("");

                                $log.html("<b>Импорт " + file + "</b><hr>");
                                query_1c(file);
                            }
                            function start1(file) {
                                $main.show();
                                $load.html("<b>Загрузка</b>...");
                                i = 1;
                                a = "";
                                m_second = 0;
                                seconds = 0;
                                proccess = true;
                                start_timer();
                                $timer.html("");

                                $log.html("<b>Импорт " + file + "</b><hr>");
                                query_1c(file);
                            }

                            function query_1c(file) {
                                var $import_1c = createHttpRequest(),
                                    r = "/bitrix/admin/1c_exchange.php?type=catalog&mode=import&filename=" + file;

                                $load.show();

                                $import_1c.open("GET", r, true);
                                $import_1c.onreadystatechange = function () {
                                    a = $log.html();
                                    if ($import_1c.readyState == 4 && $import_1c.status == 0) {
                                        var error_text = "<em>Ошибка в процессе выгрузки</em><div style='width:270px;font-size:11px;border:1px solid black;background-color:#ADC3D5;padding:5px'>Сервер упал и не вернул заголовков.</div>";
                                        $log.html(a + "Шаг " + i + ": " + error_text);
                                        $load.hide();

                                        status = "continue";
                                        alert("Import is crashed!");
                                    }

                                    if ($import_1c.readyState == 4 && $import_1c.status == 200) {
                                        if (($import_1c.responseText.substr(0, 8) != "progress") && ($import_1c.responseText.substr(0, 7) != "success")) {
                                            var error_text = "<em>Ошибка в процессе выгрузки</em><div style='width:270px;font-size:11px;border:1px solid black;background-color:#ADC3D5;padding:5px'>" + $import_1c.responseText + "</div>";
                                            $log.html(a + "Шаг " + i + ": " + error_text);
                                            status = "error";
                                        }
                                        else {
                                            var n = $import_1c.responseText.lastIndexOf('s') + 1,
                                                l = $import_1c.responseText.length,
                                                mess = $import_1c.responseText.substr(n, l);

                                            $log.html(a + "Шаг " + i + ": " + mess + " (" + seconds + " сек.)" + "<br>");

                                            seconds = 0;
                                            $load.hide();
                                            i++;
                                        }
                                        if (($import_1c.responseText.substr(0, 7) == "success") || (status == "error") || (status == "stop")) {
                                            $load.hide();
                                            status = "continue";
                                            proccess = false;
                                            $timer.html("<hr>Время выгрузки: <b>" + minute + " мин. " + m_second + " сек.</b>");

                                            if (file != "<?=$urlFileOffersData?>") {
                                                startOffers();
                                            } else {
                                                setTimeLastUpdateCatalogXml();
                                            }

                                        }
                                        else {
                                            query_1c(file);
                                        }
                                    }
                                };
                                $import_1c.send(null);
                            }

                            function reset()
                            {
                                var rest=createHttpRequest(),
                                    q="<?=$APPLICATION->GetCurPage()?>";
                                rest.open("GET", q, true);
                                rest.onreadystatechange=function()
                                {
                                    //if (rest.readyState == 4 && rest.status == 200) alert("Шаг импорта обнулён!");
                                };
                                rest.send(null);
                            }

                            start("<?=$urlFileData?>");

                            function startOffers()
                            {
                                reset();
                                start("<?=$urlFileOffersData?>");
                            }

                            function setTimeLastUpdateCatalogXml() {
                                var path = '/local/modules/xmlload/admin/xmlload_last_update.php';
                                $.ajax({
                                    url: path,
                                    cache: false
                                });
                            }

                        });
                    })(jQuery);
                </script> <?
            }
            ?>


            <div class="xml-main" style="display: none"></div>
            <div class="xml-log"></div>
            <div class="xml-timer"></div>
            <div class="xml-load"></div>
        </div>
        <?if (empty($_REQUEST['load_xml'])) {?>
            <hr>
            <input type="submit" name="load_xml" value="Выгрузить товары" class="adm-btn-save"/>
        <?}?>
    </form>
    <? echo BeginNote(); ?>
        <p>Файл <?=ImportStokMan::$FILE_NAME?> обновлен: <b><?=date('Y-m-d H:i:s', $last_updateFile)?></b></p>
        <p>Файл <?=ImportStokMan::$FILE_NAME_OFFERS?> обновлен: <b><?=date('Y-m-d H:i:s', $last_updateFileOffers)?></b></p>
    <? echo EndNote(); ?>
<?} else {?>
    <? echo BeginNote(); ?>
        <?if (!file_exists($urlFile)) {
            ?><p>Файл <?=ImportStokMan::$FILE_NAME?> <b>не загружен</b></p><?
        }?>
        <?if (!file_exists($urlFileOffers)) {
            ?><p>Файл <?=ImportStokMan::$FILE_NAME_OFFERS?> <b>не загружен</b></p><?
        }?>
    <? echo EndNote(); ?>
<?}?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>
