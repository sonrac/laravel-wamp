<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/9/17
 * Time: 6:51 PM
 */

namespace Ratchet\Client {

    use React\EventLoop\Factory as ReactFactory;
    use React\EventLoop\LoopInterface;


    if (!function_exists('Ratchet\Client\connect')) {
        function connect($url, array $subProtocols = [], $headers = [], LoopInterface $loop = null)
        {
            $loop = $loop ?: ReactFactory::create();

            $connector = new Connector($loop);
            $connection = $connector($url, $subProtocols, $headers);

            register_shutdown_function(function () use ($loop) {
                $loop->stop();
            });

            return $connection;
        }
    }
}