<?php

namespace App;

class Propiedad
{
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;

    public $vendedores_id;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'default_image.png';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }
    public static function setDB($database)
    {
        self::$db = $database;
    }
    public function crear($db)
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        //insertar en la base de datos

        $query = "INSERT INTO propiedades (";
        $query .= join(',', array_keys($atributos));
        $query .= ") VALUES (";

        $values = array_map(function ($value) {
            return "'" . addslashes((string) $value) . "'";
        }, array_values($atributos));

        $query .= join(',', $values);
        $query .= ")";
        debugear($query);
        self::$db->query($query);


    }
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id')
                continue;
            $atributos[$columna] = $this->$columna; // save key:value
        }
        return $atributos;
    }
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

}

?>