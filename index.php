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



    $bot->command('translit', function ($message) use ($bot) 
    {
        $text = $message->getText();
        $text = translit($text);
        $param = str_replace('/translit ', '', $text);
        $answer = 'Неизвестная команда';

        if (isset($param))
        {
            $answer = 'Ваш текст: ' . $text . 'Ваш текст на английском: ' . $param;
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

    //functions
    function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        return $s; // возвращаем результат
      }
?>
