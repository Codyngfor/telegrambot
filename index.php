<?php
    require("vendor/autoload.php");
    $json = require("current.city.list.json");

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



    $bot->command('setmysity', function ($message) use ($bot) 
    {
        // не нужный код
        // $answer = ;
        // if ( $answer === 'Write your sity, please....') $success = true;

        // вывод сообщения боту 
        $bot->sendMessage($message->getChat()->getId(), 'Write your sity, please....');

        // // принятие сообщения
        // $text = $message->getText();

        // // трансформируем русский текст в кирилицу
        // $sityname = translit($text);

        // // подключаем json файл
        // $json = file_get_contents('city.list.min.json', true);
        
        // // декодируем файл
        // $data = json_decode($json,true);
      
        // // перебераем файл для отбора по названию
        // for ($i = 0; $i < count($data); $i++ )
        // {
        //   if($sityname == $data[$i]['name']) {
        //     $sityname1 = $data[$i]['name'];
        //     break;
        //   }
        // }
    
    });



    // $bot->command('setmysity', function ($message) use ($bot) 
    // {
    //     $text = $message->getText();
    //     $text = translit($text);
    //     $param = str_replace('/setmysity ', '', $text);
    //     $answer = 'Неизвестная команда';

    //     if (isset($param))
    //     {
    //         $answer = 'Ваш текст на английском: ' . $param;
    //     }
        

    //     $bot->sendMessage($message->getChat()->getId(), $answer);

    
    // });



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
