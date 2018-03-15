<?php

class ImportStokMan {
    /**
     *
     */
    public static $IBLOCK_ID = 10;
    public static $IBLOCK_OFFERS_ID = 11;
    public static $IBLOCK_SECTION_ID = 205;
    public static $IBLOCK_SECTION_ERROR_ID = 206;

    public static $arPictureID = array();
    public static $arPictureProducts = array();
    public static $PATH_PICT = '/upload/1c_catalog/import_files/';

    public static $FILE_NAME = '/upload/1c_catalog/import0_1.xml';
    public static $FILE_NAME_OFFERS = '/upload/1c_catalog/offers0_1.xml';

    public static $FILE_IMPORT_PIC_N = 'data_import_pic.xml';
    public static $FILE_IMPORT_PIC = '/upload/1c_catalog/data_import_pic.xml';

    public static $FILE_IMPORT_N = 'data_import.xml';
    public static $FILE_IMPORT = '/upload/1c_catalog/data_import.xml';
    public static $FILE_OFFERS_N = 'data_offers.xml';
    public static $FILE_OFFERS = '/upload/1c_catalog/data_offers.xml';

    public static $XML_ID_STIL = '9f4387df-5b34-11e7-80e0-00155d0f1c03';
    public static $XML_ID_TSVET = 'cf6449d9-5b32-11e7-80e0-00155d0f1c03';
    public static $XML_ID_RAZMER = 'ff296996-5b34-11e7-80e0-00155d0f1c03';

    public static $CODE_PROPERTYY_TSVET = 'TSVET';
    public static $NAME_PROPERTYY_TSVET = 'Цвет';

    public static $STR_DELIMITER_OFFERS = '-p';


    public static $arProductsXML = array(); // XML - всех Карточек
    public static $arProductsXMLCode = array(); // XML - всех Карточек
    public static $arOffersXMLReplace = array(); // Замена Xml на Торговое предложение

    public static $arNewOffersArticles = array(); // Артикулы новых предложений
    public static $arNewOffersName = array(); // Названия новых предложений
    public static $arNewOffersBaseEd = array(); // БазоваяЕдиница новых предложений

    public static $arOffersRazmer = array(); // Добавление свойства Размер
    public static $arOffersRazmerReplace = array(); // Добавление свойства Размер
    public static $arOffersBarCodeReplace = array(); // Штрихкод
    public static $strRazmer = ''; // Размер

    public static $codePropertyXML_ID = 'property-xml-id-1c-80e0-00155d0f1c03';
    public static $strPropertyXML_ID = '
                <Ид>property-xml-id-1c-80e0-00155d0f1c03</Ид>
				<Наименование>XML_ID из 1С</Наименование>
				<ТипЗначений>Строка</ТипЗначений>
			';
    public static $strPropertyXML_ID1 = '<Свойство><Ид>property-xml-id-1c-80e0-00155d0f1c03</Ид><Наименование>XML_ID из 1С</Наименование><ТипЗначений>Строка</ТипЗначений></Свойство>';

