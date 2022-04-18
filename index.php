<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('sale');

header('Content-Type: application/json');

$date = new \Bitrix\Main\Type\DateTime();
$date->add('-1M');

$parameters = [
   'filter' => [
       ">=DATE_INSERT" => $date
   ],
   'order' => ["DATE_INSERT" => "ASC"]
];

$dbRes = \Bitrix\Sale\Order::getList($parameters);

$orders = [];
while ($order = $dbRes->fetch())
{
	$orders[] = $order;
}

$mapped = array_map(function ($order) {
	$ord = array_map(function ($elem) {
		if(gettype($elem) == 'object') {
			return $elem->toString();
		}
		return $elem;
	}, $order);
	return $ord;
}, $orders);

echo \Bitrix\Main\Web\Json::encode($mapped);

?>
