<?php
/**
 * Common functions
 */

/**
 * Лог в файл + backtrace
 * Путь до файла: /local/php_interface/StockMan.log
 * @param mixed $variable1 ,$variable2,...
 */
function writeLog()
{
  $logFileName = '/local/php_interface/StockMan.log';

  $backtrace = debug_backtrace();
  $backtracePath = array();
  foreach($backtrace as $k => $bt)
  {
    if($k > 2)
      break;
    $backtracePath[] = substr($bt['file'], strlen($_SERVER['DOCUMENT_ROOT'])) . ':' . $bt['line'];
  }

  $data = func_get_args();
  if(count($data) == 0)
    return;
  elseif(count($data) == 1)
    $data = current($data);

  if(!is_string($data) && !is_numeric($data))
    $data = var_export($data, 1);

  file_put_contents($_SERVER['DOCUMENT_ROOT'] . $logFileName, "\n--------------------------" . date('Y-m-d H:i:s ') . microtime() . "-----------------------\n Backtrace: " . implode(' → ', $backtracePath) . "\n" . $data, FILE_APPEND);
}
function writeLogImport()
{
  $logFileName = '/local/logs/Import_' . date("Y_m_d") . '.log';

  $backtrace = debug_backtrace();
  $backtracePath = array();
  foreach($backtrace as $k => $bt)
  {
    if($k > 2)
      break;
    $backtracePath[] = substr($bt['file'], strlen($_SERVER['DOCUMENT_ROOT'])) . ':' . $bt['line'];
  }

  $data = func_get_args();
  if(count($data) == 0)
    return;
  elseif(count($data) == 1)
    $data = current($data);

  if(!is_string($data) && !is_numeric($data))
    $data = var_export($data, 1);

  file_put_contents($_SERVER['DOCUMENT_ROOT'] . $logFileName, "\n--------------------------" . date('Y-m-d H:i:s ') . microtime() . "-----------------------\n Backtrace: " . implode(' → ', $backtracePath) . "\n" . $data, FILE_APPEND);
}

/* склонение существительных
 *  inclination($arResult["NUM_PRODUCTS"],array('товар','товара','товаров'))
 */
function inclination($time,$arr)
{
	$timex = substr($time, -1);
	if ($time >=10 AND $time <=20) return $arr[2];
	elseif ($timex == 1) return $arr[0];
	elseif ($timex>1 AND $timex<5) return $arr[1];
	else return $arr[2];
}

/**
 * Удалить из GET параметр SHOWALL (отображает все элементы на 1 странице)
 * почти всегда это приводит к полному зависанию сервака
 */
function clearShowAll()
{
  if(!empty($_GET))
    foreach ($_GET as $key => $value) 
    {
      if(strpos($key, 'SHOWALL') === 0)
        unset($_GET[$key]);
    }
}