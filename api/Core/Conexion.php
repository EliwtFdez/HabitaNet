<?php
namespace Api\Core;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Conexion {
    public static function conectar() {
        // Cargar variables de entorno
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Configuracion Produccion
        $host = $_ENV['DB_HOST']; 
        $port = $_ENV['DB_PORT'] ?? '3306';
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4'; 


        // Configuración local
        // $host = 'localhost'; 
        // $port = '3306';
        // $db = 'residencias'; 
        // $user = 'root'; 
        // $pass = ''; 
        // $charset = 'utf8mb4';

        try {
            // Configuración de la conexión
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset",
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                PDO::MYSQL_ATTR_COMPRESS => true
            ];
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
            exit;
        }
    }
}
