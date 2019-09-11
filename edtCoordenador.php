<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');

if(!isset($_GET['id'])) {
    header('Location: todosCoordenadores.php');
    die();
}

$userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
  $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
  $query = mysqli_query($conn, $select);
  
  if(mysqli_num_rows($query) > 0) {
      $isCoordenador = 1;
  } else {
      $isCoordenador = 0;
  }

$id = $_GET['id'];
$select = "SELECT * FROM tb_coordenador WHERE coo_id = '$id'";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$primeiroNome = $dados['coo_primeiro_nome'];
$nomeCompleto = $dados['coo_nome_completo'];
$email = $dados['coo_email'];
$descricao = $dados['coo_descricao'];
$usuario = $dados['usu_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Editar <?php echo $primeiroNome; ?></title>
</head>
<body>
	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-6 offset-sm-1">
			<h2 class="high-text">Editar<i><span class="destaque-text"> <?php echo $primeiroNome; ?></span></i></h2>
		</div>
		<div class="col-sm-4">
			<a href="db_coordenador.php?deletar=true&id=<?php echo $id; ?>"><button class="button button3">Deletar <?php echo $primeiroNome; ?> do sistema</button></a>
		</div>
	</div>
	
	<hr class="hr-divide">

	<div class="container">
		<div class="row">
				<div class="col-sm-4">
					<h3 class="high-text">Informações<i><span style="color: #035682"> pessoais</span></i></h3>
				</div>
			</div>
		<form action="db_coordenador.php?atualizar=true" method="POST" id="form">
			<div class="row form-group">
				<div class="col-sm-2">
					<label for="nome">Primeiro nome</label>
					<input type="text" name="nome" id="nome" value="<?php echo $primeiroNome; ?>" maxlength="40" class="form-control form-control-sm" required="">
				</div>
				<div class="col-sm-3">
					<label for="nome">Nome completo</label>
					<input type="text" name="nomeCompleto" id="nomeCompleto" value="<?php echo $nomeCompleto; ?>" maxlength="80" class="form-control form-control-sm" required="">
				</div>
				<div class="col-sm-3">
					<label for="email">E-mail</label>
					<input type="email" name="email" id="email" value="<?php echo $email; ?>" maxlength="100" class="form-control form-control-sm">
                </div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label>Descrição</label>
					<textarea class="form-control" name="descricao"><?php echo $descricao; ?></textarea>
				</div>
				<div class="col-sm-8">
					<label for="telefone1">Projetos responsáveis</label>
					<select class="form-control" multiple="" name="projetos[]">
                        <?php
                        $select = "SELECT proj_Id as id, proj_Nome as nome FROM tb_projeto";
                        $query = mysqli_query($conn, $select);
                        while($dados = mysqli_fetch_assoc($query)) {
                            $idProj = $dados['id'];
                            $proj = utf8_encode($dados['nome']);
                            echo '<option value="'.$idProj.'">'.$proj.'</option>';
                        }
                        ?>
                    </select>
					<h6 class="text">ATENÇÃO! Selecionar projetos aqui excluirá da responsabilidade de <?php echo $primeiroNome ?> 
					todos os outros previamente atribuídos. Se não houveram alterações quanto a estas atribuições, 
					não selecione NENHUM projeto</h6>
                    <small class="text">Mantenha CTRL pressionado enquanto clica nos projetos</small>
				</div>
			</div>

			<div class="row">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="col-sm-2 offset-sm-5">
					<input type="submit" name="submit" class="button button1" value="Atualizar coordenador">
				</div>
			</div>
		</form>

		<hr class="hr-divide-light">
			
		<form action="db_coordenador.php?foto=true" method="POST" enctype="multipart/form-data">
			<div class="row form-group">
				<div class="col-sm-4">
					<label for="foto">Altere sua foto</label>
					<input type="file" name="foto" value="Carregar foto">
				</div>
				<div class="col-sm-4">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<input type="submit" name="submit1" class="button button2" value="Atualizar foto">
				</div>
			</div>
		</form>
	</div>
</body>
</html>