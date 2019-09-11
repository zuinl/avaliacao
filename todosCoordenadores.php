<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');
$select = "SELECT coo_nome_completo as nome, coo_id as id, coo_foto as foto FROM tb_coordenador ORDER BY coo_nome_completo 
ASC";
$query = mysqli_query($conn, $select);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todos os coordenadores</title>
</head>
<body>
	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-6 offset-sm-1">
			<h2 class="high-text">Todos os <i><span class="destaque-text"> coordenadores</span></i> cadastrados</h2>
		</div>
		<div class="col-sm-2">
			<a href="novoCoordenador.php"><button class="button button2">Novo coordenador</button></a>
		</div>
	</div>
	
	<hr class="hr-divide">

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

	<div class="container">
		<div class="row">
			<?php
			$contador = 0;
			while($dados = mysqli_fetch_assoc($query)) {
				$id = $dados['id'];
				$nome = utf8_encode($dados['nome']);
				$foto = $dados['foto'];
					if($foto == "" || $foto == "uploads/") $foto = "img/user.png";
			?>
			<div class="col-sm-3">
				<div class="card" style="width: 15rem;">
		  			<img src="<?php echo $foto; ?>" class="card-img-top" width="100">
		  				<div class="card-body">
		    				<h5 class="high-text"><?php echo $nome; ?></h5>
		    				<a href="verCoordenador.php?id=<?php echo $id; ?>"><button class="button button1" style="font-size: 0.8em;">Ver</button></a>
		  				</div>
				</div>
			</div>
			<?php
			$contador++;
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