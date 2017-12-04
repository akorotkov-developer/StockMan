<?
namespace StockMan\User;
use StockMan\User\User;

//AddEventHandler("main", "OnBeforeUserUpdate", Array("Favourites", "OnBeforeUserUpdateHandler"));
//AddEventHandler("main", "OnAfterUserLogin", Array("Favourites", "OnAfterUserLoginHandler"));

Class Favourites {

    /*
     * ��������� ��������
     */
    static $propertyCode = "UF_FAVOURITES";

    /*
     * ������, ����������� � ���������
     */
    var $products = array();
    var $productsDetail = array();

    /*
     * ������, ����������� � ���������
     */
    var $user_id = 0;

    /*
     * ������
     */
    var $sError = "";

    function __construct() {
        global $USER;
        $this->user_id = $USER->GetID();

        $this->GetList();
    }

    //��� ��������� �������� ����� ������� ��������� ���������� ���.
    //static context
    /*function OnBeforeUserUpdateHandler(&$arFields) {
        if ($arFields[self::$propertyCode]) {
            $this->GetList();
            $this->saveListToSession();
        }
    }*/

    /*function OnAfterUserLoginHandler(&$arFields) {
        $_SESSION["FAVOURITES"] = $this->products;
    }*/

    function GetList() {
        //if (($this->getListFromSession()) === null) { //�� ���� ������ ��� ��������������
        global $USER;
        if ($USER->IsAuthorized()) {
            $by = "ID";
            $order = "desc";
            $rsUser = User::GetList($by, $order, array("ID" => $this->user_id), array("SELECT" => array(self::$propertyCode)));
            if ($arUser = $rsUser->Fetch()) {
                if (!empty($arUser[self::$propertyCode])) {
                    $arFilter = Array(
                        "IBLOCK_ID" => CATALOG_IB_ID,
                        "ACTIVE" => "Y",
                        "ID" => $arUser[self::$propertyCode]
                    );
                    $res = \CIBlockElement::GetList(Array("SORT" => "ASC", "PROPERTY_PRIORITY" => "ASC"), $arFilter, false);
                    while ($ar_fields = $res->GetNext()) {
                        $this->productsDetail[$ar_fields["ID"]] = $ar_fields;
                        $this->products[] = $ar_fields["ID"];
                    }
                    //$this->saveListToSession();
                }
            }
        }
        /*} else { //�� ������
            $this->products = $this->getListFromSession();
        }*/

        return array_unique($this->products);
    }

    function isEmpty() {
        return $this->products === array();
    }

    /*function saveListToSession() {
        $_SESSION["FAVOURITES"] = $this->products;
    }*/

    /*
     function getListFromSession() {
        if (isset($_SESSION["FAVOURITES"])) {
            $cache = $_SESSION["FAVOURITES"];
        } else {
            $cache = null;
        }
        return $cache;
    }*/

    function Add($elemID) {
        $elemID = intval($elemID);
        if ($elemID > 0) {
            $user = new \CUser();
            $this->products[] = $elemID;
            $this->products = array_unique($this->products);
            $fields = Array(
                self::$propertyCode => $this->products,
            );
            if ($user->Update($this->user_id, $fields)) {
                //$this->saveListToSession();
                return true;
            } else {
                return $this->sError = $user->LAST_ERROR;
            }
        }
    }

    function Remove($elemID) {
        $elemID = intval($elemID);
        if ($elemID > 0) {
            $user = new \CUser();
            if ( ($key = array_search($elemID, $this->products)) !== false ) {
                unset($this->products[$key]);
            }
            $fields = Array(
                self::$propertyCode => $this->products,
            );
            if ($user->Update($this->user_id, $fields)) {
                //$this->saveListToSession();
                return true;
            } else {
                return $this->sError = $user->LAST_ERROR;
            }
        }
    }

    /*
     * ���� �� ������� � ��������� � ������������
     */
    function isInFavourites($elemID) {
        $isInFavourites = false;
        $elemID = intval($elemID);
        if ($elemID > 0) {
            if ( ($key = array_search($elemID, $this->products)) !== false ) {
                $isInFavourites = true;
            }
        }
        return $isInFavourites;
    }

    function Count() {
        return intval(count($this->products));
    }
}