<?php
require_once 'Selecao.php';

class Jogo {
    public $id;
    public $mandante;
    public $visitante;
    public $dataHora;
    public $estadio;
    public $grupoFase;
    public $golsMandante = 0;
    public $golsVisitante = 0;
    public $finalizado = false;
    
    public function __construct($mandante, $visitante, $dataHora, $estadio, $grupoFase) {
        $this->id = uniqid();
        $this->mandante = $mandante;
        $this->visitante = $visitante;
        $this->dataHora = $dataHora;
        $this->estadio = $estadio;
        $this->grupoFase = $grupoFase;
    }
    
    public function registrarResultado($golsM, $golsV) {
        $this->golsMandante = $golsM;
        $this->golsVisitante = $golsV;
        $this->finalizado = true;
        
        if ($golsM > $golsV) {
            $this->mandante->vitorias++;
            $this->mandante->pontos += 3;
            $this->visitante->derrotas++;
        } elseif ($golsM < $golsV) {
            $this->visitante->vitorias++;
            $this->visitante->pontos += 3;
            $this->mandante->derrotas++;
        } else {
            $this->mandante->empates++;
            $this->mandante->pontos++;
            $this->visitante->empates++;
            $this->visitante->pontos++;
        }
        
        $this->mandante->atualizarResultado($golsM, $golsV);
        $this->visitante->atualizarResultado($golsV, $golsM);
    }
}
