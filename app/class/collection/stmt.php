<?php
namespace Api\Collection;

/**
 * Class Stmt
 * @package Collection
 */
class Stmt extends Collection {
	
  /**
   *
   * @var \PDOStatement 
   */
  protected $stmt;
  
  /**
   *
   * @var integer
   */
  protected $pos = 0;
  
  /**
   *
   * @var array
   */
  protected $current;

  /**
   * 
   * @param \PDOStatement $stmt
   */
  public function __construct(\PDOStatement $stmt) {
    $this->stmt = $stmt;
  }

  /**
   * 
   * @return array
   */
  public function current () {
    if ( ! $this->current) {
      $this->current = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT, $this->pos);
    }
    return $this->current;
  }

  /**
   * 
   * @return mixed
   */
  public function key() {
    return $this->pos;
  }

  /**
   * 
   */
  public function next() {
    $this->current = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT, ++$this->pos);
  }

  /**
   * 
   */
  public function rewind() {
    if ($this->pos === 0) {
      return;
    }
    $this->current = $this->stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT, --$this->pos);
  }

  /**
   * 
   * @return boolean
   */
  public function valid() {
    return $this->pos < $this->stmt->rowCount();
  }
  
  /**
   * 
   * @return integer
   */
  public function count() {
    return $this->stmt->rowCount();
  }
}