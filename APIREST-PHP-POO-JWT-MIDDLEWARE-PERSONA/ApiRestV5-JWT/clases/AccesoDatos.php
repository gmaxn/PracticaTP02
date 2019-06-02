<?php
class AccesoDatos
{

    private static $ObjetoAccesoDatos;
    private $objetoPDO;
 
    private function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=utn;charset=utf8';
        $username = 'root';
        $password = '';
        $options = array (
            PDO::ATTR_EMULATE_PREPARES => false, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try 
        { 
            $this->objetoPDO = new PDO($dsn, $username, $password, $options);       
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
        } 
        catch (PDOException $e) 
        { 
            print "Error!: " . $e->getMessage(); 
            die();
        }
    }
 
    public static function dameUnObjetoAcceso()
    {
        if (!isset(self::$ObjetoAccesoDatos)) 
        {          
            self::$ObjetoAccesoDatos = new AccesoDatos(); 
        }
        return self::$ObjetoAccesoDatos;        
    }

    public function RetornarConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql); 
    } 

    public function RetornarUltimoIdInsertado()
    {
        return $this->objetoPDO->lastInsertId(); 
    }

    // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR); 
    }
    
}
?>