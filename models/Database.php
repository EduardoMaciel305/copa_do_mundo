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
            self::$instance->initData();
        }
        return self::$instance;
    }
    
    private function initData() {
        // Grupos iniciais
        $this->grupos = [
            'A' => new Grupo('A'),
            'B' => new Grupo('B'),
            'C' => new Grupo('C')
        ];
    }
}

