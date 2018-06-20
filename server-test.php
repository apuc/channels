<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 22.04.2018
 * Time: 14:26
 */
// подключение автозагрузчика Composer
require __DIR__ . '/vendor/autoload.php';

// подключение файла класса Yii
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/console/config/main.php';
use \workerman\Worker;
use yii\console;
use Yii;

Yii::$classMap['Workerman\Worker'] = __DIR__ . '/vendor/workerman/workerman/Worker.php';
Yii::$classMap['Workerman\Lib\Timer'] = __DIR__ . '/vendor/workerman/workerman/Lib/Timer.php';
Yii::$classMap['Workerman\Autoloader'] = __DIR__ . '/vendor/workerman/workerman/Autoloader.php';

$application = new \yii\console\Application($config);

$users = [];

$ws_worker = new \Workerman\Worker("websocket://0.0.0.0:8765");

// 4 processes
$ws_worker->count = 1;

// Emitted when new connection come
$ws_worker->onConnect = function($connection) use (&$users)
{
    $connection->onWebSocketConnect = function($connection) use (&$users)
    {
        // при подключении нового пользователя сохраняем get-параметр, который же сами и передали со страницы сайта
        $users[] = $connection;
        // вместо get-параметра можно также использовать параметр из cookie, например $_COOKIE['PHPSESSID']
    };
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data) use (&$users)
{
    $res = ['server' => 'server-test', 'data' => $data];
    foreach ($users as $user){
        $user->send(json_encode($res));
    }
    // Send hello $data
    //$connection->send('hello ' . $data);
};

// Emitted when connection closed
$ws_worker->onClose = function($connection)
{
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();