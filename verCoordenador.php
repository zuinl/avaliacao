<?php
set_time_limit(0);
include('meta/meta.php');
include('include/connect.php');
include('include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: todosCoordenadores.php');
    die();
}
$id = $_GET['id'];
$select = "SELECT * FROM tb_coordenador WHERE coo_id = '$id'";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$primeiroNome = utf8_encode($dados['coo_primeiro_nome']);
$nomeCompleto = utf8_encode($dados['coo_nome_completo']);
$email = $dados['coo_email'];
$descricao = utf8_encode($dados['coo_descricao']);
    if($descricao == "") $descricao = "Não informada";
$dataCadastro = $dados['coo_data_cadastro'];
$dataAlteracao = $dados['coo_data_alteracao'];
$foto = $dados['coo_foto'];
    if($foto == "" || $foto == "uploads/") $foto = "img/user.png";
$usuario = $dados['usu_id'];

$select = "SELECT user_login as login FROM tb_usuario WHERE user_id = '$usuario'";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$login = $dados['login'];

$select = "SELECT DATE_FORMAT(ac_timestamp, '%d/%m/%Y %H:%i:%s') as hora FROM tb_acesso WHERE user_id = '$usuario' ORDER BY ac_timestamp DESC LIMIT 1";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$ultimoAcesso = $dados['hora'];

$select = "SELECT prj_id as proj FROM tb_projeto_coordenador WHERE coo_id = '$id'";
$query = mysqli_query($conn, $select);
$projetos = mysqli_num_rows($query);
$profs = 0;
$turmas = 0;
$capacidade = 0;
$vagas = 0;
$alunos = 0;
while($dados = mysqli_fetch_assoc($query)) {
    $proj = $dados['proj'];
    $select = "SELECT DISTINCT t2.prof_Id as id FROM tb_turma t1 INNER JOIN tb_professorturma t2 ON t2.turma_Id = 
        t1.turma_Id WHERE t1.proj_Id = '$proj'";
    $queryProfs = mysqli_query($conn, $select);
    $profs = $profs + mysqli_num_rows($queryProfs);

    $selectTurmas = "SELECT turma_Id as id, turma_LimiteAlunos as vagas FROM tb_turma WHERE proj_Id = '$proj' AND turma_DataDesativacao > NOW()";
    $queryTurmas = mysqli_query($conn, $selectTurmas);
    $turmas = $turmas + mysqli_num_rows($queryTurmas);
    while($dadosVagas = mysqli_fetch_assoc($queryTurmas)){
        $idTurma = $dadosVagas['id'];
        $selectAlunos = mysqli_query($conn, "SELECT DISTINCT aluno_Id FROM tb_alunoturma WHERE turma_Id = '$idTurma'");
        $alunos = $alunos + mysqli_num_rows($selectAlunos);

        if($dadosVagas['vagas'] > 200) $vagasNow = 200;
        else $vagasNow = $dadosVagas['vagas'];
        $vagas = $vagas + $vagasNow;
    }
}

$userId = $_SESSION['user']['id'];
$select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
$query = mysqli_query($conn, $select);

if(mysqli_num_rows($query) > 0) {
    $isCoordenador = 1;
} else {
    $isCoordenador = 0;
}
?>
<html>
<head>
    <title><?php echo $nomeCompleto; ?></title>
