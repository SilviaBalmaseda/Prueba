<?php

require_once __DIR__ . '/../entities/Capitulo.php';

class DaoCapitulo
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selecNumCaps($historiaId) {
        $stmt = $this->db->prepare("SELECT COUNT(NumCapitulo) FROM capitulo WHERE HistoriaId = ?");
        $stmt->execute([$historiaId]);
        $result = $stmt->fetch();
        return $result['cap'];
    }

    public function createCapitulo($historiaId, $numCapitulo, $tituloCap, $historia)
    {
        $stmt = $this->db->prepare("INSERT INTO capitulo (HistoriaId, NumCapitulo, TituloCap, Historia) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$historiaId, $numCapitulo, $tituloCap, $historia]);
    }

    public function selecNumCapitulo($historiaId) {
        $stmt = $this->db->prepare("SELECT IdCapitulo, NumCapitulo, TituloCap FROM capitulo WHERE HistoriaId = ?");
        $stmt->execute([$historiaId]);
        return $stmt->fetchAll();
    }

    function selecCapData($historiaId)
    {
        $stmt = $this->db->prepare("SELECT c.TituloCap, c.Historia, e.EstadoId, g.GeneroId
                                    FROM capitulo c
                                    JOIN historia_estado e ON c.HistoriaId = e.HistoriaId
                                    JOIN historia_genero g ON c.HistoriaId = g.HistoriaId
                                    WHERE c.IdCapitulo = ?");
        $stmt->execute([$historiaId]);
        return $stmt->fetch();
    }
    
    public function updateCap($titleCap, $historia, $historiaId)
    {
        $stmt = $this->db->prepare("UPDATE historia SET TituloCap = ?, Historia = ? WHERE HistoriaId = ?");
        return $stmt->execute([$titleCap, $historia, $historiaId]);
    }

    // Borrar capítulo con ese id pasado.
    public function deleteCap($idCapitulo)
    {
        $stmt = $this->db->prepare("DELETE FROM capitulo WHERE IdCapitulo = ?");
        return $stmt->execute([$idCapitulo]);
    }
}
