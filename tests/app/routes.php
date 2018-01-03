<?php
/*
 * @author Donii Sergii <doniysa@gmail.com>
 */

/**
 * @var \sonrac\WAMP\Client
 * @var \Thruway\Session $session
 * @var \sonrac\WAMP\Client $this
 */

app()->wampRouter->addSubscriber('com.hello', function (...$arguments) {
    var_dump($arguments);
    app()->wampClient->getSession()->publish('com.test.publish', count($arguments[0]) ? $arguments[0] : [1, 2, 3]);
});

app()->wampRouter->addSubscriber('com.test.publish', function ($arguments) {
    return $arguments;
});

app()->wampRouter->addRoute('test', function () {
    return 'test_message';
});

app()->wampRouter->group([
    'namespace' => 'sonrac\\WAMP\\tests\\app'
], function () {
    app()->wampRouter->addSubscriber('wamp.test', 'WAMPController@getUserInfo');
});