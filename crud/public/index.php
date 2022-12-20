<?php

use App\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$container = $app->getContainer();


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

// OBTENER TODOS LOS REGISTROS
$app->get('/getUser', function (Request $request, Response $response) {
    $sql = "SELECT * FROM user";
   
      try {
        $db = new Db();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      
        $response->getBody()->write(json_encode($user));
        return $response
          ->withHeader('content-type', 'application/json')
          ->withStatus(200);
      } catch (PDOException $e) {
        $error = array(
          "message" => $e->getMessage()
        );
    
        $response->getBody()->write(json_encode($error));
        return $response
          ->withHeader('content-type', 'application/json')
          ->withStatus(500);
      }
  });

// GUARDAR REGISTRO
$app->post('/saveUser', function (Request $request, Response $response, array $args) {
  
    $data = $request->getParsedBody();
    $name = $data["name"];
    $last_name = $data["last_name"];
    $age = $data["age"];

    $sql = "INSERT INTO user (name, last_name, age) VALUES (:name, :last_name, :age)";

    try {
      $db = new Db();
      $conn = $db->connect();

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':last_name', $last_name);
      $stmt->bindParam(':age', $age);

      $result = $stmt->execute();

      $db = null;
      $response->getBody()->write(json_encode($result));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
    );

    $response->getBody()->write(json_encode($error));
    return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
    });

// OBTENER UN REGISTRO
$app->get('/getUser/{id}', function (Request $request, Response $response, array $arg) {
    $id = $arg["id"];
    $sql = "SELECT * FROM user where id = $id";
    
    try {
      $db = new Db();
      $conn = $db->connect();
      $stmt = $conn->query($sql);
      $user = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
     
      $response->getBody()->write(json_encode($user));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
   
      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
   });

//    ELIMINAR REGISTRO
$app->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args["id"];
   
    $sql = "DELETE FROM user WHERE id = $id";
   
    try {
      $db = new Db();
      $conn = $db->connect();
     
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute();
   
      $db = null;
      $response->getBody()->write(json_encode($result));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
   
      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
   });

   //MODIFICAR REGISTRO
$app->put('/modificar/{id}', function (Request $request, Response $response, array $args) {
    $id = $args["id"];
    $data = $request->getParsedBody();
    $name = $data["name"];
    $last_name = $data["last_name"];
    $age = $data["age"];

    $sql = "UPDATE user SET name=:name, last_name=:last_name, age=:age WHERE id = $id";
 
  try {
    $db = new Db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':age', $age);

    $result = $stmt->execute();
    $db = null;

    $response->getBody()->write(json_encode($result));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  } catch (PDOException $e) {
    $error = array(
      "message" => $e->getMessage()
    );
 
    $response->getBody()->write(json_encode($error));
    return $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(500);
  }
 });

$app->run();