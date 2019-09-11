<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todos os professores</title>
</head>
<body>

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

	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-5 offset-sm-1">
			<h2 class="high-text">Todos os <i><span class="destaque-text"> professores</span></i> cadastrados</h2>
		</div>
		<div class="col-sm-3">
			<a href="verProfessor.php?id=" target="_blank"><button class="button button1">Nome prof, vem ver a sua</button></a>
		</div>
		<div class="col-sm-2">
			<a href="http://taubate.sp.gov.br/secretarias/seel/sistema/admin/professor.php" target="_blank"><button class="button button2">Ver no sistema</button></a>
		</div>
	</div>
	
	<hr class="hr-divide">

	<div class="container">
		<!-- <div class="row" style="margin-bottom: 1em;">
			<div class="col-sm-1 offset-sm-1">
				<h5 class="high-text">Pesquisa</h5>
			</div>
			<div class="col-sm-3">
				<input type="text" name="busca" id="busca" class="form-control form-control-sm" placeholder="Insira um nome">
			</div>
			<div class="col-sm-7">
				<h6 class="low-text">Há XX de XX gestores cadastrados</h6>
			</div>
		</div> -->
		<?php
		$select = "SELECT prof_Id as id, prof_Nome as nome, prof_Sobrenome as sobrenome, prof_CaminhoImagem as foto FROM tb_professor ORDER BY 
		prof_Nome ASC";
		$query = mysqli_query($conn, $select);
		$contador = 0;
		echo '<div class="row">';
		while($dados = mysqli_fetch_assoc($query)) {
			$contador++;
			$id = $dados['id'];
			$prof = utf8_encode($dados['nome'])." ".utf8_encode($dados['sobrenome']);
			$foto = '../'.utf8_encode($dados['foto']);
		?>
			<div class="col-sm-3">
				<div class="card" style="width: 15rem;">
		  			<img src="<?php echo $foto; ?>" class="card-img-top" width="100">
		  				<div class="card-body">
		    				<h5 class="high-text"><?php echo $prof; ?></h5>
		    				<p class="card-text">Atendimentos do mês:</p>
		    				<a href="verProfessor.php?id=<?php echo $id; ?>"><button class="button button1" style="font-size: 0.8em;">Ver</button></a>
		  				</div>
				</div>
			</div>
		<?php
			if($contador == 4) {
				echo '</div>
					<div class="row">';
			} 
		} 
		?>
		</div>
	</div>
</body>
</html>