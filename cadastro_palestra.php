<?php
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensagem = "Cadastro de palestra realizado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Grupos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Cadastrar Grupos</h1>
    </header>
    <nav>
         
        <a href="index.html">Início</a> <br>
        <a href="cadastro_participante.php">Cadastro de Participantes</a> <br>
        <a href="contato.php">Contato</a> <br>
        <a href="mapa.html">Mapa do Evento</a><br>
    
    </nav>
    <br>
    <h1>grupos de seleção</h1>
    <br>
    <div class="container">
        <?php if ($mensagem): ?>
            <p class="success"><?= $mensagem ?></p>
        <?php endif; ?>
        <form method="post">

 <label>Grupo A</label> 
            <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="México">México</option>
                <option value="África do sul ">África do Sul</option>
                <option value="Coreai do sul">Coreia do Sul</option>
                <option value="A definir">A Definir</option><br>
                </select> <br><br>


 <label>Grupo B</label> 
            <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Canadá">Canadá</option>
                <option value="A Definir ">A Definir</option>
                <option value="Catar">Catar</option>
                <option value="Súiça">Suíça</option><br>
                </select> <br><br>


<label>Grupo C</label> 
            <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Brasil">Brasil</option>
                <option value="Marrocos ">Marrocos</option>
                <option value="Haiti">Haiti</option>
                <option value="Escócia">Escócia</option><br>
                </select> <br><br>


<label>Grupo D</label>  <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Estados Unidos">Estados Unidos</option>
                <option value="Paraguai ">Paraguai</option>
                <option value="Austrália">Austrália</option>
                <option value="A definir">A definir</option><br>
                </select> <br><br>
            


<label>Grupo E</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Alemanha">Alemanha</option>
                <option value="Curaçao ">Curaçao</option>
                <option value="Costa do Marfim">Costa do Marfim</option>
                <option value="Equador">Equador</option><br>
                </select> <br><br>

<label>Grupo F</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Horlanda">Horlanda</option>
                <option value="Japão ">Japão</option>
                <option value="A definir">A definir</option>
                <option value="Tunísta">Tunísta</option><br>
                </select> <br><br>

<label>Grupo G</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Bélgica">Bélgica</option>
                <option value="Egito ">Egito</option>
                <option value="Irá">Irá</option>
                <option value="Nova Zelândia">Nova Zelândia</option><br>
                </select> <br><br>

<label>Grupo H</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Espanha">Espanha</option>
                <option value="Cabo Verde< ">Cabo Verde</option>
                <option value="Arábia Saudita">Arábia Saudita</option>
                <option value="Uruguai">Uruguai</option><br>
                </select> <br><br>

<label>Grupo I</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="França">França</option>
                <option value="Senegal< ">Senegal</option>
                <option value="A Definir">A Definir</option>
                <option value="Noruega">Noruega</option><br>
                </select> <br><br>


 <label>Grupo J</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Argentina">Argentina</option>
                <option value="Argélia< ">Argélia</option>
                <option value="Áustria">Áustria</option>
                <option value="Jordânia">Jordânia</option><br>
                </select> <br><br>

 <label>Grupo K</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Portugual">Portugual</option>
                <option value="A Definir< ">A Definir</option>
                <option value="Uzbequistão">Uzbequistão</option>
                <option value="Colômbia">Colômbia</option><br>
                </select> <br><br>

<label>Grupo L</label> 
           <select name="tipo" id="tipo" onchange="mostrarCampoExtra()" required>
                <option value="">Selecione</option>
                <option value="Inglaterra">Inglaterra</option>
                <option value="Croácia< ">Croácia</option>
                <option value="Gana">Gana</option>
                <option value="Panamá">Panamá</option><br>
                </select> <br><br>


            <label>campo</label>
            <input type="text" name="nome" required> <br>
            <label>Descrição:</label> <br>
            <textarea name="descricao" required></textarea> <br>
            <label>Palestrante:</label> <br>
            <input type="text" name="palestrante" required> <br>
            <label>Horário:</label> <br>
            <input type="time" name="horario" required> <br><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>