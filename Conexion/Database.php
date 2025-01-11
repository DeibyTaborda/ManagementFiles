<?php
class Conexion {
    private static $instance = null; // Variable estática para la instancia única
    private $pdo;
    private $database = 'managementfiles';
    private $user = 'root';
    private $password = '';

     // El constructor está privado para evitar que se pueda crear una instancia directamente
    private function __contructor() {
        $this->pdo = new PDO("mysql:host=localhost;db_name=$database", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Método estático para acceder a la única instancia de la clase
    public static function getConexion() {
        if (self::$instance === null) {
            self::$instance = new Conexion; // Crear la instancia si no existe
        }

        return self::$instance; // Devolver la conexión existente
    }

    // Evitar la clonación de la instancia
    private function clone() {}
}