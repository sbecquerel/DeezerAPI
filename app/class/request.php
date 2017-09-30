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
  public $output = 'json';
  public $data;
}