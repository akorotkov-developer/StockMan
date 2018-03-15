<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/tools/CImportStokMan.php");

AddEventHandler("main", "OnAfterUserRegister", Array("UserRegister", "OnAfterUserRegisterHandler"));
class UserRegister
{
    function OnAfterUserRegisterHandler(&$arFields)
    {
        CModule::IncludeModule("subscribe");
        $arFieldsSubscribe = Array(
            "EMAIL" => $arFields["EMAIL"],
            "ACTIVE" => "Y",
            "RUB_ID" => 2
        );
        $subscr = new CSubscription;

        //can add without authorization
        $subscr->Add($arFieldsSubscribe);
    }
}

AddEventHandler("main", "OnBuildGlobalMenu", Array("StockManHandlers", "xmlLoad"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("StockManHandlers", "AfterElementAddHandler"));


// зарегистрируем функцию как обработчик двух событий
AddEventHandler('form', 'onBeforeResultAdd',array('StockManHandlers', 'onBeforeResultAddHandler'));

class StockManHandlers
{

    function onBeforeResultAddHandler($WEB_FORM_ID, &$arFields, &$arrVALUES)
    {
        if ($WEB_FORM_ID == StockMan\Config::FORM_FAQ_ID)
        {
            CModule::IncludeModule("iblock");
            $name = htmlspecialcharsbx($arrVALUES['form_text_1']);
            $email = htmlspecialcharsbx($arrVALUES['form_email_2']);
            $text = htmlspecialcharsbx($arrVALUES['form_textarea_3']);

            $el = new CIBlockElement;

            $PROP = array();
            $PROP[212] = $email;
            $PROP[213] = $name;

            $arLoadProductArray = Array(
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID"      => 12,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => $name . ' - ' . $email,
                "ACTIVE"         => "N",
                "PREVIEW_TEXT"   => $text
            );
            $PRODUCT_ID = $el->Add($arLoadProductArray);

            $arEventFields = array(
                "TEXT_USER"     => $text,
                "NAME_USER"     => $name,
                "EMAIL_USER"    => $email,
                "LINK"          => '/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=12&type=faq&ID=' . $PRODUCT_ID . '&lang=ru&find_section_section=-1&WF=Y',

            );
            CEvent::Send("FORM_FAQ", 's1', $arEventFields);
        }
    }

    function xmlLoad(&$adminMenu, &$moduleMenu)
    {
        global $USER;
        if (!$USER->IsAdmin())
            return;

        $moduleMenu[] = array(
            "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
            "section" => "xmlLoad",
            "sort" => 100,                     // сортировка пункта меню
            "url" => "",
            "text" => 'Выгрузка каталога',    // текст пункта меню
            "title" => 'Выгрузка каталога',    // текст всплывающей подсказки
            "icon" => "highloadblock_menu_icon",        // малая иконка
            "page_icon" => "form_page_icon",        // большая иконка
            "items_id" => "menu_online",           // идентификатор ветви
            "items" => array(
                array(
                    "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
                    "section" => "xmlLoad",
                    "sort" => 10,                     // сортировка пункта меню
                    "url" => "xmlload.php?lang=" . LANG, // ссылка на пункте меню
                    "text" => 'Выгрузка каталога XML',    // текст пункта меню
                    "title" => 'Выгрузка каталога XML',    // текст всплывающей подсказки
                    "icon" => "fileman_menu_icon",        // малая иконка
                    "page_icon" => "form_page_icon",        // большая иконка
                    "items_id" => "menu_online",           // идентификатор ветви
                    "items" => array()
                ),
                array(
                    "parent_menu" => "global_menu_content",   // поместим в раздел "Сервис"
                    "section" => "xmlLoadPic",
                    "sort" => 20,                     // сортировка пункта меню
                    "url" => "xmlloadpic.php?lang=" . LANG, // ссылка на пункте меню
                    "text" => 'Выгрузка Картинок',    // текст пункта меню
                    "title" => 'Выгрузка Картинок',    // текст всплывающей подсказки
                    "icon" => "fileman_menu_icon",        // малая иконка
                    "page_icon" => "form_page_icon",        // большая иконка
                    "items_id" => "menu_online",           // идентификатор ветви
                    "items" => array()
                )
            )
        );
    }

    function AfterElementAddHandler(&$arFields)
    {
        if ($_SERVER['PHP_SELF'] == '/bitrix/admin/1c_exchange.php') {
            $name = $arFields["NAME"];
            $nameCode = $name;
            $flag = false;
            if ($arFields['IBLOCK_ID'] == ImportStokMan::$IBLOCK_ID) {
                $IBLOCK_SECTION_ID = ImportStokMan::$IBLOCK_SECTION_ERROR_ID;
                $CODE_STIL = '';
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("XML_ID" => ImportStokMan::$XML_ID_STIL, "IBLOCK_ID"=>$arFields['IBLOCK_ID']));
                while ($prop_fields = $properties->GetNext())
                {
                    $CODE_STIL = $prop_fields["CODE"];
                }
                $CODE_TSVET = '';
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("XML_ID" => ImportStokMan::$XML_ID_TSVET, "IBLOCK_ID"=>$arFields['IBLOCK_ID']));
                while ($prop_fields = $properties->GetNext())
                {
                    $CODE_TSVET = $prop_fields["CODE"];
                }

                if ((isset($CODE_STIL{1}))and(isset($CODE_TSVET{1}))) {
                    $arPropertyStil = array();
                    $resStil = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => $CODE_STIL));
                    if ($obStil = $resStil->GetNext()) {
                        $arPropertyStil = $obStil;
                    }
                    $DVStil = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyStil);

                    $arPropertyTsvet = array();
                    $resTsvet = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields["ID"], "sort", "asc", array("CODE" => $CODE_TSVET));
                    if ($obTsvet = $resTsvet->GetNext()) {
                        $arPropertyTsvet = $obTsvet;
                    }

                    $DVTsvet = CIBlockFormatProperties::GetDisplayValue($arFields, $arPropertyTsvet);

                    if ((isset($DVStil['DISPLAY_VALUE']{1}))and(isset($DVTsvet['DISPLAY_VALUE']{1}))) {
                        $IBLOCK_SECTION_ID = ImportStokMan::$IBLOCK_SECTION_ID;
                        $name = $DVStil['DISPLAY_VALUE'] . ' ';
                        $nameCode = $DVStil['DISPLAY_VALUE'] . ' ' . $DVTsvet['DISPLAY_VALUE'];
                        $flag = true;
                    }
                }
                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                );

                if ($flag) {
                    $name = htmlspecialcharsBack($name);
                    $nameCode = htmlspecialcharsBack($nameCode);
                    $code = CUtil::translit($nameCode, "ru", ImportStokMan::$translateParams);

                    $arLoadProductArray = Array(
                        "NAME" => $name,
                        "CODE" => $code,
                        "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID
                    );
                }

                $el = new CIBlockElement;
                $el->Update($arFields["ID"], $arLoadProductArray);
            }
        }
    }
}
?>