</head>
<body>
<div class="container">

    <div class="row">
        <div class="col-sm-3">
            <a href="todosCoordenadores.php"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
        <div class="col-sm-4">
            <a href="mailto:<?php echo $email; ?>"><button class="button button2" style="font-size: 0.8em;">Enviar e-mail para <?php echo $primeiroNome; ?></button></a>
        </div>
    </div>

    <?php
		if(isset($_SESSION['msg'])) {
			?>
			<div class="row">
				<div class="col-sm-6 offset-sm-3">
					<div class="alert alert-info">
						<?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
					</div>
				</div>
			</div>
			<?php
		}
	?>

    <div class="row">
        <div class="col-sm-1" style="margin-right: 1.5em;">
            <img src="<?php echo $foto; ?>" width="100">
        </div>
        <div class="col-sm-5" style="margin-top: 1em;">
            <h2 class="high-text"><?php echo $nomeCompleto; ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 1em;">
            <p class="text"><b>Usuário (login):</b> <?php echo $login; ?>
            <p class="text"><b>Último acesso:</b> <?php echo $ultimoAcesso; ?>
        </div>
        <?php if($isCoordenador == 1)  { ?>
        <div class="col-sm-2" style="margin-top: 1em;">
            <a href="edtCoordenador.php?id=<?php echo $id; ?>"><button class="button button2">Editar coordenador</button></a>
        </div>
        <?php } ?>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de projetos:</b> <?php echo $projetos; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de turmas:</b> <?php echo $turmas; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de alunos:</b> <?php echo $alunos; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de professores:</b> <?php echo $profs; ?></h5>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-3">
            <h5 class="text"><b>Capacidade total:</b> <?php echo $vagas; ?> </h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Atendimentos:</b> XX </h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Déficit:</b> XX </h5>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-10 offset-2">
            <h3 class="destaque-text">Todas as turmas de <?php echo $primeiroNome; ?></h3>
        </div>
    </div>

        <table class="table-site">
			<tr>
				<th>ID</th>
				<th>Projeto</th>
				<th>Turma</th>
                <th>Local</th>
                <th>Professor</th>
                <th>Inscritos</th>
                <th>Atendimentos</th>
                <th>Frequentes</th>
                <th>Capacidade</th>
                <th>Déficit</th>
			</tr>
            <?php
            $select = "SELECT t1.prj_id, t2.turma_Id as id, t2.turma_Nome as nome, t2.turma_Dias as dias, 
            t2.turma_LimiteAlunos as vagas, t3.local_nome as local, t4.proj_Nome as proj 
            FROM tb_projeto_coordenador t1 INNER JOIN tb_turma t2 ON t2.proj_Id = t1.prj_id INNER JOIN tb_local t3 ON 
            t3.local_id = t2.local_Id INNER JOIN tb_projeto t4 ON t4.proj_Id = t2.proj_Id WHERE t1.coo_id = '$id' AND 
            t2.turma_DataDesativacao > NOW() ORDER BY t2.turma_Nome ASC";
            $query = mysqli_query($conn, $select);
            while($dados = mysqli_fetch_assoc($query)) {
                $idTurma = $dados['id'];
                $turma = utf8_encode($dados['nome']).' - '.utf8_encode($dados['dias']);
                $local = utf8_encode($dados['local']);
                $proj = utf8_encode($dados['proj']);
                $vagas = $dados['vagas'];

                $selectProf = mysqli_query($conn, "SELECT t2.prof_Nome as prof, t2.prof_Id as id FROM tb_professorturma t1 INNER JOIN 
                tb_professor t2 ON t2.prof_Id = t1.prof_Id WHERE t1.turma_Id = '$idTurma'");
                $dadosProf = mysqli_fetch_assoc($selectProf);
                $prof = utf8_encode($dadosProf['prof']);
                $idProf = $dadosProf['id'];

                $selectInscritos = mysqli_query($conn, "SELECT DISTINCT aluno_Id FROM tb_alunoturma WHERE turma_Id = '$idTurma'");
                $inscritos = mysqli_num_rows($selectInscritos);

                $deficit = 0;
            ?>
			<tr>
				<td><?php echo $idTurma; ?></td>
				<td><?php echo $proj; ?></td>
				<td><a href="../turmaChamada.php?turma=<?php echo $idTurma; ?>" target="blank_"><?php echo $turma; ?></a></td>
                <td><?php echo $local; ?></td>
                <td><a href="verProfessor.php"><?php echo $prof; ?></a></td>
                <td><?php echo $inscritos; ?></td>
                <td>XX</td>
                <td>XX</td>
                <td><?php echo $vagas; ?></td>
                <td><?php echo $deficit; ?></td>
			</tr>
            <?php } ?>
        </table>
        

        <!-- <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-10 offset-2">
            <h3 class="destaque-text">Histórico de acessos de <?php echo $primeiroNome; ?></h3>
            <small class="text">Último acesso do coordenador: <?php echo $ultimoAcesso; ?></small>
        </div>
    </div>

        <table class="table-site">
			<tr>
				<th>Data</th>
				<th>Ação</th>
			</tr>
			<tr>
				<td>12/08/2019 08:39:45</td>
				<td><a href="#" target="_blank"><button class="button button2">Ver alterações do dia</button></a></td>
			</tr>
		</table> -->

</div>
</body>
</html>