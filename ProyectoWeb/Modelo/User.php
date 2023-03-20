<?php

include_once 'Base de datos/db.php';

class User extends DB{

    private $rol;
    private $user;

    public function userExist($user, $pass){
        $query = $this->connection()->prepare('SELECT * FROM usuario WHERE NumeroControl = :user AND Contraseña = :pass');
        $query->execute(['user' => $user, 'pass' => $pass]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user){
        $query = $this->connection()->prepare('SELECT * FROM usuario WHERE NumeroControl = :user');
        $query->execute(['user' => $user]);

        foreach ($query as $currentUser){
            $this->rol = $currentUser['Rol'];
            $this->user = $currentUser['NumeroControl'];
        }
    }

    public function getRol(){
        return $this->rol;
    }

    public function getUser(){
        return $this->user;
    }

} 

?>