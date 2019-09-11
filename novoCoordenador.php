<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');

$userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
  $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
  $query = mysqli_query($conn, $select);
  
  if(mysqli_num_rows($query) > 0) {
      $isCoordenador = 1;
  } else {
      $isCoordenador = 0;
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cadastrar Gestor</title>
</head>
<body>
	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-6 offset-sm-1">
			<h2 class="high-text">Cadastro de<i><span class="destaque-text"> novo</span></i> coordenador</h2>
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
	<hr class="hr-divide"> 

	<div class="container">
		<div class="row">
				<div class="col-sm-4">
					<h3 class="high-text">Informações<i><span style="color: #035682"> pessoais</span></i></h3>
				</div>
			</div>
		<form action="db_coordenador.php?cadastrar=true" method="POST" id="form" enctype="multipart/form-data">
			<div class="row form-group">
				<div class="col-sm-2">
					<label for="nome">Primeiro nome</label>
					<input type="text" name="nome" id="nome" maxlength="45" class="form-control form-control-sm" required="">
				</div>
				<div class="col-sm-3">
					<label for="nome">Sobrenome</label>
					<input type="text" name="sobrenome" id="sobrenome" maxlength="35" class="form-control form-control-sm" required="">
				</div>
				<div class="col-sm-3">
					<label for="email">E-mail</label>
					<input type="email" name="email" id="email" maxlength="100" class="form-control form-control-sm">
                </div>
                <div class="col-sm-4">
					<label for="telefone1">Projetos responsável</label>
					<select class="form-control" name="projetos[]" multiple="" rows="6">
                        <?php
                        $select = "SELECT proj_Id as id, proj_Nome as nome FROM tb_projeto";
                        $query = mysqli_query($conn, $select);
                        while($dados = mysqli_fetch_assoc($query)) {
                            $id = $dados['id'];
                            $proj = $dados['nome'];
                            echo '<option value="'.$id.'">'.$proj.'</option>';
                        }
                        ?>
                    </select>
                    <small class="text">Mantenha CTRL pressionado enquanto clica nos projetos</small>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
				<label for="telefone1">Qual usuário você usa pra logar?</label>
					<select class="form-control" name="usuario">
                        <?php
                        $select = "SELECT user_id as id, user_login as login FROM tb_usuario ORDER BY user_login ASC";
                        $query = mysqli_query($conn, $select);
                        while($dados = mysqli_fetch_assoc($query)) {
                            $id = $dados['id'];
                            $login = $dados['login'];
                            echo '<option value="'.$id.'">'.$login.'</option>';
                        }
                        ?>
                    </select>
				</div>
				<div class="col-sm-4">
					<label>Descrição breve (opcional)</label>
					<textarea class="form-control" name="descricao" maxlength="300"></textarea>
				</div>
				<div class="col-sm-4">
					<label for="foto">Foto</label>
					<input type="file" name="foto" value="Carregar foto">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 offset-sm-5">
					<input type="submit" name="submit" class="button button1" value="Cadastrar coordenador">
				</div>
			</div>
		</form>
	</div>
</body>
</html>