<?php

require_once __DIR__ . '/../entities/Genero.php';

class DaoGenero
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkGenero($nameGenero)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Nombre) AS genre FROM genero WHERE Nombre = ?");
        $stmt->execute([$nameGenero]);
        $result = $stmt->fetch();
        return $result['genre'];
    }

    public function createGenero($nameGenre)
    {
        $stmt = $this->db->prepare("INSERT INTO genero (Nombre) VALUES (?)");
        return $stmt->execute([$nameGenre]);
    }

    public function selecGenero()
    {
        $stmt = $this->db->query("SELECT * FROM genero");
        return $stmt->fetchAll();
    }

    public function deleteGenero($id)
    {
        $stmt = $this->db->prepare("DELETE FROM genero WHERE IdGenero = ?");
        return $stmt->execute([$id]);
    }

    //

    public function asignarGeneroHistoria($historiaId, $generoId) {
        $stmt = $this->db->prepare("INSERT INTO historia_genero (HistoriaId, GeneroId) VALUES (?, ?)");
        return $stmt->execute([$historiaId, $generoId]);
    }   
    
    public function desasignarGeneroHistoria($historiaId, $generoId) {
        $stmt = $this->db->prepare("DELETE FROM historia_genero WHERE HistoriaId=? GeneroId=?");
        return $stmt->execute([$historiaId, $generoId]);
    } 


    // Seleccionar los géneros de esa historia.
    public function selectGenreStory($historiaId) {
        $stmt = $this->db->prepare("SELECT g.GeneroId
                                    FROM historia_genero g
                                    JOIN historia h ON g.HistoriaId = h.IdHistoria
                                    WHERE g.HistoriaId = ?");
        $stmt->execute([$historiaId]);
        return $stmt->fetchAll();
    }

}
