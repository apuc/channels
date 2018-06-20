<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 22.04.2018
 * Time: 12:32
 */

namespace console\controllers;

use Workerman\Worker;
use yii\console\Controller;

class ServerController extends Controller
{

    public $users = [];

    public function actionIndex()
    {
        // Create a Websocket server
        $ws_worker = new Worker("websocket://0.0.0.0:2324");

        // 4 processes
        $ws_worker->count = 4;

                // Emitted when new connection come
        $ws_worker->onConnect = function($connection)
        {
            echo "New connection\n";
        };

        // Emitted when data received
        $ws_worker->onMessage = function($connection, $data)
        {
            // Send hello $data
            $connection->send('hello ' . $data);
        };

        // Emitted when connection closed
        $ws_worker->onClose = function($connection)
        {
            echo "Connection closed\n";
        };

        // Run worker
        Worker::runAll();
    }

}