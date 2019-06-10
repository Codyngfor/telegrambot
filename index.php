<?php
    require("vendor/autoload.php");

    $token = "875474339:AAG5Jix5QEX4kikIomawJDDViebeO68bilA";
    $bot = new \TelegramBot\Api\Client($token);
    // команда для start

    $bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    // команда для помощи
    $bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
    /help - вывод справки';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->run();


?>