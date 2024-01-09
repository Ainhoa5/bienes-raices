<?php

namespace App;

class ActiveRecord{
    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $errores=[];


    public static function setDB($database){
        self::$db=$database;
    }
    public static function all() {
        $query = "SELECT * FROM ".static::$tabla;
        $resultado=self::consultarSQL($query);
        return $resultado; 
    }
    public function eliminar() {
        // Verifica si el objeto tiene ID
        if(!isset($this->id)) {
            self::$errores[] = "No se puede eliminar un objeto sin ID";
            return false;
        }

        // Crea la consulta SQL para eliminar
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . static::$db->escape_string($this->id) . " LIMIT 1";
        
        // Ejecuta la consulta
        $resultado = static::$db->query($query);

        return $resultado;
    }
    public function guardar(){
        //Sanitizar los datos
        $atributos=$this->sanitizarAtributos();
        //insertar en la base de datos
       

        $query = "INSERT INTO ".static::$tabla ." (";
        $query.=join(',', array_keys($atributos));
        $query.=" ) VALUES ('";
        $query.=join("' , '",array_values($atributos));
        $query.= "')";
   
      $resultado=static::$db->query($query);
      return $resultado;
       
    }
    //identifica y une los atributos de la bd con sus valores en forma de vector
    public function atributos(){
        $atributos=[];
        foreach(static::$columnasDB as $columna){
            if ($columna==='id') continue;
            $atributos[$columna]=$this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos(){
        $atributos=$this->atributos();
        $sanitizado=[];
        //este vector se recorre como asociativo
        foreach ($atributos as $key=>$value){
            $sanitizado[$key]= static::$db->escape_string($value);
        }
    
        return $sanitizado;
    }

    //Validaciones
    public static function getErrores(){
        return static::$errores;
    }
   

    public function setImagen($imagen){
        if ($imagen){
            $this->imagen=$imagen;
            
        }

    }
    public static function consultarSQL($query){
        //Consultar la base de datos
        $resultado=self::$db->query($query);
     

        //iterar los resultados
        $array=[];
        while ($registro=$resultado->fetch_assoc()){
            $array[]=self::crearObjeto($registro);

        }
    
        //liberar la memoria
        $resultado->free();
        //devolver resultados
        return $array;
    }
    protected static function crearObjeto($registro){
            $objeto=new static;
            
            foreach ($registro as $key =>$value){
        
                if (property_exists($objeto,$key)){
                    $objeto->$key=$value;

                }
            }
            return $objeto;
    }

}

?>