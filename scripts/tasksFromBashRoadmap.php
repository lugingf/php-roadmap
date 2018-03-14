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

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;

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
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText') . "\n" . TextsTemplates::getPhrase('logScannerExample'));
	exit(1);
}

$actionCode = $argv[1];

/** @var EL\LogActions\LogActionStrategy $action */
$action = EL\LogActions\LogActionStrategy::getAction(ACTIONS[$actionCode] ?? null, array_slice($argv, 2));


if (is_null($action))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noLogAction'));
	exit();
}
try
{
	InputOutputTools::sendDataToStdOut($action->process());
}
catch (Exception $e)
{
	InputOutputTools::sendDataToStderr($e);
}
