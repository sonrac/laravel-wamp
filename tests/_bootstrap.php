<?php
/**
 * Created by PhpStorm.
 *
 * @author Donii Sergii <doniysa@gmail.com>
 * Date: 10/23/17
 * Time: 4:31 PM
 */
$file = __DIR__.'/_output/database.sqlite';
if (!file_exists($file)) {
    file_put_contents($file, '');
}
