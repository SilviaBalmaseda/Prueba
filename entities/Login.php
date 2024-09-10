<?php
class Login
{
    private $User;
    private $Clave;
    private $Hora;
    private $Acceso;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }
}
