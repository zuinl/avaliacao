<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');

$select = "SELECT proj_Id as id, proj_Nome as nome FROM tb_projeto WHERE proj_Exibir = 1 ORDER BY proj_Nome ASC";
$query = mysqli_query($conn, $select);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todos os projetos</title>
</head>
<body>
	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-4 offset-sm-1">
			<h2 class="high-text">Todos os<i><span class="destaque-text"> projetos</span></i></h2>
        </div>
        <div class="col-sm-2">
			<a href="http://taubate.sp.gov.br/secretarias/seel/sistema/admin/subprog.php" target="_blank"><button class="button button2">Ver no sistema</button></a>
		</div>
	</div>
	
    <hr class="hr-divide">
<div class="container-fluid">
    <h6 class="text">Todos os dados são referentes ao último lançamento de atendimentos. Os dados dessa página são calculados com os números totais de informações lançadas pelos coordenadores em cada turma</h6>

		<table class="table-site">
			<tr>
				<th>Nome</th>
				<th>Atendimentos</th>
				<th>Capacidade</th>
                <th>Déficit</th>
			</tr>
			<?php
			while($dados = mysqli_fetch_assoc($query)) {
				$id = $dados['id'];
				$proj = utf8_encode($dados['nome']);

				$consultaVagas = mysqli_query($conn, "SELECT SUM(turma_LimiteAlunos) as vagas FROM tb_turma 
				WHERE proj_Id = '$id' AND turma_DataDesativacao > NOW() AND turma_LimiteAlunos < 500");
				echo mysqli_error($conn);
				$fetchVagas = mysqli_fetch_assoc($consultaVagas);
				$capacidade = $fetchVagas['vagas'];
			?>
			<tr>
				<td><?php echo $proj; ?></td>
				<td>XXX</td>
				<td><?php echo $capacidade; ?></td>
				<td>XX</td>
			</tr>
			<?php } ?>
        </table>
</div>
</body>
</html>