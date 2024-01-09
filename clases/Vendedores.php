<?php

namespace App;

class Vendedor
{
    protected static $db;
    protected static $columnasDB = ['id', 'nombre', 'apellidos', 'telefono'];
    protected static $errores = [];

    public $id;
    public $nombre;
    public $apellidos;
    public $telefono;

    public static function getErrores()
    {
        return self::$errores;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    // ... Resto de los métodos (crear, validar, etc.), adaptados para la tabla vendedores
    public static function setDB($database)
    {
        self::$db = $database;
    }
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Construir la consulta SQL para insertar en la tabla vendedores
        $query = "INSERT INTO vendedores (";
        $query .= join(',', array_keys($atributos));
        $query .= ") VALUES (";

        $values = array_map(function ($value) {
            return "'" . self::$db->escape_string($value) . "'";
        }, array_values($atributos));

        $query .= join(',', $values);
        $query .= ")";

        // Ejecutar la consulta
        $resultado = self::$db->query($query);

        // Opcional: Devolver el ID del vendedor insertado
        // Esto puede ser útil si quieres hacer algo con el registro recién creado
        if ($resultado) {
            $this->id = self::$db->insert_id;
        }

        return $resultado;
    }
    public function validar()
{
    // Validar nombre
    if (!$this->nombre) {
        self::$errores[] = 'El nombre es obligatorio';
    }

    // Validar apellidos
    if (!$this->apellidos) {
        self::$errores[] = 'Los apellidos son obligatorios';
    }

    // Validar teléfono
    if (!$this->telefono) {
        self::$errores[] = 'El teléfono es obligatorio';
    } else {
        // Puedes agregar más validaciones aquí, como por ejemplo,
        // comprobar que el teléfono tenga un formato específico
        if (!preg_match('/^\d{10,12}$/', $this->telefono)) {
            self::$errores[] = 'El teléfono debe tener un formato válido (entre 10 y 12 dígitos)';
        }
    }

    // Devolver errores
    return self::$errores;
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

    public static function all()
    {
        $query = "SELECT * FROM vendedores";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        // Check if the query was successful
        if (!$resultado) {
            // Handle error - maybe log it and/or return an empty array
            return [];
        }

        //iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //liberar la memoria
        $resultado->free();

        //devolver resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {

            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;

            }
        }
        return $objeto;
    }
}

?>