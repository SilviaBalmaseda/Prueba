<?php

require_once __DIR__ . '/../entities/Estado.php';

class DaoEstado
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkEstado($nameEstado)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Nombre) AS statu FROM estado WHERE Nombre = ?");
        $stmt->execute([$nameEstado]);
        $result = $stmt->fetch();
        return $result['statu'];
    }

    public function createEstado($nameGenre)
    {
        $stmt = $this->db->prepare("INSERT INTO estado (Nombre) VALUES (?)");
        return $stmt->execute([$nameGenre]);
    }

    public function selecEstado()
    {
        $stmt = $this->db->query("SELECT * FROM estado");
        return $stmt->fetchAll();
    }

    public function deleteEstado($id)
    {
        $stmt = $this->db->prepare("DELETE FROM estado WHERE IdEstado = ?");
        return $stmt->execute([$id]);
    }

    //

    public function asignarEstadoHistoria($historiaId, $estadoId) {
        $stmt = $this->db->prepare("INSERT INTO historia_estado (HistoriaId, EstadoId) VALUES (?, ?)");
        return $stmt->execute([$historiaId, $estadoId]);
    }
    
}
