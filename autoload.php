<?php
/**
 * Created by PhpStorm.
 * User: Jacob
 * Date: 2/6/2018
 * Time: 9:23 PM
 */

define("CLASSES_DIR", $_SERVER["DOCUMENT_ROOT"] . "/" . AutoLoader::PROJECT_DIR() . "classes/");
define("ENTITIES_DIR", $_SERVER["DOCUMENT_ROOT"] . "/" . AutoLoader::PROJECT_DIR() . "classes/entities/");
define("TMP_DIR", $_SERVER["DOCUMENT_ROOT"] . "/../tmp/");
define("SECURE_DIR", $_SERVER["DOCUMENT_ROOT"] . "/../secure/");

/**
 * Originally written by ircmaxell (2010/07/21)
 * http://stackoverflow.com/a/3300138
 *
 * Modified for project use.
 *
 * Class AutoLoader
 */
class AutoLoader
{
    private const PROJECT_DIR = "mycollege" . DIRECTORY_SEPARATOR;
    private const PROJECT_DIR_MAC = "";

    protected static $paths = [
        CLASSES_DIR,
        ENTITIES_DIR
    ];

    public static function PROJECT_DIR()
    {
        $OS_WIN = strtoupper(substr(php_uname("s"), 0, 3)) === "WIN";
        return ($OS_WIN ? AutoLoader::PROJECT_DIR : AutoLoader::PROJECT_DIR_MAC);
    }

    public static function addPath($path)
    {
        $path = realpath($path);
        if ($path) {
            self::$paths[] = $path;
        }
    }

    public static function load($class)
    {
        $classPath = $class . ".php"; // Do whatever logic here
        foreach (self::$paths as $path) {
            if (is_file($path . $classPath)) {
                require_once $path . $classPath;
                return;
            }
        }
    }
}

spl_autoload_register(array("AutoLoader", "load"));

require $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . AutoLoader::PROJECT_DIR() . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";