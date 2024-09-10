<?php

require_once __DIR__ . '/../entities/Login.php';

class DaoLogin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertLogin($nameUser, $clave, $acceso)
    {
        $stmt = $this->db->prepare("INSERT INTO login (User, Clave, Hora, Acceso) VALUES (?, ?, ?, ?)");
        $hora = time();  //Cogemos la hora actual Epoch.
        return $stmt->execute([$nameUser, $clave, $hora, $acceso]);
    }

    public function deleteLogin($id)
    {
        $stmt = $this->db->prepare("DELETE FROM login WHERE User = (SELECT Nombre FROM usuario WHERE IdUsuario = ?)");
        return $stmt->execute([$id]);
    }
}
