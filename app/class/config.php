<?php
namespace Api;

/**
 * Class Config
 * @package Api
 */
class Config {
	
  /**
   *
   * @var \Api\Config 
   */
  static protected $instance;

  /**
   *
   * @var array
   */
  protected $conf;
  
  /**
   *
   * @var \PDO
   */
  protected $pdo;

  /**
   * Return singleton
   * @return \Api\Config
   */
  public static function getInstance() {
    if ( ! self::$instance) {
      self::$instance = new Config;
    }
    return self::$instance;
  }

  /**
   * 
   */
  public function __construct() {
      $this->_loadConfFile();
  }

  /**
   * Load json config file from config directory
   * @throws \Exception
   */
  protected function _loadConfFile() {
    $confFilePath = APPLICATION_PATH . '/config/config.json';
    if ( ! file_exists($confFilePath)) {
      throw new \Exception("File $confFilePath doesn't exists");
    }
    $confFile = file_get_contents($confFilePath);
    if ($confFile === false) {
      throw new \Exception("Can't read file $confFilePath");
    }
    $conf = json_decode($confFile, true);
    if ( ! $conf) {
      throw new \Exception("Can't decode file $confFilePath");
    }
    $this->conf = $conf;
  }

  /**
   * Get list of available entities in API
   * @return type
   */
  public function getAvailableEntities() {
    return array_keys($this->conf['entities']);
  }

  /**
   * Send access to entity $entity. Possible values: post, put, get, delete
   * @param string $entity
   * @return array
   */
  public function getEntityAccess($entity) {
    return $this->conf['entities'][$entity];
  }

  /**
   * Return pdo instance
   * @return \PDO
   */
  public function getPdo() {
    if ( ! $this->pdo) {
      $db = $this->conf['db'];
      $this->pdo = new \PDO($db['dsn'], $db['username'], $db['password']);
    }
    return $this->pdo;
  }

  /**
   * Return output format (json)
   * @return string
   */
  public function getOutput() {
    return $this->conf['output'];
  }

  /**
   * Is app in debug mode?
   * @return Boolean
   */
  public function debug() {
    return (bool) $this->conf['debug'];
  }
}