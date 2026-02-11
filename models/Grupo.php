<?php
class Grupo {
    public $letra;
    public $selecoes = [];
    
    public function __construct($letra) {
        $this->letra = $letra;
    }
    
    public function adicionarSelecao(Selecao $selecao) {
        $this->selecoes[$selecao->id] = $selecao;
    }
    
    public function getSelecoesOrdenadas() {
        uasort($this->selecoes, function($a, $b) {
            if ($a->pontos != $b->pontos) return $b->pontos <=> $a->pontos;
            if ($a->getSaldoGols() != $b->getSaldoGols()) return $b->getSaldoGols() <=> $a->getSaldoGols();
            return $b->golsMarcados <=> $a->golsMarcados;
        });
        return $this->selecoes;
    }
}
