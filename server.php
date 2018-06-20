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

$config = array_merge_recursive(
    require __DIR__ . '/console/config/main.php',
    require __DIR__ . '/console/config/main-local.php'
);
//print_r($config);die();
use Workerman\Lib\Timer;
use \workerman\Worker;
use yii\console;
use Yii;

Yii::$classMap['Workerman\Worker'] = __DIR__ . '/vendor/workerman/workerman/Worker.php';
Yii::$classMap['Workerman\Lib\Timer'] = __DIR__ . '/vendor/workerman/workerman/Lib/Timer.php';
Yii::$classMap['Workerman\Autoloader'] = __DIR__ . '/vendor/workerman/workerman/Autoloader.php';

$application = new \yii\console\Application($config);

$users = [];

$lastMsgTime = time();
//$lastMsgTime = 1524735747;

$ws_worker = new \Workerman\Worker("websocket://0.0.0.0:2346");

// 4 processes
$ws_worker->count = 4;

$ws_worker->onWorkerStart = function ($task) use (&$users, &$lastMsgTime) {
// 2.5 seconds
    $time_interval = 1;
    $timer_id = Timer::add($time_interval,
        function () use (&$users, &$lastMsgTime) {
            $msgs = \common\models\db\Msg::getMsgByTime($lastMsgTime);
            //var_dump($msgs);
            foreach ($users as $user) {
                $userMsg = [];
                if (!empty($msgs)) {
                    foreach ($msgs as $msg) {
                        if ($msg['from'] === $user['userId'] || $msg['to'] === $user['userId'] || in_array($msg['chatId'],
                                $user['userChats'], false)
                        ) {
                            $userMsg[] = $msg;
                        }
                    }
                    $user['connection']->send(json_encode($userMsg));
                }
            }
            $lastMsgTime = !empty($msgs) ? $msgs[count($msgs) - 1]['dt_add'] : $lastMsgTime;
        }
    );
};

// Emitted when new connection come
$ws_worker->onConnect = function ($connection) use (&$users) {
    $connection->onWebSocketConnect = function ($connection) use (&$users) {
        // при подключении нового пользователя сохраняем get-параметр, который же сами и передали со страницы сайта
        $users[$connection->id] = [
            'userId' => $_GET['user_id'],
            'userChats' => \common\models\db\Chat::getUserChats($_GET['user_id']),
            'connectionId' => $connection->id,
            'connection' => $connection,
        ];
        // вместо get-параметра можно также использовать параметр из cookie, например $_COOKIE['PHPSESSID']
    };
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function ($connection, $data) {
    // Send hello $data
    $_data = json_decode($data, true);
    if ($_data['action'] === 'sendMsg') {
        \common\models\db\Msg::sendMsg($_data);
    }
    $connection->send($data);
};

// Emitted when connection closed
$ws_worker->onClose = function ($connection) use (&$users) {
    unset($users[$connection->id]);
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();