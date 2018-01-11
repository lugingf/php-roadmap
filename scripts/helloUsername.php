<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая спрашивает при запуске имя пользователя с приглашением "What is your name?" и выводит фразу "Hello, <введенное_имя>!"
 *
 */

echo "What is your name?" . "\n";

$userNameTrimmed = trim(fgets(STDIN));

if (!$userNameTrimmed)
{
    echo "No name - no greeting" . "\n";
}
else
{
    echo "Hello, $userNameTrimmed!" . "\n";
}

