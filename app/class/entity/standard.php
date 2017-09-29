<?php
namespace Api\Entity;

/**
 * Class Entity
 * @package Entity
 */
class Standard extends Entity {
	
  /**
   * Get entity
   * 
   * @param \Api\Request $request
   * @return mixed array|\Api\Collection
   */	
  public function get(\Api\Request $request) {    
    $sql = "SELECT * FROM `$request->entityName`";

    if ($request->entityId != null) {
      $sql .= " WHERE id=" . $this->pdo->quote($request->entityId);
      $stmt = $this->pdo->query($sql);
      if ($stmt === false) {
        throw new \Exception("Mysql Error: " . $this->pdo->errorCode());
      }
      if ( ! $stmt->rowCount()) {
        throw new \Exception(
          sprintf("Element %s with id %d not found", $request->entityName, $request->entityId), 
          404
        );
      }
      return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    $stmt = $this->pdo->query($sql);
    if ($stmt === false) {
      throw new \Exception("Mysql Error: " . $this->pdo->errorCode());
    } 
    return new \Api\Collection\Stmt($stmt);
  }
}