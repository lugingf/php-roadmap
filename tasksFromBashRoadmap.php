<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программы, решающие пять задач из роадмэпа по bash:
 * Тестовые данные брать отсюда - https://stash.tutu.ru/users/nikulin/repos/testlogsforphprodmap/browse
 * a) Посчитать статистику числа ошибок за вчерашний день с группировкой по серверам. Лог - php-error.log
 * b) Посчитать раскупаемость направлений (усредненное за день кол-во доступных мест за 45, 40, 30, 20, 10 дней до
 * поездки) для двух различных направлений, например Москва - Питер vs Москва - Челябинск. Лог - ryticket_queries_search
 * c) Вычислить cache hit-rate - процент ответов кэша на detail-запросы за несколько различных дат. Отличается ли хит-рейт
 * в будние и выходные дни? Лог - ryticket_queries_detail
 * d) Собрать статистику кол-ва чашек чая на бою по дням за последние 2 недели. Есть ли всплески? В какие дни они
 * происходили? Лог - teacup
 * e) Собрать унифицированную (т.е. не обращающую внимания на параметры, переданные в вызываемые методы) статистику по
 * обращениям к deprecated-функционалу. Лог - deprecated
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'tools/commonTools.php';
include 'oop/LogActions/LogActionStrategy.class.php';
include 'oop/LogActions/ErrorCountByServer.class.php';
include 'oop/LogActions/PayoffDirections.class.php';
include 'oop/LogActions/GetCacheHitRate.class.php';
include 'oop/LogActions/TeacupCount.class.php';
include 'oop/LogActions/DeprecatedFuncStat.class.php';
include 'oop/FileStringIterator.class.php';

const ACTIONS = [
	'a' => 'ErrorCountByServer',
	'b' => 'PayoffDirections',
	'c' => 'GetCacheHitRate',
	'd' => 'TeacupCount',
	'e' => 'DeprecatedFuncStat'
];

$logDirectory = '/home/lugin/devel/rm_logs/testlogsforphprodmap';

if (!isset($argv[1]))
{
	sendDataToStderr(getPhrase('noArgsText') . "\n" . getPhrase('logScannerExample'));
	exit(1);
}

$actionCode = $argv[1];

/** @var oop\LogActions\LogActionStrategy $action */
$action = \oop\LogActions\LogActionStrategy::getAction(ACTIONS[$actionCode] ?? null, array_slice($argv, 2));


if (is_null($action))
{
	sendDataToStderr(getPhrase('noLogAction'));
	exit();
}
try
{
	sendDataToStdOut($action->process());
}
catch (Exception $e)
{
	sendDataToStderr($e);
}
