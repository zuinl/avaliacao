<?php
include('../meta/meta.php');
include('../include/connect.php');
include('../include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: todosProfessores.php');
    die();
}

$userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
    $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
    $query = mysqli_query($conn, $select);

if(mysqli_num_rows($query) == 0) {
    echo 'Você não ter permissão para criar avaliações';
    die();
}

$id = $_GET['id'];
$nome = $_GET['nome'];

    $obsComprometimento = "";
    $obsDificuldades = "";
    $obsPotencialidades = "";
    $obsEmocional = "";
    $obsResponsabilidade = "";
    $obsCooperacao = "";
    $obsClareza = "";
    $obsEmpatia = "";
    $obsEtica = "";
    $obsTolerancia = "";
    $obsConcentracao = "";
    $obsContexto = "";
    $obsMetodologia = "";
    $obsConhecimento = "";
    $obsIdeias = "";
    $obsProblemas = "";
    $obsTarefas = "";
    $obsIntencionalidade = "";
    $obsOrganizacao = "";
    $obsGrupo = "";

$select = "SELECT * FROM tb_avaliacao_observacoes 
WHERE pro_id = '$id'";

$query = mysqli_query($conn, $select);

if(mysqli_num_rows($query) == 0) {
    $obsComprometimento .= "Sem observações";
    $obsDificuldades .= "Sem observações";
    $obsPotencialidades .= "Sem observações";
    $obsEmocional .= "Sem observações";
    $obsResponsabilidade .= "Sem observações";
    $obsCooperacao .= "Sem observações";
    $obsClareza .= "Sem observações";
    $obsEmpatia .= "Sem observações";
    $obsEtica .= "Sem observações";
    $obsTolerancia .= "Sem observações";
    $obsConcentracao .= "Sem observações";
    $obsContexto .= "Sem observações";
    $obsMetodologia .= "Sem observações";
    $obsConhecimento .= "Sem observações";
    $obsIdeias .= "Sem observações";
    $obsProblemas .= "Sem observações";
    $obsTarefas .= "Sem observações";
    $obsIntencionalidade .= "Sem observações";
    $obsOrganizacao .= "Sem observações";
    $obsGrupo .= "Sem observações";
} else {
    while($dados = mysqli_fetch_assoc($query)) {
        $obsComprometimento .= '<br>'.utf8_encode($dados['obs_comprometimento']);
        $obsDificuldades .= '<br>'.utf8_encode($dados['obs_dificuldades']);
        $obsPotencialidades .= '<br>'.utf8_encode($dados['obs_potencialidades']);
        $obsEmocional .= '<br>'.utf8_encode($dados['obs_emocional']);
        $obsResponsabilidade .= '<br>'.utf8_encode($dados['obs_responsabilidade']);
        $obsCooperacao .= '<br>'.utf8_encode($dados['obs_cooperacao']);
        $obsClareza .= '<br>'.utf8_encode($dados['obs_clareza']);
        $obsEmpatia .= '<br>'.utf8_encode($dados['obs_empatia']);
        $obsEtica .= '<br>'.utf8_encode($dados['obs_etica']);
        $obsTolerancia .= '<br>'.utf8_encode($dados['obs_tolerancia']);
        $obsConcentracao .= '<br>'.utf8_encode($dados['obs_concentracao']);
        $obsContexto .= '<br>'.utf8_encode($dados['obs_contexto']);
        $obsMetodologia .= '<br>'.utf8_encode($dados['obs_metodologia']);
        $obsConhecimento .= '<br>'.utf8_encode($dados['obs_conhecimento']);
        $obsIdeias .= '<br>'.utf8_encode($dados['obs_ideias']);
        $obsProblemas .= '<br>'.utf8_encode($dados['obs_problemas']);
        $obsTarefas .= '<br>'.utf8_encode($dados['obs_tarefas']);
        $obsIntencionalidade .= '<br>'.utf8_encode($dados['obs_intencionalidade']);
        $obsOrganizacao .= '<br>'.utf8_encode($dados['obs_organizacao']);
        $obsGrupo .= '<br>'.utf8_encode($dados['obs_grupo']);
    }
}
?>
<html>
<head>
    <title>Avaliação completo de <?php echo $nome; ?></title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-1">
            <a onclick="window.history.go(-1)" href="#"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="margin-top: 1em;">
            <h1 class="high-text">Avaliação qualitativa completa de <i><span class="destaque-text"><?php echo $nome; ?></span></i></h1>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-10 offset-sm-2">
            <h2 class="destaque-text">Visões de avaliação livre</h2>
            <h5 class="text">Esta sessão permite que você escreva livremente nos campos</h5>
        </div>
    </div>

    <form action="db_avaliacao.php" method="POST">
    <div class="row">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga como considera a saúde do(a) professor(a)" name="saudeProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga como considera a vontade do(a) professor(a)" name="vontadeProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você concorda com: o(a) professor(a) acredita na transformação do ser humano e que o esporte é um aliado" name="transformaProf" maxlength="300"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você considera o(a) professor(a) otimista" name="otimismoProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você considera o(a) professor(a) crítico" name="criticoProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você considera o(a) professor(a) engajado" name="engajadoProf" maxlength="300"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga o que você pensa sobre a liderança do(a) professor(a)" name="liderancaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga o que você pensa sobre a autoestima do(a) professor(a)" name="autoestimaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você considera o(a) professor(a) paciente com burocracias" name="pacienteProf" maxlength="300"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você considera que o(a) professor(a) pega as coisas para si" name="pegarProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você concorda que o(a) professor(a) se preocupa demais e não pensa em si próprio" name="preocupaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga se você acha que o(a) professor(a) tem dificuldade em ouvir os outros" name="ouvirProf" maxlength="300"></textarea>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-12">
            <h1 class="high-text">As próximas 4 sessões exigem que você selecione uma nota de 0 a 5 para cada linha. Você também poderá fazer obsevações sobre cada linha</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h1 class="destaque-text">1. SER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <table class="table-site">
			<tr>
				<th>Título</th>
				<th>Nota</th>
				<th>Observações para exibir</th>
                <th>Observações privadas</th>
			</tr>
			<tr>
				<td>Comprometimento</td>
				<td>
                    <input type="range" required=""  name="comprometimento" value="0" max="5" min="0" class="form-control" oninput="display.innerHTML=value" onchange="display.innerHTML=value">
                    <span id="display">0</span>
                </td>
				<td>
                    <input type="text" name="obsComprometimento" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsComprometimento; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Conhecimento de suas dificuldades</td>
				<td>
                    <input type="range" required=""  name="dificuldades" value="0" max="5" min="0" class="form-control" oninput="display1.innerHTML=value" onchange="display1.innerHTML=value">
                    <span id="display1">0</span>
                </td>
				<td>
                    <input type="text" name="obsDificuldades" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsDificuldades; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Reconhecimento de suas potencialidades</td>
				<td>
                    <input type="range" required=""  name="potencialidades" value="0" max="5" min="0" class="form-control" oninput="display2.innerHTML=value" onchange="display2.innerHTML=value">
                    <span id="display2">0</span>
                </td>
				<td>
                    <input type="text" name="obsPotencialidades" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsPotencialidades; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Controle emocional</td>
				<td>
                    <input type="range" required=""  name="emocional" value="0" max="5" min="0" class="form-control" oninput="display3.innerHTML=value" onchange="display3.innerHTML=value">
                    <span id="display3">0</span>
                </td>
				<td>
                    <input type="text" name="obsEmocional" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsEmocional; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Responsabilidade</td>
				<td>
                    <input type="range" required=""  name="responsabilidade" value="0" max="5" min="0" class="form-control" oninput="display4.innerHTML=value" onchange="display4.innerHTML=value">
                    <span id="display4">0</span>
                </td>
				<td>
                    <input type="text" name="obsResponsabilidade" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsResponsabilidade; ?></textarea>
                </td>
			</tr>
        </table>



        <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h1 class="destaque-text">2. CONVIVER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <table class="table-site">
			<tr>
				<th>Título</th>
				<th>Nota</th>
				<th>Observações para exibir</th>
                <th>Observações privadas</th>
			</tr>
			<tr>
				<td>Cooperação</td>
				<td>
                    <input type="range" required=""  name="cooperacao" value="0" max="5" min="0" class="form-control" oninput="display5.innerHTML=value" onchange="display5.innerHTML=value">
                    <span id="display5">0</span>
                </td>
				<td>
                    <input type="text" name="obsCooperacao" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsCooperacao; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Diálogo com clareza</td>
				<td>
                    <input type="range" required=""  name="clareza" value="0" max="5" min="0" class="form-control" oninput="display6.innerHTML=value" onchange="display6.innerHTML=value">
                    <span id="display6">0</span>
                </td>
				<td>
                    <input type="text" name="obsClareza" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsClareza; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Empatia</td>
				<td>
                    <input type="range" required=""  name="empatia" value="0" max="5" min="0" class="form-control" oninput="display7.innerHTML=value" onchange="display7.innerHTML=value">
                    <span id="display7">0</span>
                </td>
				<td>
                    <input type="text" name="obsEmpatia" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsEmpatia; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Agir de forma ética</td>
				<td>
                    <input type="range" required=""  name="etica" value="0" max="5" min="0" class="form-control" oninput="display8.innerHTML=value" onchange="display8.innerHTML=value">
                    <span id="display8">0</span>
                </td>
				<td>
                    <input type="text" name="obsEtica" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsEtica; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Tolerância</td>
				<td>
                    <input type="range" required=""  name="tolerancia" value="0" max="5" min="0" class="form-control" oninput="display9.innerHTML=value" onchange="display9.innerHTML=value">
                    <span id="display9">0</span>
                </td>
				<td>
                    <input type="text" name="obsTolerancia" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsTolerancia; ?></textarea>
                </td>
			</tr>
        </table>


        <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h1 class="destaque-text">3. CONHECER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <table class="table-site">
			<tr>
				<th>Título</th>
				<th>Nota</th>
				<th>Observações para exibir</th>
                <th>Observações privadas</th>
			</tr>
			<tr>
				<td>Concentração</td>
				<td>
                    <input type="range" required=""  name="concentracao" value="0" max="5" min="0" class="form-control" oninput="display10.innerHTML=value" onchange="display10.innerHTML=value">
                    <span id="display10">0</span>
                </td>
				<td>
                    <input type="text" name="obsConcentracao" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsConcentracao; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Interpretação de contexto</td>
				<td>
                    <input type="range" required=""  name="contexto" value="0" max="5" min="0" class="form-control" oninput="display11.innerHTML=value" onchange="display11.innerHTML=value">
                    <span id="display11">0</span>
                </td>
				<td>
                    <input type="text" name="obsContexto" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsContexto; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Conhecimento metodológico institucional</td>
				<td>
                    <input type="range" required=""  name="metodologia" value="0" max="5" min="0" class="form-control" oninput="display12.innerHTML=value" onchange="display12.innerHTML=value">
                    <span id="display12">0</span>
                </td>
				<td>
                    <input type="text" name="obsMetodologia" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsMetodologia; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Amplia seu conhecimento</td>
				<td>
                    <input type="range" required=""  name="conhecimento" value="0" max="5" min="0" class="form-control" oninput="display13.innerHTML=value" onchange="display13.innerHTML=value">
                    <span id="display13">0</span>
                </td>
				<td>
                    <input type="text" name="obsConhecimento" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsConhecimento; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Compartilha suas ideias</td>
				<td>
                    <input type="range" required=""  name="ideias" value="0" max="5" min="0" class="form-control" oninput="display14.innerHTML=value" onchange="display14.innerHTML=value">
                    <span id="display14">0</span>
                </td>
				<td>
                    <input type="text" name="obsIdeias" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsIdeias; ?></textarea>
                </td>
			</tr>
        </table>



        <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h1 class="destaque-text">4. FAZER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <table class="table-site">
			<tr>
				<th>Título</th>
				<th>Nota</th>
				<th>Observações para exibir</th>
                <th>Observações privadas</th>
			</tr>
			<tr>
				<td>Solução de problemas</td>
				<td>
                    <input type="range" required=""  name="problemas" value="0" max="5" min="0" class="form-control" oninput="display15.innerHTML=value" onchange="display15.innerHTML=value">
                    <span id="display15">0</span>
                </td>
				<td>
                    <input type="text" name="obsProblemas" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsProblemas; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Compartilhamento de tarefas</td>
				<td>
                    <input type="range" required=""  name="tarefas" value="0" max="5" min="0" class="form-control" oninput="display16.innerHTML=value" onchange="display16.innerHTML=value">
                    <span id="display16">0</span>
                </td>
				<td>
                    <input type="text" name="obsTarefas" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsTarefas; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Planejamento com intencionalidade</td>
				<td>
                    <input type="range" required=""  name="intencionalidade" value="0" max="5" min="0" class="form-control" oninput="display17.innerHTML=value" onchange="display17.innerHTML=value">
                    <span id="display17">0</span>
                </td>
				<td>
                    <input type="text" name="obsIntencionalidade" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsIntencionalidade; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Organização</td>
				<td>
                    <input type="range" required=""  name="organizacao" value="0" max="5" min="0" class="form-control" oninput="display18.innerHTML=value" onchange="display18.innerHTML=value">
                    <span id="display18">0</span>
                </td>
				<td>
                    <input type="text" name="obsOrganizacao" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsOrganizacao; ?></textarea>
                </td>
			</tr>
            <tr>
				<td>Produz em grupo</td>
				<td>
                    <input type="range" required=""  name="grupo" value="0" max="5" min="0" class="form-control" oninput="display19.innerHTML=value" onchange="display19.innerHTML=value">
                    <span id="display19">0</span>
                </td>
				<td>
                    <input type="text" name="obsGrupo" class="form-control form-control-sm" placeholder="Os professores poderão ver isso">
                </td>
                <td>
                    <textarea class="form-control" readonly=""><?php echo $obsIdeias; ?></textarea>
                </td>
			</tr>
        </table>

    <hr class="hr-divide">

    <!-- <div class="row">
        <div class="col-sm-12">
            <h5 class="text"><b>IMPORTANTE:</b> o(a) professor(a) não irá visualizar suas observações até que a Coordenação libere 
            <a href="tipoAvaliacao.php">aqui</a>.</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h5 class="text">Quando as avaliações forem liberadas os professores não terão acesso às elas, apenas 
            os Coordenadores para avaliação.</h5>
        </div>
    </div> -->

    <div class="row">
        <div class="col-sm-3 offset-sm-4">
        <input type="hidden" name="idProf" value="<?php echo $id;?>">
            <input class="button button1" style="font-size: 1.5em;" value="Salvar avaliação" type="submit">
        </div>
    </div>
    </form>
    
</div>
</body>
</html>