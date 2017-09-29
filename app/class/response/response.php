<?php
namespace Api\Response;

/**
 * Class Response
 * @package Response
 */
abstract class Response {

  /**
   *
   * @var mixed array|\Api\Collection\Collection
   */
  protected $result;

  /**
   * 
   * @param mixed array|\Api\Collection\Collection $result
   */
  public function __construct($result) {
    $this->result = $result;
  }

  /**
   * Send response
   */
  public function send() {
    $this->sendHeader();
    $this->sendResult();
  }

  /**
   * Send header
   */
  abstract protected function sendHeader();
  
  /**
   * Send result
   */
  abstract protected function sendResult();
}