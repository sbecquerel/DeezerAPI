<?php
namespace Api;

/**
 * Class Application
 * @package Api
 */
class Application {

  /**
   * Return request object
   * Expected request format: /[entityName]/[entityId: optional]
   * @return \Api\Request
   */
  protected function getRequest() {
    if ( ! isset($_GET['params'])) {
      throw new \Exception('No parameters found in request');
    }
    $params = array($_SERVER['REQUEST_METHOD']);
    $params = array_merge($params, explode('/', $_GET['params']));
    // Request contructor args: method, entity name and entity id
    $request = new Request(...$params);
    // If POST or PUT request, store data in request object
    if ($request->method === 'POST') {
      $request->data = $_POST;
    } else if ($request->method === 'PUT') {
      parse_str(file_get_contents("php://input"), $putVars);
      $request->data = $putVars;
    }
    return $request;
  }

  /**
   * Handle request and send response   
   */
  public function handleRequest() {
    try {
      // Get configuration singletong
      $conf = Config::getInstance();

      // Get request wrapper
      $request = $this->getRequest();

      // Is known entity ? Check it thru configuration file, entry entities.
      if ( ! in_array($request->entityName, $conf->getAvailableEntities())) {
        throw new \Exception("Entity \"$request->entityName\" unknown");
      }

      // Method to lower case, used later to call corresponding entity function
      $method = strtolower($request->method);
      // Check if method is authorized for entity.
      if ( ! in_array($method, $conf->getEntityAccess($request->entityName))) {
        throw new \Exception("Forbidden access", 403);
      }

      // Get specific entity class according to entity name. If not found, 
      // use standard class.
      $entityClass = "\\Api\\Entity\\" . ucFirst($request->entityName);
      if ( ! \Api\Autoloader::classExists($entityClass)) {
        $entityClass = "\\Api\\Entity\\Standard";
      }

      // Instantiate entity and call method 
      $entity = new $entityClass($conf->getPdo());
      $result = $entity->{$method}($request);

      // Prepare response, get configuration output value to determine 
      // which response class to instantiate.
      $responseObj = "\\Api\\Response\\" . ucfirst(strval($conf->getOutput()));
      $response = new $responseObj($result);
      
      // Send response
      $response->send();

    } catch (\Exception $e) {
      // Handle exceptions, use code to identify HTTP error code.
      switch ($e->getCode()) {
        case 403:
          header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbidden", true, 403);
          break;
        case 404:
          header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found", true, 404);
          break;
        case 500:
        default:
          header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error", true, 500);
      }
      if (isset($conf) && $conf->debug()) {
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
      }      
    }    
  }
}

