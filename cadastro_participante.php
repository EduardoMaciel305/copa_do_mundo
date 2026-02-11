<?php
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensagem = "Cadastro de participante realizado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Participantes</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function mostrarCampoExtra() {
        var tipo = document.getElementById('tipo').value;
        document.getElementById('campo_rm').style.display = (tipo === 'Aluno') ? 'block' : 'none';
        document.getElementById('campo_cpf').style.display = (tipo === 'Pai' || tipo === 'Responsável') ? 'block' : 'none';
    }
    </script>
</head>
<body onload="mostrarCampoExtra()">
    <header>
        <h1>Cadastro de Participantes</h1>
    </header>
    <nav>
                 
        <a href="index.html">Início</a> <br>
        <a href="cadastro_palestra.php">Cadastro de Palestras</a> <br>
        <a href="contato.php">Contato</a> <br>
        <a href="mapa.html">Mapa do Evento</a> <br>
        
   
    <div class="container">
        <?php if ($mensagem): ?>
            <p class="success"><?= $mensagem ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Nome completo:</label> <br>
            <input type="text" name="nome" required> <br>
            <label>Idade:</label> <br>
            <input type="number" name="seleçãorepresentante," required> <br>
            <label>seleção representante</label> <br>
            <input type="text" name="cargo" required> <br>
            <label>cargo</label> <br> 
            <select name="palestra" required> <br>
                <option value="">Selecione</option>
                <option>Jogador</option>
                <option>Tecnico</option>
                <option>Arbitro</option>
                
            </select>
            <br>
            
            
            <div id="campo_rm" style="display:none;">
                <label>RM:</label>
                <input type="text" name="rm">
            </div>
            <div id="campo_cpf" style="display:none;">
                <label>CPF:</label>
                <input type="text" name="cpf">
            </div> <br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>