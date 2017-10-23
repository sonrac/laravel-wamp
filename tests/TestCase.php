<?php
/**
 * Created by PhpStorm.
 * User: conci
 * Date: 10/20/17
 * Time: 5:19 PM
 */

namespace Tests;

use Laravel\Lumen\Testing\TestCase as LumenTestCase;

class TestCase extends LumenTestCase
{
    /**
     * {@inheritdoc}
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function setUp()
    {
        parent::setUp();
    }
}