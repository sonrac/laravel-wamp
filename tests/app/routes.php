<?php
/*
 * @author Donii Sergii <doniysa@gmail.com>
 */

/**
 * @var \sonrac\WAMP\Client $client
 * @var \Thruway\Session $session
 * @var \sonrac\WAMP\Client $this
 *
 */

app()->wampRouter->addSubscriber('com.hello', function (\Thruway\ClientSession $clientSession, \sonrac\WAMP\Client $client) {
    $clientSession->publish('com.test.publish', [1,2,3]);
});

app()->wampRouter->addSubscriber('com.test.publish', function (\Thruway\ClientSession $clientSession, \sonrac\WAMP\Client $client) {
    return 123;
});


app()->wampRouter->addRoute('test', function () {
    return 'test_message';
});