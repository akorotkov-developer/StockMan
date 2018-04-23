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
    public static $FILE_IMPORT_RAZMER = '/upload/1c_catalog/data_import_razmer.xml';
    public static $FILE_OFFERS_N = 'data_offers.xml';
    public static $FILE_OFFERS = '/upload/1c_catalog/data_offers.xml';

    public static $XML_ID_STIL = '9f4387df-5b34-11e7-80e0-00155d0f1c03';
    public static $XML_ID_TSVET = 'cf6449d9-5b32-11e7-80e0-00155d0f1c03';
    public static $XML_ID_RAZMER = 'ff296996-5b34-11e7-80e0-00155d0f1c03';
    public static $XML_ID_RUS_RAZMER = 'c6bfc49e-5b32-11e7-80e0-00155d0f1c03';

    public static $CODE_PROPERTYY_TSVET = 'TSVET';
    public static $NAME_PROPERTYY_TSVET = 'Цвет';

    public static $STR_DELIMITER_OFFERS = '-p';


    public static $arProductsXML = array(); // XML - всех Карточек
    public static $arProductsXMLCode = array(); // XML - всех Карточек
    public static $arOffersXMLReplace = array(); // Замена Xml на Торговое предложение
    public static $arNewOffersArticles = array(); // Артикулы новых предложений
    public static $arNewOffersName = array(); // Названия новых предложений
    public static $arNewOffersBaseEd = array(); // БазоваяЕдиница новых предложений

    public static $arOffersRusRazmer = array(); // Добавление свойства Размер
    public static $arOffersRusRazmerReplace = array(); // Добавление свойства Размер

    public static $arOffersRazmer = array(); // Добавление свойства Размер
    public static $arOffersRazmerReplace = array(); // Добавление свойства Размер
    public static $arOffersBarCodeReplace = array(); // Штрихкод
    public static $strRazmer = ''; // Размер
    public static $strRusRazmer = ''; // Российский Размер

    public static $codePropertyXML_ID = 'property-xml-id-1c-80e0-00155d0f1c03';
    public static $strPropertyXML_ID = '<Ид>property-xml-id-1c-80e0-00155d0f1c03</Ид><Наименование>XML_ID из 1С</Наименование><ТипЗначений>Строка</ТипЗначений>';

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
        self::processingFileOffers(self::$arOffersRazmerReplace, self::$arOffersRusRazmerReplace, self::$arOffersXMLReplace, self::$arOffersBarCodeReplace, self::$strRazmer, self::$strRusRazmer);
        self::processingFileImport();
    }
    public static function processingFile() {
        libxml_use_internal_errors(true);
        $urlFile = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME;
        //$urlFile = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME_OFFERS;
        $xml = simplexml_load_file($urlFile);
        //$xml = simplexml_load_string(file_get_contents($urlFile), 'SimpleXMLElement', LIBXML_PARSEHUGE);
        if (!$xml) {
            /*$curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://new2.podium-market.com/upload/import0_1.xml');
            curl_setopt ($curl , CURLOPT_RETURNTRANSFER,1 );
            curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0");
            curl_setopt($curl,CURLOPT_HEADER,0);

            $data = curl_exec($curl);
            curl_close($curl);

            $xml = simplexml_load_string($data) or die("Ошибка загрузки URL");

            $str = (string)$xml->Классификатор->Ид;
            echo "<pre>";
            print_r($str);
            echo "</pre>";
            die();*/
            echo 'файл не получен\n';
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        } else {
            $str = (string)$xml->Классификатор->Ид;
            echo "<pre>";
            print_r($str);
            echo "</pre>";
            libxml_clear_errors();
        }

        /*$xml = simplexml_load_file($urlFile);
        //$ret = $xml->asXML();
        $f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer1.xml', 'w');
        fwrite($f_hdl, (string)$xml->Классификатор->Ид);
        fclose($f_hdl);
        var_dump((string)$xml->Классификатор->Ид);*/
        if (PHP_SAPI == 'cli') {
            /*$curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://new2.podium-market.com/local/tools/1.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

            curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0");
            curl_setopt($curl,CURLOPT_HEADER,0);

            $data1 = curl_exec($curl);
            //$data1 = iconv( "cp1251","UTF-8", $data1);
            curl_close($curl);


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://new2.podium-market.com/' . self::$FILE_NAME);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl,CURLOPT_HEADER,0);

            /*$new = file($urlFile);
            $file = fopen($_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT_RAZMER, 'w+');

            foreach($new as $v)
                if($v != "\r\n")
                    fwrite($file, $v);

            fclose($file);*/

            //$data = curl_exec($curl);
            // curl_close($curl);
            //$isWinCharset = mb_check_encoding($data, "windows-1251");
            // if ($isWinCharset) {
            //$data = html_entity_decode($data, ENT_NOQUOTES, 'UTF-8'); //iconv("windows-1251", "UTF-8", $data);
            //$data = mb_convert_encoding($data, "windows-1251", 'UTF-8');
            // }
            /*$urlFile = $_SERVER["DOCUMENT_ROOT"] . ImportStokMan::$FILE_NAME;

            $handle = fopen($urlFile, "rb");
            if (FALSE === $handle) {
                exit("Не удалось открыть поток по url адресу");
            }

            $contents = '';

            while (!feof($handle)) {
                $contents .= str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', html_entity_decode(fread($handle, 8192), ENT_NOQUOTES, 'UTF-8'));
            }
            fclose($handle);
            $xml = simplexml_load_string((string)$contents);
            var_dump((string)$xml->Классификатор->Ид);*/
            /**$xml = simplexml_load_string("<document><title>Forty What?</title><from>Joe</from><to>Jane</to><body>I know that's the answer -- but what's the question?</body></document>");
            var_dump($xml);*/
            //
            //$f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer1.xml', 'w');
            //fwrite($f_hdl, (string)$xml->Классификатор);
            //fclose($f_hdl);

            unset($data);
            /*$f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer2.xml', 'w');
            fwrite($f_hdl, $xml);
            fclose($f_hdl);*/
            /*$f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer3.xml', 'w');
            fwrite($f_hdl, new SimpleXMLElement($data));
            fclose($f_hdl);
            $f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer4.xml', 'w');
            fwrite($f_hdl, new SimpleXMLElement(simplexml_load_string($data)));
            fclose($f_hdl);*/


            //$data1 = $data;
            //$xml = simplexml_load_string($data);
            // $xml = html_entity_decode($xml, ENT_NOQUOTES, 'UTF-8');
            // $xml = html_entity_decode($xml, ENT_NOQUOTES, 'UTF-8');
            //$xml = new SimpleXMLElement($data);
            /*echo "<pre>";
            print_r("----");
            echo "</pre>";
            echo "<pre>";
            print_r($xml);
            echo "</pre>";*/
            //$ret = $xml;


            /*$f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer3.xml', 'w');
            fwrite($f_hdl, new SimpleXMLElement($xml));
            fclose($f_hdl);
            $f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer1.xml', 'w');
            fwrite($f_hdl, $ret);
            fclose($f_hdl);

            $f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer2.xml', 'w');
            fwrite($f_hdl, new SimpleXMLElement($data1));
            fclose($f_hdl);*/
        } else
        {
            $xml = simplexml_load_file($urlFile);
            /*$ret = $xml->asXML();
            $f_hdl = fopen($_SERVER["DOCUMENT_ROOT"] . '/local/logs/data_import_razmer1.xml', 'w');
            fwrite($f_hdl, $ret);
            fclose($f_hdl);*/
        }


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
        unset($propertyValueToRemove);

        /*$strXML = $xml->asXML();
        unset($xml);
        $xml = new SimpleXMLElement($strXML);
        unset($strXML);*/
        //$xml = new SimpleXMLElement($xml);
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
        /*$strXML = $xml->asXML();
        unset($xml);*/
        //$xml = new SimpleXMLElement($xml);
        unset($strXML);
        foreach($xml->Каталог->Товары->Товар as $obProduct) {
            $strRazmerOffers = '';
            $strRusRazmerOffers = '';
            $arPropAll = array();
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                if (($idProp == self::$XML_ID_STIL) or ($idProp == self::$XML_ID_TSVET)) {
                    $arPropAll[$idProp] = (string)$obProperty->Значение;
                }
                elseif ($idProp == self::$XML_ID_RAZMER) {
                    $strRazmerOffers = $obProperty;
                }
                elseif ($idProp == self::$XML_ID_RUS_RAZMER) {
                    $strRusRazmerOffers = $obProperty;
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
            self::$arOffersRusRazmer[$id] = $strRusRazmerOffers;

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
                self::$arOffersRusRazmerReplace[$offer] = self::$arOffersRusRazmer[$offer];
            }
        }
        foreach($xml->Классификатор->Свойства->Свойство as $obPropety) {
            if ((string)$obPropety->Ид == (string)self::$XML_ID_RAZMER) {
                //$strRazmer = dom_import_simplexml($obPropety);
                /* $urlFileDataRazmer = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT_RAZMER;
                 $strXMLRazmer = html_entity_decode($obPropety, ENT_NOQUOTES, 'UTF-8');

                 $f_hdl = fopen($urlFileDataRazmer, 'w');
                 fwrite($f_hdl, $strXMLRazmer);
                 fclose($f_hdl);
                 unset($strXMLRazmer);*/

                //$dom = new domDocument;
                //$dom->loadXML($obPropety);

                //$dom = new DOMDocument;
                //$dom = $obPropety->asXML();

                //$strR = simplexml_load_string($obPropety);
                //$simple_shop = simplexml_import_dom($obPropety);

                // $ar = $obPropety->asXML();
                //$ar2 = 3;//dom_import_simplexml($obPropety->asXML());
                self::$strRazmer = $obPropety;
                //self::$strRazmer = simplexml_load_string($obPropety->asXML());
            }
            elseif ((string)$obPropety->Ид == self::$XML_ID_RUS_RAZMER) {
                self::$strRusRazmer = $obPropety;
            }
        }

        echo "<pre>";
        //print_r( self::$strRazmer);
        echo "</pre>";
        /*$urlFileDataRazmer = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT_RAZMER;
        $strXMLRazmer = html_entity_decode($ar, ENT_NOQUOTES, 'UTF-8');

        $f_hdl = fopen($urlFileDataRazmer, 'w');
        fwrite($f_hdl, $strXMLRazmer);
        fclose($f_hdl);*/
        unset($strXMLRazmer);
        //$err = new SimpleXMLElement(self::$strRazmer);
        //$strRazmer = dom_import_simplexml($obPropety);

        unset($urlFile,$xml,$arProductsXMLOffers,$arImportProducts,$arPropertys);
    }

    public static function processingFileOffers($arOffersRazmerReplace, $arOffersRusRazmerReplace, $arOffersXMLReplace, $arOffersBarCodeReplace, $strRazmer, $strRusRazmer)
    {
        $arTemp = $arOffersXMLReplace;

        $arRazmerValueRemove = array();
        $arRusRazmerValueRemove = array();
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
        foreach ($strRusRazmer->ВариантыЗначений->Справочник as $obPropetyV) {
            if (strpos((string)$obPropetyV->Значение, 'Объект') !== false) {
                $arRusRazmerValueRemove[] = (string)$obPropetyV->ИдЗначения;
                $propertyValueToRemove[] = $obPropetyV;
            }
            if (strpos((string)$obPropetyV->Значение, '<>') !== false) {
                $arRusRazmerValueRemove[] = (string)$obPropetyV->ИдЗначения;
                $propertyValueToRemove[] = $obPropetyV;
            }
        }
        foreach ($propertyValueToRemove as $code) {
            unset($code[0]);
        }
        $urlFileOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME_OFFERS;
        $urlFileDataOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_OFFERS;
        $xml = simplexml_load_file($urlFileOffers);
        /**$strXML = $xml->asXML();
        unset($xml);
        $xml = new SimpleXMLElement($strXML);
        unset($strXML);*/
        //$strRazmer = new SimpleXMLElement($strRazmer);
        //$strRusRazmer = new SimpleXMLElement($strRusRazmer);
        //$urlStrRazmer = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT_RAZMER;
        //$xmlStrRazmer = simplexml_load_file($urlStrRazmer);

        $strAllRazmer = $strRazmer;//->asXML() . $strRusRazmer->asXML();
        $xml->Классификатор->Свойства = $strAllRazmer;

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

            $strPropertyOffer = '';
            $val = (string)$arOffersRazmerReplace[$id]->Значение;
            if (isset($val{1})) {
                if (!in_array($val,$arRazmerValueRemove)) {
                    $strPropertyOffer .= (string)($arOffersRazmerReplace[$id]->asXML());
                }
            }

            $val = (string)$arOffersRusRazmerReplace[$id]->Значение;
            if (isset($val{1})) {
                if (!in_array($val,$arRusRazmerValueRemove)) {
                    $strPropertyOffer .= (string)($arOffersRusRazmerReplace[$id]->asXML());
                }
            }
            $strProdPropertyXML = '<Ид>' . self::$codePropertyXML_ID . '</Ид><Значение>' . $id . '</Значение>';

            $strPropertyOffer .= '<ЗначенияСвойства>' . $strProdPropertyXML . '</ЗначенияСвойства>';

            $obOffer->ЗначенияСвойств = $strPropertyOffer;

            unset($arTemp[$id],$strPropertyOffer, $strProdPropertyXML);
        }
        foreach ($arTemp as $key => $val) {
            $strNewOffersXML = '<Ид>' . $val . '</Ид>';
            $strNewOffersXML .= '<Артикул>' . self::$arNewOffersArticles[$key] . '</Артикул>';
            $strNewOffersXML .= '<Штрихкод>' .  $arOffersBarCodeReplace[$key] . '</Штрихкод>';
            $strNewOffersXML .= '<Наименование>' .  self::$arNewOffersName[$key] . '</Наименование>';
            $strNewOffersXML .= '<Количество>0</Количество>';

            $strPropertyOffer = '';
            $val = (string)$arOffersRazmerReplace[$key]->Значение;
            if (isset($val{1})) {
                if (!in_array($val,$arRazmerValueRemove)) {
                    $strPropertyOffer .= (string)($arOffersRazmerReplace[$key]->asXML());
                }
            }
            $val = (string)$arOffersRusRazmerReplace[$key]->Значение;
            if (isset($val{1})) {
                if (!in_array($val,$arRusRazmerValueRemove)) {
                    $strPropertyOffer .= (string)($arOffersRusRazmerReplace[$key]->asXML());
                }
            }
            $strProdPropertyXML = '<Ид>' . self::$codePropertyXML_ID . '</Ид><Значение>' . $key . '</Значение>';

            $strPropertyOffer .= '<ЗначенияСвойства>' . $strProdPropertyXML . '</ЗначенияСвойства>';
            $strNewOffersXML .= '<ЗначенияСвойств>' . $strPropertyOffer . '</ЗначенияСвойств>';

            $strNewOffersXML .=  '<Цены>';
            foreach ($arPrices as $keyP => $currency) {
                $strNewOffersXML .=  '<Цена>';
                $strNewOffersXML .=  '<Представление> 0 ' . $currency . ' за шт</Представление>';
                $strNewOffersXML .=  '<ИдТипаЦены>' . $keyP .'</ИдТипаЦены>';
                $strNewOffersXML .=  '<ЦенаЗаЕдиницу>0</ЦенаЗаЕдиницу>';
                $strNewOffersXML .=  '<Валюта>' . $currency .'</Валюта>';
                $strNewOffersXML .=  '<Коэффициент>1</Коэффициент>';
                $strNewOffersXML .=  '</Цена>';
            }
            $strNewOffersXML .=  '</Цены>';
            foreach ($arStores as $keyS) {
                $strNewOffersXML .=  '<Склад ИдСклада="' . $keyS .'" КоличествоНаСкладе="0"/>';
            }
            $strNewOffersXML .= self::$arNewOffersBaseEd[$key]->asXML();
            $xml->ПакетПредложений->Предложения->Предложение[] = $strNewOffersXML;
            unset($strNewOffersXML,$arStores,$arPrices,$strPropertyOffer, $val, $strProdPropertyXML);
        }

        unset($arTemp);

        $xml->Классификатор->Свойства->Свойство[] = self::$strPropertyXML_ID;
        $strXML = $xml->asXML();
        unset($urlFileOffers,$xml,$arOffersRazmerReplace, $arOffersRusRazmerReplace, $arOffersXMLReplace, $arOffersBarCodeReplace, $strRazmer, $strRusRazmer);

        $strXML = html_entity_decode($strXML, ENT_NOQUOTES, 'UTF-8');
        $f_hdl = fopen($urlFileDataOffers, 'w');
        fwrite($f_hdl, $strXML);
        fclose($f_hdl);

        unset($urlFileDataOffers,$strXML,$f_hdl);

        self::$arOffersRazmerReplace = array();
        self::$arOffersRusRazmerReplace = array();
        self::$arOffersXMLReplace = array();
        self::$arOffersBarCodeReplace = array();
        self::$strRazmer = '';
        self::$strRusRazmer = array();
        self::$arNewOffersArticles = array();
        self::$arNewOffersName = array();
        self::$arNewOffersBaseEd = '';
    }

    public static function processingFileImport()
    {
        $arProductsXML = self::$arProductsXML;
        $arProductsXMLCode = self::$arProductsXMLCode;

        $urlFile = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_NAME;
        $xml = simplexml_load_file($urlFile);
        $elementsToRemove = array();
        $elementsToRemoveAllRazmer = array();
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
                    $elementsToRemoveAllRazmer[] = $obProperty;
                }
                elseif ($idProp == self::$XML_ID_RUS_RAZMER) {
                    $elementsToRemoveAllRazmer[] = $obProperty;
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
        foreach ($elementsToRemoveAllRazmer as $code) {
            unset($code[0]);
        }

        $arValueRemove = array();
        /*$strXML = $xml->asXML();
        unset($xml);
        $xml = new SimpleXMLElement($strXML);
        unset($strXML);*/
        $propertyValueToRemove = array();
        $propertyValueToRemoveAllRazmer = array();
        foreach ($xml->Классификатор->Свойства->Свойство as $obPropety) {
            // удалем свойство Размер
            if ((string)$obPropety->Ид == self::$XML_ID_RAZMER) {
                $propertyValueToRemoveAllRazmer[] = $obPropety;
                //$dom = dom_import_simplexml($obPropety);
                //$dom->parentNode->removeChild($dom);
            }
            elseif ((string)$obPropety->Ид == self::$XML_ID_RUS_RAZMER) {
                $propertyValueToRemoveAllRazmer[] = $obPropety;
                //$dom = dom_import_simplexml($obPropety);
                //$dom->parentNode->removeChild($dom);
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
        foreach ($propertyValueToRemoveAllRazmer as $code) {
            unset($code[0]);
        }
        unset($propertyValueToRemove,$propertyValueToRemoveAllRazmer);

        foreach ($xml->Каталог->Товары->Товар as $obProduct) {
            $propertyValueproductToRemove = array();
            foreach ($obProduct->ЗначенияСвойств->ЗначенияСвойства as $obProperty) {
                $idProp = (string)$obProperty->Ид;
                if (in_array((string)$obProperty->Значение,$arValueRemove[$idProp])) {
                    $propertyValueproductToRemove[] =  $obProperty;
                }


                if (strpos((string)$obProperty->Значение, 'Объект') !== false) {
                    $propertyValueproductToRemove[] =  $obProperty;
                }
                if (strpos((string)$obProperty->Значение, '<>') !== false) {
                    $propertyValueproductToRemove[] =  $obProperty;
                }
            }
            foreach ($propertyValueproductToRemove as $code) {
                unset($code[0]);
            }
        }

        $strXML = $xml->asXML();
        //$strXML = simplexml_load_string($xml);
        //$strXML = $xml;
        unset($xml, $elementsToRemove, $propertyValueToRemove, $propertyValueToRemoveAllRazmer);
        $urlFileDataOffers = $_SERVER["DOCUMENT_ROOT"] . self::$FILE_IMPORT;

        $strXML = html_entity_decode($strXML, ENT_NOQUOTES, 'UTF-8');

        $f_hdl = fopen($urlFileDataOffers, 'w');
        fwrite($f_hdl, $strXML);
        fclose($f_hdl);

        unset($urlFile, $strXML, $f_hdl, $urlFileDataOffers, $arProductsXMLCode, $arProductsXML, $elementsToRemoveAllRazmer, $propertyValueproductToRemove);
        self::$arProductsXML = array();
        self::$arProductsXMLCode = array();
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
    public static function processingDeActive()
    {
        $arIdDeActive = array();
        $arFilter = Array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => self::$IBLOCK_ID,
            array (
                "LOGIC" => "OR",
                array(
                    "=CATALOG_AVAILABLE" => "N"
                ),
                array(
                    "=SECTION_ID" => array(
                        self::$IBLOCK_SECTION_ERROR_ID,
                        self::$IBLOCK_SECTION_ID,
                    )
                ),
                array(
                    "DETAIL_PICTURE" => false,
                    "PROPERTY_MORE_PHOTO" => false
                )
            )
        );
        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, array("ID"));
        while ($ar_fields = $res->GetNext()) {
            $arIdDeActive[] = $ar_fields["ID"];
        }
        $i = 0;
        foreach ($arIdDeActive as $id) {
            $el = new CIBlockElement;
            $arLoadProductArray = Array(
                "ACTIVE"         => "N",
            );
            $el->Update($id, $arLoadProductArray);
            unset($arLoadProductArray, $el);
            $i++;
        }
        unset($arFilter, $res, $arIdDeActive);
    }
    public static function processingActive()
    {
        $arIdActive = array();
        // доступные, но не активные
        $arFilter = Array(
            "ACTIVE" => "N",
            "IBLOCK_ID" => ImportStokMan::$IBLOCK_ID,
            "=CATALOG_AVAILABLE" => "Y",
            "!SECTION_ID" => array(
                ImportStokMan::$IBLOCK_SECTION_ERROR_ID,
                ImportStokMan::$IBLOCK_SECTION_ID,
            ),
            array (
                "LOGIC" => "OR",
                array("!DETAIL_PICTURE" => false),
                array("!PROPERTY_MORE_PHOTO" => false),
            )
        );
        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, array("ID", "IBLOCK_ID", ));
        while ($ar_fields = $res->GetNext()) {
            $arIdActive[] = $ar_fields["ID"] ;
        }
        $i= 0;
        // Активируем товары
        foreach ($arIdActive as $id) {
            $el = new CIBlockElement;
            $arLoadProductArray = Array(
                "ACTIVE"         => "Y",
            );
            $el->Update($id, $arLoadProductArray);
            unset($arLoadProductArray, $el);
            $i++;
        }
        unset($arFilter, $res, $arIdActive);
    }
}