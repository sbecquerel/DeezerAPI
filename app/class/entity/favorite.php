<?php
namespace Api\Entity;

/**
 * Class Entity
 * @package Entity
 */
class Favorite extends Entity {
	
  /**
   * Get entity
   * 
   * @param \Api\Request $request
   * @return mixed array|\Api\Collection
   */	
  public function get(\Api\Request $request) {
    $sql = 
      "SELECT f.*, t.name FROM `favorite` AS f " .
      "LEFT JOIN `track` AS t ON f.id_track=t.id";

    if ($request->entityId != null) {
      $sql .= " WHERE id_user=" . $this->pdo->quote($request->entityId);      
    }

    $stmt = $this->pdo->query($sql);
    if ($stmt === false) {
      throw new \Exception("Mysql Error: " . $this->pdo->errorCode());
    }

    if ( ! $stmt->rowCount()) {
      return array();
    }
    return new \Api\Collection\Stmt($stmt);
  }
}