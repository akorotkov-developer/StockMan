<?php
/**
 * Created by PhpStorm.
 * User: A.Korotkov
 * Date: 20.12.2017
 * Time: 10:23
 */

namespace StockMan\Catalog;

class Workcatalog
{
    //Получить имя раздела по его коду
    public function GetSectionNameByCode($sectionCode){
        $rsSections = \CIBlockSection::GetList(array(),array('IBLOCK_ID' => \StockMan\Config::CATALOG_ID, '=CODE' => $sectionCode));
        if ($arSection = $rsSections->Fetch())
        {
            return $arSection['NAME'];
        }
    }

    //Получить кол-во эдлементов раздела по символьному коду
    public function GetElmentCountByCode($sectionCode) {
        $res = \CIBlockSection::GetList(array(), array('IBLOCK_ID' => \StockMan\Config::CATALOG_ID, 'CODE' => $sectionCode, 'SITE_ID' => \StockMan\Config::SITE_ID));
        $section = $res->Fetch();
        $activeElements = \CIBlockSection::GetSectionElementsCount($section["ID"], Array("CNT_ACTIVE" => "Y"));
        return $activeElements;
    }

    public function GetElmentCountByName($sectionName) {
        $res = \CIBlockSection::GetList(array(), array('IBLOCK_ID' => \StockMan\Config::CATALOG_ID, '=NAME' => $sectionName, 'SITE_ID' => \StockMan\Config::SITE_ID));
        $section = $res->Fetch();
        $activeElements = \CIBlockSection::GetSectionElementsCount($section["ID"], Array("CNT_ACTIVE" => "Y"));
        return $activeElements;
    }
}


