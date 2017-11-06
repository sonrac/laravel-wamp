<?php
/**
 * @var \UnitTester $tester
 * @var \Thruway\Session $session
 * @var \sonrac\WAMP\Client $client
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */

$tester->assertInstanceOf(\sonrac\WAMP\Client::class, $client);
$tester->assertInstanceOf(\Thruway\Session::class, $session);