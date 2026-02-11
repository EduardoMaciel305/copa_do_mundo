<?php
require_once 'models/Database.php';
require_once 'models/Selecao.php';
require_once 'models/Usuario.php';
require_once 'models/Grupo.php';
require_once 'models/Jogo.php';

$db = Database::getInstance();

// Processa ações POST
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'cadastrar_selecao':
                $selecao = new Selecao($_POST['nome'], $_POST['grupo'], $_POST['continente']);
                $db->selecoes[$selecao->id] = $selecao;
                if (isset($db->grupos[$_POST['grupo']])) {
                    $db->grupos[$_POST['grupo']]->adicionarSelecao($selecao);
                }
                break;
                
            case 'cadastrar_usuario':
                $usuario = new Usuario($_POST['nome'], $_POST['idade'], $_POST['selecao'], $_POST['cargo']);
                $db->usuarios[$usuario->id] = $usuario;
                break;
                
            case 'cadastrar_grupo':
                $db->grupos[$_POST['letra']] = new Grupo($_POST['letra']);
                break;
                
            case 'cadastrar_jogo':
                $jogo = new Jogo(
                    $db->selecoes[$_POST['mandante']],
                    $db->selecoes[$_POST['visitante']],
                    $_POST['data_hora'],
                    $_POST['estadio'],
                    $_POST['grupo_fase']
                );
                $db->jogos[$jogo->id] = $jogo;
                break;
                
            case 'registrar_resultado':
                if (isset($db->jogos[$_POST['jogo_id']])) {
                    $db->jogos[$_POST['jogo_id']]->registrarResultado(
                        (int)$_POST['gols_mandante'],
                        (int)$_POST['gols_visitante']
                    );
                }
                break;
                
            case 'editar_selecao':
                if (isset($db->selecoes[$_POST['id']])) {
                    $s = $db->selecoes[$_POST['id']];
                    $s->nome = $_POST['nome'];
                    $s->grupo = $_POST['grupo'];
                    $s->continente = $_POST['continente'];
                }
                break;
                
            case 'editar_usuario':
                if (isset($db->usuarios[$_POST['id']])) {
                    $u = $db->usuarios[$_POST['id']];
                    $u->nome = $_POST['nome'];
                    $u->idade = $_POST['idade'];
                    $u->selecao = $_POST['selecao'];
                    $u->cargo = $_POST['cargo'];
                }
                break;
                
            case 'excluir_selecao':
                unset($db->selecoes[$_POST['id']]);
                break;
                
            case 'excluir_usuario':
                unset($db->usuarios[$_POST['id']]);
                break;
        }
    }
}

