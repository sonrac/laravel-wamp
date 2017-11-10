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
    app()->wampClient->getSession()->publish('com.test.publish', count($arguments) ? $arguments : [1, 2, 3]);
});

app()->wampRouter->addSubscriber('com.test.publish', function ($arguments) {
    var_dump($arguments);
    return 123;
});

app()->wampRouter->addRoute('test', function () {
    return 'test_message';
});
