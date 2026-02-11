<?php
class Selecao {
    
    public $id;
    public $nome;
    public $grupo;
    public $continente;
    public $pontos = 0;
    public $vitorias = 0;
    public $empates = 0;
    public $derrotas = 0;
    public $golsMarcados = 0;
    public $golsSofridos = 0;
    
    public function __construct($nome, $grupo, $continente) {
        $this->id = uniqid();
        $this->nome = $nome;
        $this->grupo = $grupo;
        $this->continente = $continente;
    }
    
    public function getSaldoGols() {
        return $this->golsMarcados - $this->golsSofridos;
    }
     
    public function atualizarResultado($golsFeitos, $golsSofridos) {
        $this->golsMarcados += $golsFeitos;
        $this->golsSofridos += $golsSofridos;
    }
   
}
