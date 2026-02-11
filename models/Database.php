<?php
session_start();

class Database {
    private static $instance = null;
    
    public $selecoes = [];
    public $usuarios = [];
    public $grupos = [];
    public $jogos = [];
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->load();
        }
        return self::$instance;
    }

    private function load() {
        if (isset($_SESSION['db'])) {
            $this->selecoes = $_SESSION['db']['selecoes'];
            $this->usuarios = $_SESSION['db']['usuarios'];
            $this->grupos   = $_SESSION['db']['grupos'];
            $this->jogos    = $_SESSION['db']['jogos'];
        } else {
            $this->initData();
            $this->save();
        }
    }

    public function save() {
        $_SESSION['db'] = [
            'selecoes' => $this->selecoes,
            'usuarios' => $this->usuarios,
            'grupos' => $this->grupos,
            'jogos' => $this->jogos
        ];
    }
    
    private function initData() {
        $this->grupos = [
            'A' => new Grupo('A'),
            'B' => new Grupo('B'),
            'C' => new Grupo('C')
        ];
    }
}
