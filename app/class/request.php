<?php
namespace Api;

/**
 * Class Request
 * @package Api
 */
class Request {
  public $method;
  public $entityName;
  public $entityId;
  public $data;

  /**
   * 
   * @param string $method (PUT, DELETE, POST, GET)
   * @param string $entityName
   * @param integer $entityId
   */
  public function __construct($method, $entityName, $entityId = null) {
    $this->method = $method;
    $this->entityName = $entityName;
    $this->entityId = (int) $entityId;
  }
}