<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая спрашивает возраст пользователя (число полных лет), и выводит информацию о том,
 * на сколько лет пользователь младше Пушкина, Лермонтова, Л. Н. Толстого. Информацию представить в виде
 * человекопонятного предложения в произвольной форме.
 */

echo "Укажите сколько вам полных лет: " . "\n";
$currentYear = date("Y");
$writersYears = [
    "Пушкин" => 1799,
    "Лермонтов" => 1814,
    "Л.Н. Толстой" => 1828
];

$userAge = trim(fgets(STDIN));

if (preg_match('/\D/', $userAge) || $userAge <= 0 || $userAge > 110)
{
    echo "Значение $userAge не может быть количеством лет" . "\n";
}
else
{
    $userBirthYear = $currentYear - $userAge;
    echo "Ваш год рождения $userBirthYear" . "\n";
    foreach ($writersYears as $writerName => $writerBirthYear)
    {
        $ageDif = getAgeDif($userBirthYear, $writerBirthYear);
        echo "Вы младше чем " . $writerName . " на " . $ageDif . " " . getYearWordForm($ageDif) . "\n";
    }
}



function getAgeDif($baseYear, $secondYear)
{
    return $baseYear - $secondYear;
}

function getYearWordForm($yearCount)
{
    $lastNumber = mb_substr(strval($yearCount), -1, 1);
    if ($lastNumber == '1')
    {
        return "год";
    }
    elseif (in_array($lastNumber, ['2','3','4']))
    {
        return "года";
    }
    else
    {
        return "лет";
    }
}