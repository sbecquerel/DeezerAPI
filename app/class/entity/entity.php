<?php
namespace Api\Entity;

/**
 * Class Entity
 * @package Entity
 */
abstract class Entity {
  /**
   *
   * @var \PDOStatement
   */
  protected $pdo;

  /**
   * 
   * @param \PDO $pdo
   */
  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * Get entity
   * 
   * @param \Api\Request $request
   * @return mixed array|\Api\Collection
   */
  abstract public function get(\Api\Request $request);

  /**
   * Delete entity
   * 
   * @param \Api\Request $request
   * @return array
   * @throws \Exception
   */
  public function delete(\Api\Request $request) {
    if ( ! $request->entityId) {
      throw new \Exception("Parameter id required");
    }
    $sql = "DELETE FROM `$request->entityName` WHERE id=" . $this->pdo->quote($request->entityId);
    $stmt = $this->pdo->query($sql);
    if ($stmt === false) {
      throw new \Exception("Mysql Error: " . $this->pdo->errorCode());
    }
    return array('status' => 1);   
  }

  /**
   * Update entity
   * 
   * @param \Api\Request $request
   * @return array
   * @throws \Exception
   */
  public function put(\Api\Request $request) {
    throw new Exception('Method not implemented yet!');
  }
  
  /**
   * Create entity
   * 
   * @param \Api\Request $request
   * @return array
   * @throws \Exception
   */
  public function post(\Api\Request $request) {
    $sql = sprintf(
      "INSERT INTO $request->entityName (%s) VALUE (%s)",
      implode(', ', array_keys($request->data)),
      implode(', ', array_pad(array(), count($request->data), '?'))
    );
    $sth = $this->pdo->prepare($sql);
    if ( ! $sth->execute(array_values($request->data))) {
      throw new \Exception("Mysql Error: " . $this->pdo->errorCode());
    }
    return array('status' => 1, 'id' => $this->pdo->lastInsertId());
  }
}