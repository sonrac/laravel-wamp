<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/9/17
 * Time: 6:56 PM
 */

$content = file_get_contents($file = __DIR__.'/../vendor/autoload.php');

file_put_contents($file, str_replace('<?php', "<?php\n\n\nrequire __DIR__.'/../tests/helper.php';", $content));
