<?php
class Historia
{
    private $IdHistoria;
    private $Titulo;
    private $Autor;
    private $Sinopsis;
    private $Portada;
    private $Historia;
    private $Cod_Genero;
    private $Cod_Etiqueta;
    private $NumFavorito;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
