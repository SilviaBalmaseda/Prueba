<?php

require_once __DIR__ . '/../entities/Usuario.php';

class DaoUsuario
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUser($nameUser, $clave, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO usuario (Nombre, Clave, Email) VALUES (?, ?, ?)");
        return $stmt->execute([$nameUser, $clave, $email]);
    }

    public function checkSession($nameUser, $clave)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS userPass FROM usuario WHERE Nombre = ? AND Clave = ?");
        $stmt->execute([$nameUser, $clave]);
        $result = $stmt->fetch();
        return $result['userPass'];
    }

    public function checkUser($nameUser)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Nombre) AS user FROM usuario WHERE Nombre = ?");
        $stmt->execute([$nameUser]);
        $result = $stmt->fetch();
        return $result['user'];
    }

    // Seleccionar todos los nombres de usuarios(menos admin) que contengan el nombre pasado.
    public function selecUsuario($nombre)
    {
        $stmt = $this->db->prepare("SELECT IdUsuario, Nombre FROM usuario WHERE Nombre LIKE ? AND IdUsuario != 1");
        $stmt->execute(["%$nombre%"]);
        return $stmt->fetchAll();
    }

    public function selecUserData()
    {
        $stmt = $this->db->query("SELECT IdUsuario, Nombre FROM usuario");
        return $stmt->fetchAll();
    }

    public function selecUserId($autor)
    {
        $stmt = $this->db->prepare("SELECT IdUsuario FROM usuario WHERE Nombre = ?");
        $stmt->execute([$autor]);
        // Obtén el resultado
        $result = $stmt->fetchColumn();

        // Retorna el ID del usuario
        return $result;
    }

    public function deleteUser($idUser)
    {
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE IdUsuario = ?");
        return $stmt->execute([$idUser]);
    }
}
