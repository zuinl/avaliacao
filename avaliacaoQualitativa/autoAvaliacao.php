<?php
include('../meta/meta.php');
include('../include/connect.php');
include('../include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: todosProfessores.php');
    die();
}

$id = $_GET['id'];
$nome = $_GET['nome'];

$select = "SELECT ata_id as id, DATE_FORMAT(ata_data_liberacao, '%d/%m/%Y %H:%i') as data FROM tb_autoavaliacao_qualitativa 
WHERE pro_id = '$id' AND ata_liberada = 1 AND ata_preenchida = 0";
$query = mysqli_query($conn, $select);

if(mysqli_num_rows($query) == 0) {
    echo 'Você não tem autoavaliações disponíveis para preenchimento no momento';
    die();
} else {
    $dados = mysqli_fetch_assoc($query);
    $liberada = $dados['data'];
    $ata_id = $dados['id'];
}
?>
<html>
<head>
    <title>Autoavaliação completo de <?php echo $nome;?></title>
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
            <h1 class="high-text">Autoavaliação qualitativa de <i><span class="destaque-text"><?php echo $nome;?></span></i></h1>
            <h6 class="text">Autoavaliação foi liberada para você em <?php echo $liberada; ?></h6>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-10 offset-sm-2">
            <h2 class="destaque-text">Visões de autoavaliação livre</h2>
            <h5 class="text">Esta sessão permite que você escreva livremente nos campos</h5>
        </div>
    </div>

    <form action="db_autoavaliacao.php?ata_id=<?php echo $ata_id; ?>" method="POST">
    <div class="row">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga como considera a sua saúde" name="saudeProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Diga como considera a sua vontade/determinação" name="vontadeProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você acredita na transformação do ser humano e que o esporte é um aliado?" name="transformaProf" maxlength="300"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se considera otimista?" name="otimismoProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se considera crítico?" name="criticoProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se considera engajado?" name="engajadoProf" maxlength="300"></textarea>
        </div>
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="O que você acha de sua liderança?" name="liderancaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se considera uma pessoa com boa autoestima?" name="autoestimaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se considera paciente com burocracias?" name="pacienteProf" maxlength="300"></textarea>
        </div> 
    </div>
    <div class="row" style="margin-top: 0.5em;">
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você pega as coisas para si?" name="pegarProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Você se preocupa demais e não pensa em si próprio?" name="preocupaProf" maxlength="300"></textarea>
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" placeholder="Considera ter dificuldade em ouvir os outros?" name="ouvirProf" maxlength="300"></textarea>
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
				<th>Observações</th>
			</tr>
			<tr>
				<td>Comprometimento</td>
				<td>
                    <input type="range" required=""  name="comprometimento" value="0" max="5" min="0" class="form-control" oninput="display.innerHTML=value" onchange="display.innerHTML=value">
                    <span id="display">0</span>
                </td>
				<td>
                    <input type="text" name="obsComprometimento" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Conhecimento de suas dificuldades</td>
				<td>
                    <input type="range" required=""  name="dificuldades" value="0" max="5" min="0" class="form-control" oninput="display1.innerHTML=value" onchange="display1.innerHTML=value">
                    <span id="display1">0</span>
                </td>
				<td>
                    <input type="text" name="obsDificuldades" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Reconhecimento de suas potencialidades</td>
				<td>
                    <input type="range" required=""  name="potencialidades" value="0" max="5" min="0" class="form-control" oninput="display2.innerHTML=value" onchange="display2.innerHTML=value">
                    <span id="display2">0</span>
                </td>
				<td>
                    <input type="text" name="obsPotencialidades" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Controle emocional</td>
				<td>
                    <input type="range" required=""  name="emocional" value="0" max="5" min="0" class="form-control" oninput="display3.innerHTML=value" onchange="display3.innerHTML=value">
                    <span id="display3">0</span>
                </td>
				<td>
                    <input type="text" name="obsEmocional" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Responsabilidade</td>
				<td>
                    <input type="range" required=""  name="responsabilidade" value="0" max="5" min="0" class="form-control" oninput="display4.innerHTML=value" onchange="display4.innerHTML=value">
                    <span id="display4">0</span>
                </td>
				<td>
                    <input type="text" name="obsResponsabilidade" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
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
				<th>Observações</th>
			</tr>
			<tr>
				<td>Cooperação</td>
				<td>
                    <input type="range" required=""  name="cooperacao" value="0" max="5" min="0" class="form-control" oninput="display5.innerHTML=value" onchange="display5.innerHTML=value">
                    <span id="display5">0</span>
                </td>
				<td>
                    <input type="text" name="obsCooperacao" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Diálogo com clareza</td>
				<td>
                    <input type="range" required=""  name="clareza" value="0" max="5" min="0" class="form-control" oninput="display6.innerHTML=value" onchange="display6.innerHTML=value">
                    <span id="display6">0</span>
                </td>
				<td>
                    <input type="text" name="obsClareza" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Empatia</td>
				<td>
                    <input type="range" required=""  name="empatia" value="0" max="5" min="0" class="form-control" oninput="display7.innerHTML=value" onchange="display7.innerHTML=value">
                    <span id="display7">0</span>
                </td>
				<td>
                    <input type="text" name="obsEmpatia" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Agir de forma ética</td>
				<td>
                    <input type="range" required=""  name="etica" value="0" max="5" min="0" class="form-control" oninput="display8.innerHTML=value" onchange="display8.innerHTML=value">
                    <span id="display8">0</span>
                </td>
				<td>
                    <input type="text" name="obsEtica" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Tolerância</td>
				<td>
                    <input type="range" required=""  name="tolerancia" value="0" max="5" min="0" class="form-control" oninput="display9.innerHTML=value" onchange="display9.innerHTML=value">
                    <span id="display9">0</span>
                </td>
				<td>
                    <input type="text" name="obsTolerancia" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
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
				<th>Observações</th>
			</tr>
			<tr>
				<td>Concentração</td>
				<td>
                    <input type="range" required=""  name="concentracao" value="0" max="5" min="0" class="form-control" oninput="display10.innerHTML=value" onchange="display10.innerHTML=value">
                    <span id="display10">0</span>
                </td>
				<td>
                    <input type="text" name="obsConcentracao" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Interpretação de contexto</td>
				<td>
                    <input type="range" required=""  name="contexto" value="0" max="5" min="0" class="form-control" oninput="display11.innerHTML=value" onchange="display11.innerHTML=value">
                    <span id="display11">0</span>
                </td>
				<td>
                    <input type="text" name="obsContexto" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Conhecimento metodológico institucional</td>
				<td>
                    <input type="range" required=""  name="metodologia" value="0" max="5" min="0" class="form-control" oninput="display12.innerHTML=value" onchange="display12.innerHTML=value">
                    <span id="display12">0</span>
                </td>
				<td>
                    <input type="text" name="obsMetodologia" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Amplia seu conhecimento</td>
				<td>
                    <input type="range" required=""  name="conhecimento" value="0" max="5" min="0" class="form-control" oninput="display13.innerHTML=value" onchange="display13.innerHTML=value">
                    <span id="display13">0</span>
                </td>
				<td>
                    <input type="text" name="obsConhecimento" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Compartilha suas ideias</td>
				<td>
                    <input type="range" required=""  name="ideias" value="0" max="5" min="0" class="form-control" oninput="display14.innerHTML=value" onchange="display14.innerHTML=value">
                    <span id="display14">0</span>
                </td>
				<td>
                    <input type="text" name="obsIdeias" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
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
				<th>Observações</th>
			</tr>
			<tr>
				<td>Solução de problemas</td>
				<td>
                    <input type="range" required=""  name="problemas" value="0" max="5" min="0" class="form-control" oninput="display15.innerHTML=value" onchange="display15.innerHTML=value">
                    <span id="display15">0</span>
                </td>
				<td>
                    <input type="text" name="obsProblemas" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Compartilhamento de tarefas</td>
				<td>
                    <input type="range" required=""  name="tarefas" value="0" max="5" min="0" class="form-control" oninput="display16.innerHTML=value" onchange="display16.innerHTML=value">
                    <span id="display16">0</span>
                </td>
				<td>
                    <input type="text" name="obsTarefas" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Planejamento com intencionalidade</td>
				<td>
                    <input type="range" required=""  name="intencionalidade" value="0" max="5" min="0" class="form-control" oninput="display17.innerHTML=value" onchange="display17.innerHTML=value">
                    <span id="display17">0</span>
                </td>
				<td>
                    <input type="text" name="obsIntencionalidade" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Organização</td>
				<td>
                    <input type="range" required=""  name="organizacao" value="0" max="5" min="0" class="form-control" oninput="display18.innerHTML=value" onchange="display18.innerHTML=value">
                    <span id="display18">0</span>
                </td>
				<td>
                    <input type="text" name="obsOrganizacao" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
            <tr>
				<td>Produz em grupo</td>
				<td>
                    <input type="range" required=""  name="grupo" value="0" max="5" min="0" class="form-control" oninput="display19.innerHTML=value" onchange="display19.innerHTML=value">
                    <span id="display19">0</span>
                </td>
				<td>
                    <input type="text" name="obsGrupo" class="form-control form-control-sm" placeholder="Os coordenadores poderão ver isso">
                </td>
			</tr>
        </table>

    <hr class="hr-divide">

    <!-- <div class="row">
        <div class="col-sm-12">
            <h5 class="text"><b>IMPORTANTE:</b> o professor não irá visualizar suas observações até que a Coordenação libere 
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
            <input class="button button1" style="font-size: 1.5em;" value="Salvar autoavaliação" type="submit">
        </div>
    </div>
    </form>
</div>
</body>
</html>