$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Copa </title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #323ee7, #45a049); color: white; padding: 20px; text-align: center; margin-bottom: 30px; border-radius: 10px; }
        .nav { background: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .nav a { color: #4CAF50; text-decoration: none; margin: 0 15px; font-weight: bold; padding: 8px 16px; border-radius: 5px; transition: all 0.3s; }
        .nav a:hover { background: #4CAF50; color: white; }
        .card { background: white; padding: 25px; margin-bottom: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        tr:hover { background: #f5f5f5; }
        form { display: grid; gap: 15px; max-width: 600px; }
        input, select, textarea { padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        button { background: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #45a049; }
        .btn-danger { background: #f44336; }
        .btn-danger:hover { background: #da190b; }
        .btn-edit { background: #2196F3; }
        .btn-edit:hover { background: #1976D2; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        h1 { color: #4CAF50; }
        h2 { color: #333; margin-bottom: 20px; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏆 Copa - Gerenciamento Completo</h1>
        </div>

        <div class="nav">
            <a href="?page=home">🏠 Home</a>
            <a href="?page=selecoes">⚽ Seleções</a>
            <a href="?page=usuarios">👥 Usuários</a>
            <a href="?page=grupos">📊 Grupos</a>
            <a href="?page=jogos">🎮 Jogos</a>
            <a href="?page=classificacao">🏅 Classificação</a>
        </div>

        <?php if ($page == 'home'): ?>
            <div class="card">
                <h2>📋 Resumo do Sistema</h2>
                <div class="grid">
                    <div>
                        <h3>Seleções</h3>
                        <p><strong><?= count($db->selecoes) ?></strong> cadastradas</p>
                    </div>
                    <div>
                        <h3>Usuários</h3>
                        <p><strong><?= count($db->usuarios) ?></strong> cadastrados</p>
                    </div>
                    <div>
                        <h3>Grupos</h3>
                        <p><strong><?= count($db->grupos) ?></strong> criados</p>
                    </div>
                    <div>
                        <h3>Jogos</h3>
                        <p><strong><?= count($db->jogos) ?></strong> programados</p>
                    </div>
                </div>
            </div>

        <?php elseif ($page == 'selecoes'): ?>
            <div class="card">
                <h2>⚽ Gerenciar Seleções</h2>
                
                <!-- Formulário Cadastro -->
                <form method="POST">
                    <input type="hidden" name="action" value="cadastrar_selecao">
                    <input type="text" name="nome" placeholder="Nome da Seleção" required>
                    <input type="text" name="grupo" placeholder="Grupo (A, B, C)" maxlength="1" required>
                    <select name="continente" required>
                        <option value="">Selecione Continente</option>
                        <option value="América do Sul">América do Sul</option>
                        <option value="Europa">Europa</option>
                        <option value="África">África</option>
                        <option value="Ásia">Ásia</option>
                        <option value="América do Norte">América do Norte</option>
                    </select>
                    <button type="submit">➕ Cadastrar Seleção</button>
                </form>

                <!-- Lista Seleções -->
                <?php if (!empty($db->selecoes)): ?>
                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Grupo</th>
                        <th>Continente</th>
                        <th>Pontos</th>
                        <th>V-E-D</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($db->selecoes as $id => $selecao): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($selecao->nome) ?></strong></td>
                        <td><span style="background: #4CAF50; color: white; padding: 4px 8px; border-radius: 20px;"><?= $selecao->grupo ?></span></td>
                        <td><?= htmlspecialchars($selecao->continente) ?></td>
                        <td><strong><?= $selecao->pontos ?></strong></td>
                        <td><?= $selecao->vitorias ?>-<?= $selecao->empates ?>-<?= $selecao->derrotas ?></td>
                        <td>
                            <button class="btn-edit" onclick="editarSelecao('<?= $id ?>', '<?= htmlspecialchars($selecao->nome) ?>', '<?= $selecao->grupo ?>', '<?= htmlspecialchars($selecao->continente) ?>')">✏️</button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Excluir <?= $selecao->nome ?>?')">
                                <input type="hidden" name="action" value="excluir_selecao">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                    <p>Nenhuma seleção cadastrada.</p>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'usuarios'): ?>
            <div class="card">
                <h2>👥 Gerenciar Usuários</h2>
                
                <!-- Formulário Cadastro -->
                <form method="POST">
                    <input type="hidden" name="action" value="cadastrar_usuario">
                    <input type="text" name="nome" placeholder="Nome Completo" required>
                    <input type="number" name="idade" placeholder="Idade" min="16" max="60" required>
                    <select name="selecao" required>
                        <option value="">Selecione Seleção</option>
                        <?php foreach ($db->selecoes as $id => $s): ?>
                            <option value="<?= $id ?>"><?= htmlspecialchars($s->nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="cargo" placeholder="Cargo (Jogador, Técnico, Árbitro)" required>
                    <button type="submit">➕ Cadastrar Usuário</button>
                </form>

                <!-- Lista Usuários -->
                <?php if (!empty($db->usuarios)): ?>
                <table>
                    <tr><th>Nome</th><th>Idade</th><th>Seleção</th><th>Cargo</th><th>Ações</th></tr>
                    <?php foreach ($db->usuarios as $id => $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario->nome) ?></td>
                        <td><?= $usuario->idade ?></td>
                        <td><?= isset($db->selecoes[$usuario->selecao]) ? htmlspecialchars($db->selecoes[$usuario->selecao]->nome) : 'N/D' ?></td>
                        <td><?= htmlspecialchars($usuario->cargo) ?></td>
                        <td>
                            <button class="btn-edit" onclick="editarUsuario('<?= $id ?>', '<?= htmlspecialchars($usuario->nome) ?>', '<?= $usuario->idade ?>', '<?= $usuario->selecao ?>', '<?= htmlspecialchars($usuario->cargo) ?>')">✏️</button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Excluir?')">
                                <input type="hidden" name="action" value="excluir_usuario">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                    <p>Nenhum usuário cadastrado.</p>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'grupos'): ?>
            <div class="card">
                <h2>📊 Gerenciar Grupos</h2>
                
                <!-- Formulário Criar Grupo -->
                <form method="POST" style="max-width: 300px;">
                    <input type="hidden" name="action" value="cadastrar_grupo">
                    <input type="text" name="letra" placeholder="Letra do Grupo (A,B,C)" maxlength="1" required>
                    <button type="submit">➕ Criar Grupo</button>
                </form>

                <!-- Lista Grupos -->
                <?php foreach ($db->grupos as $letra => $grupo): ?>
                    <h3>Grupo <?= $letra ?> (<?= count($grupo->selecoes) ?> seleções)</h3>
                    <?php if (!empty($grupo->selecoes)): ?>
                    <table>
                        <tr><th>Posição</th><th>Nome</th><th>Pontos</th><th>SG</th><th>GM</th></tr>
                        <?php $pos = 1; foreach($grupo->getSelecoesOrdenadas() as $selecao): ?>
                        <tr>
                            <td><?= $pos++ ?></td>
                            <td><?= htmlspecialchars($selecao->nome) ?></td>
                            <td><strong><?= $selecao->pontos ?></strong></td>
                            <td><?= $selecao->getSaldoGols() ?></td>
                            <td><?= $selecao->golsMarcados ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <p>Grupo vazio. Cadastre seleções no grupo <?= $letra ?>.</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        <?php elseif ($page == 'jogos'): ?>
            <div class="card">
                <h2>🎮 Gerenciar Jogos</h2>
                
                <!-- Formulário Cadastro Jogo -->
                <?php if (!empty($db->selecoes)): ?>
                <form method="POST">
                    <input type="hidden" name="action" value="cadastrar_jogo">
                    <select name="mandante" required>
                        <option value="">Seleção Mandante</option>
                        <?php foreach ($db->selecoes as $id => $s): ?>
                            <option value="<?= $id ?>"><?= htmlspecialchars($s->nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="visitante" required>
                        <option value="">Seleção Visitante</option>
                        <?php foreach ($db->selecoes as $id => $s): ?>
                            <option value="<?= $id ?>"><?= htmlspecialchars($s->nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="datetime-local" name="data_hora" required>
                    <input type="text" name="estadio" placeholder="Estádio" required>
                    <input type="text" name="grupo_fase" placeholder="Grupo/Fase (ex: Grupo A)" required>
                    <button type="submit">➕ Cadastrar Jogo</button>
                </form>
                <?php endif; ?>

                <!-- Lista Jogos -->
                <?php if (!empty($db->jogos)): ?>
                <table>
                    <tr>
                        <th>Mandante</th>
                        <th>Visitante</th>
                        <th>Data/Hora</th>
                        <th>Estádio</th>
                        <th>Placar</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($db->jogos as $id => $jogo): ?>
                    <tr>
                        <td><?= htmlspecialchars($jogo->mandante->nome) ?></td>
                        <td><?= htmlspecialchars($jogo->visitante->nome) ?></td>
                        <td><?= date('d/m H:i', strtotime($jogo->dataHora)) ?></td>
                        <td><?= htmlspecialchars($jogo->estadio) ?></td>
                        <td><?= $jogo->finalizado ? "{$jogo->golsMandante} x {$jogo->golsVisitante}" : '-' ?></td>
                        <td><?= $jogo->finalizado ? '✅ Finalizado' : '⏳ Agendado' ?></td>
                        <td>
                            <?php if (!$jogo->finalizado): ?>
                            <button class="btn-edit" onclick="registrarResultado('<?= $id ?>', '<?= htmlspecialchars($jogo->mandante->nome) ?>', '<?= htmlspecialchars($jogo->visitante->nome) ?>')">⚽ Resultado</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php else: ?>
                    <p>Nenhum jogo cadastrado.</p>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'classificacao'): ?>
            <div class="card">
                <h2>🏅 Classificação por Grupos</h2>
                <?php foreach ($db->grupos as $letra => $grupo): ?>
                    <?php if (!empty($grupo->selecoes)): ?>
                    <div style="margin-bottom: 40px;">
                        <h3>🏆 Grupo <?= $letra ?></h3>
                        <table>
                            <tr>
                                <th>Pos</th>
                                <th>Seleção</th>
                                <th>PT</th>
                                <th>J</th>
                                <th>V</th>
                                <th>E</th>
                                <th>D</th>
                                <th>GM</th>
                                <th>GS</th>
                                <th>SG</th>
                            </tr>
                            <?php $pos = 1; $jogos = 0;
                            foreach($grupo->getSelecoesOrdenadas() as $selecao): 
                                $jogos = $selecao->vitorias + $selecao->empates + $selecao->derrotas;
                            ?>
                            <tr>
                                <td><strong><?= $pos++ ?></strong></td>
                                <td><?= htmlspecialchars($selecao->nome) ?></td>
                                <td><strong><?= $selecao->pontos ?></strong></td>
                                <td><?= $jogos ?></td>
                                <td><?= $selecao->vitorias ?></td>
                                <td><?= $selecao->empates ?></td>
                                <td><?= $selecao->derrotas ?></td>
                                <td><?= $selecao->golsMarcados ?></td>
                                <td><?= $selecao->golsSofridos ?></td>
                                <td><?= $selecao->getSaldoGols() ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Edição Seleção -->
    <div id="modal-selecao" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000;">
        <div style="background:white; margin:100px auto; padding:30px; width:90%; max-width:500px; border-radius:10px;">
            <h3>Editar Seleção</h3>
            <form method="POST">
                <input type="hidden" name="action" value="editar_selecao" id="edit-selecao-id">
                <input type="text" name="nome" id="edit-selecao-nome" required>
                <input type="text" name="grupo" id="edit-selecao-grupo" maxlength="1" required>
                <select name="continente" id="edit-selecao-continente" required>
                    <option value="América do Sul">América do Sul</option>
                    <option value="Europa">Europa</option>
                    <option value="África">África</option>
                    <option value="Ásia">Ásia</option>
                    <option value="América do Norte">América do Norte</option>
                </select>
                <div style="margin-top:20px;">
                    <button type="submit">💾 Salvar</button>
                    <button type="button" onclick="fecharModal('modal-selecao')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edição Usuário -->
    <div id="modal-usuario" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000;">
        <div style="background:white; margin:100px auto; padding:30px; width:90%; max-width:500px; border-radius:10px;">
            <h3>Editar Usuário</h3>
            <form method="POST">
                <input type="hidden" name="action" value="editar_usuario" id="edit-usuario-id">
                <input type="text" name="nome" id="edit-usuario-nome" required>
                <input type="number" name="idade" id="edit-usuario-idade" min="16" max="60" required>
                <select name="selecao" id="edit-usuario-selecao" required>
                    <?php foreach ($db->selecoes as $id => $s): ?>
                        <option value="<?= $id ?>"><?= htmlspecialchars($s->nome) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="cargo" id="edit-usuario-cargo" required>
                <div style="margin-top:20px;">
                    <button type="submit">💾 Salvar</button>
                    <button type="button" onclick="fecharModal('modal-usuario')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Registro Resultado -->
    <div id="modal-resultado" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000;">
        <div style="background:white; margin:100px auto; padding:30px; width:90%; max-width:400px; border-radius:10px;">
            <h3>⚽ Registrar Resultado</h3>
            <form method="POST">
                <input type="hidden" name="action" value="registrar_resultado" id="jogo-id-resultado">
                <p id="jogo-info-resultado"></p>
                <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 10px; align-items: center;">
                    <input type="number" name="gols_mandante" min="0" placeholder="0" style="text-align:center; font-size:20px; font-weight:bold;">
                    <span style="font-size:24px; font-weight:bold;">X</span>
                    <input type="number" name="gols_visitante" min="0" placeholder="0" style="text-align:center; font-size:20px; font-weight:bold;">
                </div>
                <div style="margin-top:20px;">
                    <button type="submit">✅ Finalizar Jogo</button>
                    <button type="button" onclick="fecharModal('modal-resultado')">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editarSelecao(id, nome, grupo, continente) {
            document.getElementById('edit-selecao-id').value = id;
            document.getElementById('edit-selecao-nome').value = nome;
            document.getElementById('edit-selecao-grupo').value = grupo;
            document.getElementById('edit-selecao-continente').value = continente;
            document.getElementById('modal-selecao').style.display = 'block';
        }

        function editarUsuario(id, nome, idade, selecao, cargo) {
            document.getElementById('edit-usuario-id').value = id;
            document.getElementById('edit-usuario-nome').value = nome;
            document.getElementById('edit-usuario-idade').value = idade;
            document.getElementById('edit-usuario-selecao').value = selecao;
            document.getElementById('edit-usuario-cargo').value = cargo;
            document.getElementById('modal-usuario').style.display = 'block';
        }

        function registrarResultado(id, mandante, visitante) {
            document.getElementById('jogo-id-resultado').value = id;
            document.getElementById('jogo-info-resultado').innerHTML = 
                `<strong>${mandante}</strong> X <strong>${visitante}</strong>`;
            document.getElementById('modal-resultado').style.display = 'block';
        }

        function fecharModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Fechar modais clicando fora
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
]