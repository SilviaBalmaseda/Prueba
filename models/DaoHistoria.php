<?php

require_once __DIR__ . '/../entities/Historia.php';

class DaoHistoria
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkStory($title)
    {
        $stmt = $this->db->prepare("SELECT COUNT(Titulo) AS title FROM historia WHERE Titulo = ?");
        $stmt->execute([$title]);
        $result = $stmt->fetch();
        return $result['title'];
    }

    public function createStory($titulo, $autor, $sinopsis, $imagen)
    {
        $stmt = $this->db->prepare("INSERT INTO historia (Titulo, UsuarioId, Sinopsis, Imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $autor, $sinopsis, $imagen]);
        return $this->db->lastInsertId(); // Devuelve el ID de la historia creada.
    }

    public function selecHistoria()
    {
        $stmt = $this->db->query("SELECT IdHistoria, Titulo, UsuarioId FROM historia");
        return $stmt->fetchAll();
    }

    public function selecStoryCard()
    {
        $stmt = $this->db->query("SELECT Titulo, Sinopsis, Imagen, NumFavorito FROM historia");
        return $stmt->fetchAll();
    }

    public function selecAutorStory($autor)
    {
        $stmt = $this->db->prepare("SELECT h.IdHistoria, h.Titulo, h.Sinopsis, h.Imagen
                                    FROM historia h
                                    JOIN usuario u ON h.UsuarioId = u.IdUsuario
                                    WHERE u.Nombre = ?");
        $stmt->execute([$autor]);
        return $stmt->fetchAll();
    }

    public function selecStoryId($idHistoria)
    {
        $stmt = $this->db->prepare("SELECT Titulo, Sinopsis, Imagen FROM historia WHERE IdHistoria = ?");
        $stmt->execute([$idHistoria]);
        return $stmt->fetch();
    }

    public function selecHistoriaAutor($nombre)
    {
        $stmt = $this->db->prepare("SELECT h.IdHistoria, h.Titulo, u.Nombre
                                    FROM historia h
                                    JOIN usuario u ON h.UsuarioId = u.IdUsuario
                                    WHERE h.Titulo LIKE ? OR u.Nombre LIKE ?");
        $stmt->execute(["%$nombre%", "%$nombre%"]);
        return $stmt->fetchAll();
    }

    public function selecStoryIdGenero($idGenero)
    {
        $stmt = $this->db->prepare("SELECT h.Titulo, h.Sinopsis, h.Imagen, h.NumFavorito 
                                    FROM historia h
                                    JOIN historia_genero g ON h.IdHistoria = g.HistoriaId
                                    WHERE g.GeneroId = ?");
        $stmt->execute([$idGenero]);
        return $stmt->fetchAll();
    }

    /**
     * Devuelve el número de historias que hay, puede ser en función del género.
     */
    public function selecNumHistoria($generoId)
    {
        $consulta = "SELECT COUNT(DISTINCT h.IdHistoria) AS num FROM historia h JOIN historia_genero g ON h.IdHistoria = g.HistoriaId";

        if ($generoId !== null) {
            $consulta .= " WHERE g.GeneroId = ?";
        }

        $stmt = $this->db->prepare($consulta);
        if ($generoId !== null) {
            $stmt->execute([$generoId]);
        } else {
            $stmt->execute();
        }
        $result = $stmt->fetch();
        return $result['num'];
    }

    public function updateStory($title, $sinopsis, $imagen, $idHistoria)
    {
        $stmt = $this->db->prepare("UPDATE historia SET Titulo = ?, Sinopsis = ?, Imagen = ? WHERE IdHistoria = ?");
        return $stmt->execute([$title, $sinopsis, $imagen, $idHistoria]);
    }

    public function deleteHistoria($id)
    {
        $stmt = $this->db->prepare("DELETE FROM historia WHERE IdHistoria = ?");
        return $stmt->execute([$id]);
    }
}
