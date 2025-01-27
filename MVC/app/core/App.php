<?php

class App {
    public $Controller = 'Home';
    public $method = 'index';
    function splitURL() {
        $URL = $_GET['url'] ?? 'Home';
        $URL = explode('/', trim($URL,'/'));
        return $URL;
    }

    function loadController() {
        $URL = $this->splitURL();
        $fileName = "../app/controllers/" . ucfirst($URL[0]) . '.php';
        if(file_exists($fileName)) {
            require $fileName;
            $this->Controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            require "../app/controllers/_404.php";
            $this->Controller = '_404';
        }
        $Controller = new $this->Controller;
        if(!empty($URL[1])) {
            if(method_exists($Controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        call_user_func_array([$Controller,$this->method], $URL);
    }
}