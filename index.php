<?php
    require("vendor/autoload.php");

    $token = "875474339:AAG5Jix5QEX4kikIomawJDDViebeO68bilA";
    $bot = new \TelegramBot\Api\Client($token);

    // команда для start
    $bot->command('start', function ($message) use ($bot) 
    {
        $answer = 'Добро пожаловать!';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    // команда для помощи
    $bot->command('help', function ($message) use ($bot) 
    {
        $answer = 'Команды:
        /weather - weather now
        /start - начало работы с ботом
        /help - вывод справки';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->command('hello', function ($message) use ($bot) 
    {
        $text = $message->getText();
        $param = str_replace('/hello ', '', $text);
        $answer = 'Неизвестная команда';
        if (isset($param))
        {
            $answer = 'Привет, ' . $param;
        }
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->command('weather', function ($message) use ($bot) 
    {
        $text = $message->getText();
        $param = str_replace('/weather ', '', $text);
        $answer = 'Неизвестная команда';
        if (isset($param))
        {
            $url = "https://api.openweathermap.org/data/2.5/weather?id=3073170&units=metric&appid=f2fddbc999a6344117a983a2ead391be&lang=ru";

            $contents = file_get_contents($url);
            $weather=json_decode($contents);

            $temp_now=$weather->main->temp."°C";
            $today = date("j.m.Y, H:i:s");
            $cityname = $weather->name;
           
            $answer = $today.",  ".$cityname.", ".$temp_now;
        }
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->run();


?>
