<?php

trait Database {
    private $dsn = "mysql:host=localhost;dbname=myfirstdatabasee";
    private $dbuserName = "root";
    private $dbPassword = '';

    private function connect() {
        $pdo = new PDO($this->dsn, $this->dbuserName, $this->dbPassword);
        return $pdo;
    }

    public function query($query, $data = []) {
        $stmt = $this->connect()->prepare($query);
        $check = $stmt->execute($data);
        if($$check) {
             $reslult = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(is_array($reslult) && count($reslult)) {
                return $reslult;
             }
        } 

        return false;
    }

     public function get_row($query, $data = []) {
        $stmt = $this->connect()->prepare($query);
        $check = $stmt->execute($data);
        if($$check) {
             $reslult = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(is_array($reslult) && count($reslult)) {
                return $reslult[0];
             }
        } 

        return false;
    }
}