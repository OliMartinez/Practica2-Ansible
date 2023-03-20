<?php

class DB{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function _construct(){
        $this->host     = 'localhost';
        $this->db       = 'acceso';
        $this->user     = 'root';
        $this->password = '1234';
    }

    function connection(){

        try{
            $connection = "mysql:host=localhost; dbname=residencias";
            $options = [
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES  => false,
            ];
            $pdo = new PDO($connection,'root','1234', $options);

            return $pdo;
            
        }catch(PDOException $e){
            print_r('Error connection: '. $e->getMessage());
        }

    }
}

?>
