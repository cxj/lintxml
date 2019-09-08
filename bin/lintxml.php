<?php
/**
 * Checks an XML file for errors according to libxml extension.
 *
 * @package     cxj/lintxml
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2017, Chris Johnson
 * @license     MIT
 */
namespace Cxj\LintXml;


use Aura\Cli\Status;

/**
 * Find the class autoloader.
 */
$autoFile = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoFile)) {
    require_once $autoFile;
}
else {
    echo "DIR = " . __DIR__ . PHP_EOL;
    die("Cannot find autoload.php.  Does 'composer install' need to be run?\n");
}



/// MAIN
$main = new Main;
try {
    $status = $main->run();
}
catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    $status = Status::SOFTWARE;
}

exit($status);
