<?php
namespace Api\Response;

/**
 * Class Response
 * @package Response
 */
class Json extends Response {
	
  /**
   * Send header for JSON
   */
  protected function sendHeader() {
    header('content-type: application/json');
  }

  /**
   * Send array of values
   * @throws \Exception
   */
  protected function _sendCollection() {
    echo "[";
    foreach ($this->result as $key => $row) {
      if ($key) {
        echo ",";
      }
      $str = json_encode($row);  
      if ($str === false) {
        throw new \Exception("An error occured during json encoding: " . json_last_error_msg());
      }
      echo $str;
    }
    echo "]";  
  }

  /**
   * Send result
   */
  protected function sendResult() {
    if ($this->result instanceof \Api\Collection\Collection ) {
      $this->_sendCollection();
      return;
    }
    
    if ( ! count($this->result)) {
      echo "{}";
      return;
    }

    echo json_encode($this->result);    
  }
}