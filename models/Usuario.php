<?php
class Usuario {
    public $id;
    public $nome;
    public $idade;
    public $selecao;
    public $cargo;
    
    public function __construct($nome, $idade, $selecao, $cargo) {
        $this->id = uniqid();
        $this->nome = $nome;
        $this->idade = $idade;
        $this->selecao = $selecao;
        $this->cargo = $cargo;
    }
}
