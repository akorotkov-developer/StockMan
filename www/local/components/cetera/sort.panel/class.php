<?
/**
 * Created by Alexey Panov.
 * Date: 24.12.2016
 * Time: 11:00
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright 2016, Alexey Panov
 * @git repository https://github.com/PanovAlexey/sort.panel
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\SystemException;
use \Bitrix\Main\Application;


class CCeteraSortPanelComponent extends \CBitrixComponent
{
    protected $requiredModules = ['iblock'];

    protected $defaults = [
        'sort' => 'created'
    ];

    protected function checkModules()
    {

        foreach ($this->requiredModules as $moduleName)
        {
            if (!Loader::includeModule($moduleName))
            {
                throw new SystemException(Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_NO_MODULE', ['#MODULE#',
                                                                                                       $moduleName]));
            }
        }

        return $this;
    }

    /**
     * Event called from includeComponent before component execution.
     * Takes component parameters as argument and should return it formatted as needed.
     *
     * @param  array [string]mixed $arParams
     *
     * @return array[string]mixed
     */
    public function onPrepareComponentParams($params)
    {

        global ${$params['SORT_NAME']};

        if (trim($params['SORT_NAME']) == '') {
            $params['SORT_NAME'] = 'SORT';
        }

        if (!(${$params['SORT_NAME']})) {
            ${$params['SORT_NAME']} = [];
        }

        global ${$params['ORDER_NAME']};

        if (trim($params['ORDER_NAME']) == '') {
            $params['ORDER_NAME'] = 'ORDER';
        }

        if (!(${$params['ORDER_NAME']})) {
            ${$params['ORDER_NAME']} = [];
        }

        if (!isset($params['CACHE_TIME'])) {
            $params['CACHE_TIME'] = 36000000;
        }

        return $params;
    }

    /**
     * Event called from includeComponent before component execution.
     * Includes component.php from within lang directory of the component.
     *
     * @return void
     */
    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    /**
     * @return $this
     */
    protected function prepareSortResult() {

        $request = Application::getInstance()->getContext()->getRequest();

        $sort = $request->getQuery('sort');

        if (empty($sort))
        {
           if (!empty($_SESSION['sort']))
               $sort = $_SESSION['sort'];
            else  $sort = $this->defaults['sort'];
        }
        else $_SESSION['sort'] = $sort;

        $result['SORT']['PROPERTIES'] = [
            [
                'CODE' => 'show_counter',
                'NAME' => Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_SORT_TYPES_POPULAR_VALUE'),
                'ORDER' => 'desc,nulls'
            ],
            [
                'CODE' => 'property_MINIMUM_PRICE',
                'NAME' => Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_SORT_TYPES_PRICE_ASC'),
                'ORDER' => 'asc,nulls'
            ],
            [
                'CODE' => 'property_MAXIMUM_PRICE',
                'NAME' => Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_SORT_TYPES_PRICE_DESC'),
                'ORDER' => 'desc,nulls'
            ],
            [
                'CODE' => 'created',
                'NAME' => Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_SORT_TYPES_DATE_VALUE'),
                'ORDER' => 'desc,nulls'
            ],
            [
                'CODE' => 'property_DISCOUNT',
                'NAME' => Loc::getMessage('COMPONENT_SORT_PANEL_COMPONENT_SORT_TYPES_DISCOUNT'),
                'ORDER' => 'desc,nulls'
            ],
        ];

        $GLOBALS[$this->arParams['SORT_NAME']] = $sort;

        foreach ($result['SORT']['PROPERTIES'] as $key => $property)
        {
            if ($sort == $property['CODE'])
            {
                $result['SORT']['PROPERTIES'][$key]['ACTIVE'] = true;
                $GLOBALS[$this->arParams['ORDER_NAME']] = $property['ORDER'];

                break;
            }
        }

        $this->arResult = $result;
    }

    public function executeComponent()
    {
        try
        {
            $this->checkModules();
            $this->prepareSortResult();

            $this->includeComponentTemplate();
        }
        catch (SystemException $e)
        {
            self::__showError($e->getMessage());
        }
    }
}