    public static $translateParams = array(
        "max_len" => "200",
        "change_case" => "L",
        "replace_space" => "-",
        "replace_other" => "-",
        "delete_repeat_replace" => "true",
        "use_google" => "false",
    );
    public static function processing() {
        self::processingFile();
        self::processingFileOffers(self::$arOffersRazmerReplace, self::$arOffersXMLReplace, self::$arOffersBarCodeReplace, self::$strRazmer);
        self::processingFileImport();
    }
    public static function processingFile() {
        $urlFile = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME;
        $xml = simplexml_load_file($urlFile);
        $arProductsXMLOffers = array();

        $propertyValueToRemove = array();
        $arValueRemove = array();
        foreach ($xml->Классификатор->Свойства->Свойство as $obPropety) {
            $idProp = (string)$obPropety->Ид;
            foreach ($obPropety->ВариантыЗначений->Справочник as $obPropetyV) {
                if (strpos((string)$obPropetyV->Значение, 'Объект') !== false) {
                    $arValueRemove[$idProp][] = (string)$obPropetyV->ИдЗначения;
                    $propertyValueToRemove[] = $obPropetyV;
                }
                if (strpos((string)$obPropetyV->Значение, '<>') !== false) {
                    $arValueRemove[$idProp][] = (string)$obPropetyV->ИдЗначения;
                    $propertyValueToRemove[] = $obPropetyV;
                }
            }
        }
        foreach ($propertyValueToRemove as $code) {
            unset($code[0]);
        }

        $strXML = $xml->asXML();
        $xml = new SimpleXMLElement($strXML);

        $arPropertys = array();
        foreach ($xml->Классификатор->Свойства->Свойство as $obPropety) {
            $idProp = (string)$obPropety->Ид;
            if ($idProp == self::$XML_ID_TSVET) {
                foreach ($obPropety->ВариантыЗначений->Справочник as $obPropetyV) {
                    $arPropertys[$idProp][(string)$obPropetyV->ИдЗначения] = CUtil::translit(strtolower((string)$obPropetyV->Значение), "ru", self::$translateParams);
                }
            }
            if ($idProp == self::$XML_ID_STIL) {
                foreach ($obPropety->ВариантыЗначений->Справочник as $obPropetyV) {
                    $arPropertys[$idProp][(string)$obPropetyV->ИдЗначения] = CUtil::translit(strtolower((string)$obPropetyV->Значение), "ru", self::$translateParams);
                }
            }
        }

        foreach ($xml->Каталог->Товары->Товар as $obProduct) {
            $propertyValueproductToRemove = array();
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                $val = (string)$obProperty->Значение;
                if (isset($val{1})) {
                    if (in_array($val, $arValueRemove[$idProp])) {
                        $propertyValueproductToRemove[] = $obProperty;
                    }
                }
            }
            foreach ($propertyValueproductToRemove as $code) {
                unset($code[0]);
            }
        }

        $strXML = $xml->asXML();
        $xml = new SimpleXMLElement($strXML);
        foreach($xml->Каталог->Товары->Товар as $obProduct) {
            $strRazmerOffers = '';
            $arPropAll = array();
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                if (($idProp == self::$XML_ID_STIL) or ($idProp == self::$XML_ID_TSVET)) {
                    $arPropAll[$idProp] = (string)$obProperty->Значение;
                }
                elseif ($idProp == self::$XML_ID_RAZMER) {
                    $strRazmerOffers = $obProperty;
                }
            }

            $id = (string)$obProduct->Ид;
            $arImportProducts[$id] = $id;

            $tsvet = $arPropertys[self::$XML_ID_TSVET][$arPropAll[self::$XML_ID_TSVET]];
            $stil = $arPropertys[self::$XML_ID_STIL][$arPropAll[self::$XML_ID_STIL]];
            if (isset($stil{1}) and isset($tsvet{1})) {
                $strCodeProp = $stil . '-' . $tsvet;
                $codeOffer = CUtil::translit(strtolower($strCodeProp), "ru", self::$translateParams);
            } else {
                $strCodeProp = $id;
                $codeOffer = CUtil::translit(strtolower($strCodeProp), "ru", self::$translateParams);
            }
            self::$arOffersRazmer[$id] = $strRazmerOffers;
            self::$arOffersBarCodeReplace[$id] = (string)$obProduct->Штрихкод;

            self::$arNewOffersArticles[$id] = (string)$obProduct->Артикул;
            self::$arNewOffersName[$id] = (string)$obProduct->Наименование;
            self::$arNewOffersBaseEd[$id] = $obProduct->БазоваяЕдиница;

