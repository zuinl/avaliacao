<?php
include('meta/meta.php');
include('include/navbar.php');
include('include/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lançar frequência</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>  
    <script type="text/javascript">
        $('#telefone1, #telefone2').mask('(00) 00000-0000');
       </script>
    <script type="text/javascript">
		function addFone () {
			var divTelefone2 = document.getElementById('divTelefone2');
			var telefone2 = document.getElementById('telefone2');

			if(divTelefone2.style.display == 'none') {
				divTelefone2.style.display = 'block';
			} else {
				divTelefone2.style.display = 'none';
				telefone2.value = "";
				}
			}
	</script>
</head>
<body>
	<div class="row" style="margin-top: 0.8em;">
		<div class="col-sm-6 offset-sm-1">
			<h2 class="high-text">Lançar <i><span class="destaque-text"> frequência</span></i> de turma</h2>
		</div>
	</div>
	
	<hr class="hr-divide">

	<div class="container">
		<div class="row">
				<div class="col-sm-4">
					<h3 class="high-text">Selecione a<i><span style="color: #035682"> turma</span></i></h3>
				</div>
			</div>
		<form action="" method="POST" id="form">
			<div class="row form-group">
                <div class="col-sm-12">
					<select class="form-control form-control-sm">
                        <?php
                        $select = "SELECT proj_Id as id, proj_Nome as nome FROM tb_projeto";
                        $query = mysqli_query($conn, $select);
                        while($dados = mysqli_fetch_assoc($query)) {
                            $id = $dados['id'];
                            $proj = utf8_encode($dados['nome']);
                            echo '<option value="'.$id.'">'.$proj.'</option>';
                        }
                        ?>
                    </select>
                    <small class="text">Apenas as turmas as quais você é responsável aparecem aqui</small>
				</div>
            </div>
            
            <div class="row">
				<div class="col-sm-8">
					<h3 class="high-text">Selecio o<i><span style="color: #035682"> mês</span></i> e insira os dados</h3>
				</div>
            </div>
            

			<div class="row form-group">
				<div class="col-sm-3">
                    <label>Selecione o mês</label>
					<select class="form-control">
                        <option value="null" selected="" disabled="">Selecione</option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <small class="text">Todos referentes a <?php echo date('Y'); ?></small>
				</div>
                <div class="col-sm-3">
                    <label>Atendimentos do mês</label>
                    <input type="number" class="form-control form-control-sm">
                </div>
                <div class="col-sm-3">
                    <label>Alunos frequentes</label>
                    <input type="number" class="form-control form-control-sm">
                </div>
            </div>

			<div class="row">
				<div class="col-sm-2 offset-sm-5">
					<input type="submit" name="submit" class="button button1" value="Lançar dados">
				</div>
			</div>
		</form>
	</div>
</body>
</html>