<?php
namespace Api;

/**
 * Class Autoloader
 * @package Api
 */
class Autoloader{

    /**
     * Register autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

	/**
	 * Return class file from class name ($class). 
	 * Return false if file doesn't exists
	 * @param string $class
	 * @return boolean|string
	 */
    static function _getClassFile($class) {
      if (strpos($class, __NAMESPACE__ . '\\') === 0){
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        $classFile = 'class/' . $class . '.php';
        if (file_exists(APPLICATION_PATH . '/' . $classFile)) {
          return $classFile;
        }        
      }
      return false;
    }

	/**
	 * Check if class file exists
	 * @param string $class
	 * @return boolean
	 */
    static function classExists($class) {
      if ($class[0] === '\\') {
        $class = substr($class, 1);
      }
      return (self::_getClassFile($class) !== false);
    }

    /**
     * Load class
     * @param $class
     */
    static function autoload($class) {
      $classFile = self::_getClassFile($class);
      if ($classFile !== false) {
        require $classFile;
      }
    }

}