            self::$arProductsXML[$codeOffer] = $id;
            self::$arProductsXMLCode[$id] = $codeOffer;
            $arProductsXMLOffers[$codeOffer][] = $arImportProducts[$id];
        }
        foreach ($arProductsXMLOffers as $key => $offers) {
            foreach ($offers as $offer) {
                self::$arOffersXMLReplace[$offer] = $key . self::$STR_DELIMITER_OFFERS . '#' . $offer;
                self::$arOffersRazmerReplace[$offer] = self::$arOffersRazmer[$offer];
            }
        }

        foreach($xml->Классификатор->Свойства->Свойство as $obPropety) {
            if ((string)$obPropety->Ид == self::$XML_ID_RAZMER) {
                self::$strRazmer = $obPropety;
            }
        }
        unset($urlFile,$xml,$arProductsXMLOffers,$arImportProducts,$arPropertys);
    }

    public static function processingFileOffers($arOffersRazmerReplace, $arOffersXMLReplace, $arOffersBarCodeReplace, $strRazmer)
    {
        $arTemp = $arOffersXMLReplace;

        $arRazmerValueRemove = array();
        $propertyValueToRemove = array();
        foreach ($strRazmer->ВариантыЗначений->Справочник as $obPropetyV) {
            if (strpos((string)$obPropetyV->Значение, 'Объект') !== false) {
                $arRazmerValueRemove[] = (string)$obPropetyV->ИдЗначения;
                $propertyValueToRemove[] = $obPropetyV;
            }
            if (strpos((string)$obPropetyV->Значение, '<>') !== false) {
                $arRazmerValueRemove[] = (string)$obPropetyV->ИдЗначения;
                $propertyValueToRemove[] = $obPropetyV;
            }
        }
        foreach ($propertyValueToRemove as $code) {
            unset($code[0]);
        }
        $urlFileOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME_OFFERS;
        $urlFileDataOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_OFFERS;
        $xml = simplexml_load_file($urlFileOffers);
        $strXML = $xml->asXML();
        $xml = new SimpleXMLElement($strXML);

        $xml->Классификатор->Свойства = $strRazmer->asXML();

        $arStores = array();
        foreach ($xml->ПакетПредложений->Склады->Склад as $obStore) {
            $arStores[] = (string)$obStore->Ид;
        }
        $arPrices = array();
        foreach ($xml->ПакетПредложений->ТипыЦен->ТипЦены as $obPrice) {
            $arPrices[(string)$obPrice->Ид] = (string)$obPrice->Валюта;
        }

        foreach ($xml->ПакетПредложений->Предложения->Предложение as $obOffer) {
            $id = (string)$obOffer->Ид;
            $obOffer->Ид = $arOffersXMLReplace[$id];
            $obOffer->Штрихкод = $arOffersBarCodeReplace[$id];
            $val = (string)$arOffersRazmerReplace[$id]->Значение;
            if (isset($val{1})) {
                if (!in_array($val,$arRazmerValueRemove)) {
                    $obOffer->ЗначенияСвойств = (string)($arOffersRazmerReplace[$id]->asXML());
                }
            }

            $strProdPropertyXML = '
                <Ид>' . self::$codePropertyXML_ID . '</Ид>
                <Значение>' . $id . '</Значение>
            ';
            $obOffer->ЗначенияСвойств->ЗначенияСвойства[] = $strProdPropertyXML;
            unset($arTemp[$id]);
        }
        foreach ($arTemp as $key => $val) {
            $strNewOffersXML = '
                <Ид>' . $val . '</Ид>
                <Артикул>' . self::$arNewOffersArticles[$key] . '</Артикул>
                <Штрихкод>' .  self::$arOffersBarCodeReplace[$key] . '</Штрихкод>
                <Наименование>' .  self::$arNewOffersName[$key] . '</Наименование>
                <ЗначенияСвойств>
                    <ЗначенияСвойства>
                         <Ид>' . self::$codePropertyXML_ID . '</Ид>
                         <Значение>' . $key . '</Значение>
                    </ЗначенияСвойства>
                </ЗначенияСвойств>                
				<Количество>0</Количество>
            ';
            $strNewOffersXML .=  '<Цены>';
            foreach ($arPrices as $keyP => $currency) {
                $strNewOffersXML .=  '
					<Цена>
						<Представление> 0 ' . $currency .' за шт</Представление>
						<ИдТипаЦены>' . $keyP .'</ИдТипаЦены>
						<ЦенаЗаЕдиницу>0</ЦенаЗаЕдиницу>
						<Валюта>' . $currency .'</Валюта>
						<Коэффициент>1</Коэффициент>
					</Цена>
					';
            }
            $strNewOffersXML .=  '</Цены>';
            foreach ($arStores as $keyS) {
                $strNewOffersXML .=  '
				<Склад ИдСклада="' . $keyS .'" КоличествоНаСкладе="0"/>
				';
            }
            $strNewOffersXML .= self::$arNewOffersBaseEd[$key]->asXML();
            $xml->ПакетПредложений->Предложения->Предложение[] = $strNewOffersXML;
        }

        $xml->Классификатор->Свойства->Свойство[] = self::$strPropertyXML_ID;
        $strXML = $xml->asXML();

        $strXML = html_entity_decode($strXML, ENT_NOQUOTES, 'UTF-8');
        $f_hdl = fopen($urlFileDataOffers, 'w');
        fwrite($f_hdl, $strXML);
        fclose($f_hdl);

        unset($urlFileOffers,$urlFileDataOffers,$xml,$strXML,$f_hdl);
    }

    public static function processingFileImport()
    {
        $arProductsXML = self::$arProductsXML;
        $arProductsXMLCode = self::$arProductsXMLCode;

        $urlFile = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME;
        $xml = simplexml_load_file($urlFile);
        $elementsToRemove = array();
        foreach ($xml->Каталог->Товары->Товар as $obProduct) {
            $id = (string)$obProduct->Ид;
            if (!in_array($id, $arProductsXML)) {
                // удаляем элемент
                $elementsToRemove[] = $obProduct;
            } else {
                // меняем XML у элемента
                $obProduct->Ид = $arProductsXMLCode[$id] . self::$STR_DELIMITER_OFFERS;
            }
            // удаление свойства Размер
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                if ($idProp == self::$XML_ID_RAZMER) {
                    $dom = dom_import_simplexml($obProperty);
                    $dom->parentNode->removeChild($dom);
                }
            }
            $strProdPropertyXML = '
                <Ид>' . self::$codePropertyXML_ID . '</Ид>
                <Значение>' . $id . '</Значение>
            ';
            $obProduct->ЗначенияСвойств->ЗначенияСвойства[] = $strProdPropertyXML;
        }
        foreach ($elementsToRemove as $code) {
            unset($code[0]);
        }

        $arValueRemove = array();
        $strXML = $xml->asXML();
        $xml = new SimpleXMLElement($strXML);
        $propertyValueToRemove = array();
        foreach ($xml->Классификатор->Свойства->Свойство as $obPropety) {
            // удалем свойство Размер
            if ((string)$obPropety->Ид == self::$XML_ID_RAZMER) {
                $dom = dom_import_simplexml($obPropety);
                $dom->parentNode->removeChild($dom);
            }

            $idProp = (string)$obPropety->Ид;
            foreach ($obPropety->ВариантыЗначений->Справочник as $obPropetyV) {
                if (strpos((string)$obPropetyV->Значение, 'Объект') !== false) {
                    $arValueRemove[$idProp][] = (string)$obPropetyV->ИдЗначения;
                    $propertyValueToRemove[] = $obPropetyV;
                }
                if (strpos((string)$obPropetyV->Значение, '<>') !== false) {
                    $arValueRemove[$idProp][] = (string)$obPropetyV->ИдЗначения;
                    $propertyValueToRemove[] = $obPropetyV;
                }
            }
        }
        $xml->Классификатор->Свойства->Свойство[] = self::$strPropertyXML_ID;

        foreach ($propertyValueToRemove as $code) {
            unset($code[0]);
        }
        foreach ($xml->Каталог->Товары->Товар as $obProduct) {
            $propertyValueproductToRemove = array();
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                if (in_array((string)$obProperty->Значение,$arValueRemove[$idProp])) {
                    $propertyValueproductToRemove[] =  $obProperty;
                }
            }
            foreach ($propertyValueproductToRemove as $code) {
                unset($code[0]);
            }
        }

        $strXML = $xml->asXML();

        $urlFileDataOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT;

        $strXML = html_entity_decode($strXML, ENT_NOQUOTES, 'UTF-8');

        $f_hdl = fopen($urlFileDataOffers, 'w');
        fwrite($f_hdl, $strXML);
        fclose($f_hdl);

        unset($xml, $urlFile, $elementsToRemove, $strXML, $f_hdl, $urlFileDataOffers);
    }
    public static function getArrayPictures()
    {
        $pathPictures = $_SERVER["DOCUMENT_ROOT"] . self::$PATH_PICT;

        $arFiles = array();
        $handle = opendir($pathPictures);
        if($handle)
        {
            while(($file = readdir($handle)) !== false)
            {
                if($file == "." || $file == "..")
                    continue;
                $pos = strpos($file, '-');
                if ($pos !== false) {
                    $barCode = substr($file, 0, $pos);
                    $arFiles[$barCode][] = $pathPictures . $file;
                }
            }
            closedir($handle);
        }

        $arBar = array();
        foreach ($arFiles as $bar=>$ar) {
            sort($ar);
            $arFiles[$bar] = $ar;
            $arBar[] = $bar;
        }

        if (count($arBar) > 0) {
            $arFilter = Array(
                "IBLOCK_ID" => self::$IBLOCK_ID,
                "=PROPERTY_CML2_BAR_CODE" => $arBar
            );
            $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array("ID", "IBLOCK_ID", "XML_ID", "PROPERTY_CML2_BAR_CODE", "DETAIL_PICTURE"));
            while ($ar_fields = $res->GetNext()) {
                $arPicture = array();
                $arPicture['DETAIL_PICTURE'] = $ar_fields['DETAIL_PICTURE'];
                self::$arPictureProducts[$ar_fields['ID']] = $ar_fields['DETAIL_PICTURE'];
                self::$arPictureID[$ar_fields['ID']] = $arFiles[$ar_fields['PROPERTY_CML2_BAR_CODE_VALUE']];
            }
            $arFilter = Array(
                "IBLOCK_ID" => self::$IBLOCK_OFFERS_ID,
                "=PROPERTY_CML2_BAR_CODE" => $arBar
            );
            $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_CML2_LINK.ID", "PROPERTY_CML2_LINK.DETAIL_PICTURE", "PROPERTY_CML2_BAR_CODE"));
            while ($ar_fields = $res->GetNext()) {
                $arPicture = array();
                $arPicture['DETAIL_PICTURE'] = $ar_fields['PROPERTY_CML2_LINK_DETAIL_PICTURE'];
                self::$arPictureProducts[$ar_fields['PROPERTY_CML2_LINK_ID']] = $arPicture;
                self::$arPictureID[$ar_fields['PROPERTY_CML2_LINK_ID']] = $arFiles[$ar_fields['PROPERTY_CML2_BAR_CODE_VALUE']];
            }
        }
    }
    public static function processingPicturesUpdate($arPictureProducts)
    {
        foreach ($arPictureProducts as $idProduct => $arProduct) {
            if (intval($arProduct['DETAIL_PICTURE']) == 0) {
                $pathDetailPicture = self::$arPictureID[$idProduct][0];
                $el = new CIBlockElement;
                $arLoadProductArray = Array(
                    "DETAIL_PICTURE" => CFile::MakeFileArray($pathDetailPicture)
                );

                $res = $el->Update($idProduct, $arLoadProductArray);
                if ($res) {
                    unlink($pathDetailPicture);
                    unset(self::$arPictureID[$idProduct][0]);
                }
            }
            foreach (self::$arPictureID[$idProduct] as $morePhoto) {
                $arFile = CFile::MakeFileArray($morePhoto);
                $arFile["MODULE_ID"] = "iblock";
                $arFile["DESCRIPTION"] = "";
                CIBlockElement::SetPropertyValues($idProduct, self::$IBLOCK_ID, $arFile, "MORE_PHOTO");
                unlink($morePhoto);
            }
        }
    }
    public static function processingPictures()
    {
        self::getArrayPictures();
        if (count(self::$arPictureID) > 0) {
            self::processingPicturesUpdate(self::$arPictureProducts);
        }
    }
}