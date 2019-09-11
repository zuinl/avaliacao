<?php

include('meta/meta.php');
include('include/connect.php');
include('include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: todosProfessores.php');
    die();
}
$id = $_GET['id'];
$select = "SELECT * FROM tb_professor WHERE prof_Id = '$id'";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$nome = utf8_encode($dados['prof_Nome']);
$nomeC = $nome.' '.utf8_encode($dados['prof_Sobrenome']);
$email = utf8_encode($dados['prof_Email']);
$atribuicao = $dados['prof_Atribuicao'];
$planejamento = $dados['prof_Planejamento'];
$deslocamento = $dados['prof_Deslocamento'];
$foto = '../'.$dados['prof_CaminhoImagem'];

$select = "SELECT user_login as login, user_id as idUser, prof_Id as idProf FROM tb_usuario WHERE prof_Id = '$id'";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);

    if($dados['idProf'] == 0) {
        $_SESSION['msg'] = "O professor selecionado não tem turmas válidas";
        header('Location: todosProfessores.php');
        mysqli_close($conn);
        die();
    }

$login = $dados['login'];
$usuario = $dados['idUser'];


$select = "SELECT DATE_FORMAT(ac_timestamp, '%d/%m/%Y %H:%i:%s') as hora FROM tb_acesso WHERE user_id = '$usuario' ORDER BY ac_timestamp DESC LIMIT 1";
$query = mysqli_query($conn, $select);
$dados = mysqli_fetch_assoc($query);
$ultimoAcesso = $dados['hora'];

$select = "SELECT DISTINCT turma_Id as id FROM tb_professorturma WHERE prof_Id = '$id'";
$query = mysqli_query($conn, $select);
$turmas = mysqli_num_rows($query);
$alunos = 0;
$capacidade = 0;
    while($dados1 = mysqli_fetch_assoc($query)) {
        $idTurma = $dados1['id'];

        $select1 = mysqli_query($conn, "SELECT DISTINCT aluno_Id FROM tb_alunoturma WHERE turma_Id = '$idTurma'");
        $alunos = $alunos + mysqli_num_rows($select1);

        $select2 = mysqli_query($conn, "SELECT turma_LimiteAlunos as vagas FROM tb_turma WHERE turma_Id = '$idTurma'");
        $fetchVagas = mysqli_fetch_assoc($select2);
        if($fetchVagas['vagas'] < 500) {
            $capacidade = $capacidade + $fetchVagas['vagas'];
        }
    }

$select = "SELECT DISTINCT t2.proj_Id FROM tb_professorturma t1 INNER JOIN tb_turma t2 ON t2.turma_Id = t1.turma_Id 
WHERE t1.prof_Id = '$id'";
$query = mysqli_query($conn, $select);
$projetos = mysqli_num_rows($query);

$select = "SELECT DISTINCT t2.local_Id FROM tb_professorturma t1 INNER JOIN tb_turma t2 ON t2.turma_Id = t1.turma_Id 
WHERE t1.prof_Id = '$id'";
$query = mysqli_query($conn, $select);
$locais = mysqli_num_rows($query);

$mes = date('m');
    if($mes == "01") $mes = "janeiro";
    else if ($mes == "02") $mes = "fevereiro";
    else if ($mes == "03") $mes = "março";
    else if ($mes == "04") $mes = "abril";
    else if ($mes == "05") $mes = "maio";
    else if ($mes == "06") $mes = "junho";
    else if ($mes == "07") $mes = "julho";
    else if ($mes == "08") $mes = "agosto";
    else if ($mes == "09") $mes = "setembro";
    else if ($mes == "10") $mes = "outubro";
    else if ($mes == "11") $mes = "novembro";
    else if ($mes == "12") $mes = "dezembro";
?>
<html>
<head>
    <title><?php echo $nomeC; ?></title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Atendimentos', 'Déficit'],
          ['fevereiro',  1000,      400],
          ['março',  1000,      400],
          ['abril',  1000,      400],
          ['maio',  1000,      400],
          ['junho',  1170,      460],
          ['julho',  660,       1120],
          ['agosto',  1000,      400]
        ]);

        var options = {
          title: 'Histórico de atendimentos',
          hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <script>
        function mostraMes() {
            var btn = document.getElementById('btnGraficoMes');
            if(document.getElementById('graficoMes').style.display == 'none') {
                document.getElementById('graficoMes').style.display = 'block';
                btn.value = 'Ocultar gráficos do mês';
            } else {
                document.getElementById('graficoMes').style.display = 'none';
                btn.value = 'Mostrar gráficos do mês';
            }
        }
        function CriaRequest() {
            try{
                request = new XMLHttpRequest();        
            }
            catch (IEAtual) {
                try{
                    request = new ActiveXObject("Msxml2.XMLHTTP");       
                }
                catch(IEAntigo){
                    try{
                        request = new ActiveXObject("Microsoft.XMLHTTP");          
                    }
                    catch(falha){
                    request = false;
                    }
                }
            }
      
            if (!request) 
                alert("Seu Navegador não suporta Ajax!");
            else
                return request;
        }
        function filtraTurma() {
            var idTurma = document.getElementById("idTurma").value;
            var resposta = document.getElementById("resposta");
            var xmlreq = CriaRequest();
            resposta.innerHTML = '<h5 class="high-text">Buscando dados...</h5>';
            xmlreq.open("GET", "include/filtraTurma.php?id=" + idTurma, true);
            xmlreq.onreadystatechange = function(){
                if (xmlreq.readyState == 4) {
                    if (xmlreq.status == 200) {
                        resposta.innerHTML = xmlreq.responseText;
                    }
                    else{
                        resposta.innerHTML = "Erro: " + xmlreq.statusText;
                    }
                }
            };
            xmlreq.send(null);
        }
      </script>
</head>
<body>
<div class="container-fluid">

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
        <div class="col-sm-1">
            <a href="todosProfessores.php"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
        <div class="col-sm-3">
            <a href="../professorCadastro.php?id=<?php echo $id; ?>" target="_blank"><button class="button button2" style="font-size: 0.8em;">Editar <?php echo $nome; ?></button></a>
        </div>
        <div class="col-sm-2">
            <a href="mailto:<?php echo $email; ?>"><button class="button button2" style="font-size: 0.8em;">Enviar e-mail</button></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-1" style="margin-right: 1.5em;">
            <img src="<?php echo $foto; ?>" width="100">
        </div>
        <div class="col-sm-5" style="margin-top: 1em;">
            <h2 class="high-text"><?php echo $nomeC; ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 1em;">
            <p class="text"><b>Usuário (login): </b><?php echo $login; ?>
            <p class="text"><b>Último acesso: </b><?php echo $ultimoAcesso; ?>
        </div>
        <div class="col-sm-2" style="margin-top: 1em;">
            <a href="avaliacaoQualitativa/tipoAvaliacao.php?id=<?php echo $id;?>&nome=<?php echo $nome;?>"><button class="button button1">Ver avaliações qualitativas</button></a>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de turmas: </b> <?php echo $turmas; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de alunos: </b> <?php echo $alunos; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de locais: </b> <?php echo $locais; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Quantidade de projetos: </b> <?php echo $projetos; ?></h5>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-2">
            <h5 class="text"><b><u>ATRIBUIÇÕES</u></b></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Total: </b><?php echo $atribuicao; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Planejamento: </b><?php echo $planejamento; ?></h5>
        </div>
        <div class="col-sm-3">
            <h5 class="text"><b>Deslocamento: </b><?php echo $deslocamento; ?></h5>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-4 offset-2">
            <h3 class="destaque-text">Mês atual: <?php echo $mes; ?> de <?php echo date('Y'); ?></h3>
        </div>
        <div class="col-sm-3">
            <input type="button" id="btnGraficoMes" value="Mostrar gráficos do mês" class="button button3" onclick="mostraMes();">
        </div>
    </div>
      
    <div id="graficoMes" style="display: none;">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="text"><b>Atendimentos do mês: </b>XX atendimentos (lançados por Coordenador em XX/XX/XXXX)</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5">
                <h5 class="text"><b>Capacidade total (vagas somadas): </b> <?php echo $capacidade; ?></h5>
            </div>
            <div class="col-sm-3">
                <h5 class="text"><b>Déficit: </b>XX </h5>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10">
                <div id="chart_div" style="width: 100%; height: 200px;"></div>
            </div>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-10 offset-2">
            <h3 class="destaque-text">Filtre pelas <?php echo $turmas; ?> turmas</h3>
        </div>
    </div>

    <div class="row">
      <div class="col-sm-4 offset-4">
        <select name="idTurma" id="idTurma" class="form-control form-control-sm">
            <?php
            $select = mysqli_query($conn, "SELECT t2.turma_Nome as nome, t2.turma_Dias as dias, t2.turma_Id as id, 
            t3.local_nome as local FROM tb_professorturma t1 INNER JOIN tb_turma t2 ON t2.turma_Id = t1.turma_Id 
            INNER JOIN tb_local t3 ON t3.local_id = t2.local_Id WHERE t1.prof_Id = '$id' ORDER BY t2.turma_Nome ASC");
            
            while($dados = mysqli_fetch_assoc($select)) {
                $turma = utf8_encode($dados['nome']).' - '.utf8_encode($dados['dias']).' - '.utf8_encode($dados['local']);
                $idTurma = $dados['id'];
                ?>
                <option value="<?php echo $idTurma;?>"><?php echo $turma;?></option>
                <?php
            }
            ?>
        </select>
      </div>
      <div class="col-sm-2">
            <input type="button" class="button button2" style="font-size: 0.8em;" value="Mostrar" onclick="filtraTurma();">
      </div>
    </div>

    <div id="resposta"></div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-10 offset-2">
            <h3 class="destaque-text">Todas as turmas de <?php echo $nome;?></h3>
        </div>
    </div>

        <table class="table-site">
			<tr>
				<th>ID</th>
				<th>Projeto</th>
				<th>Turma (clique para ir ao sistema)</th>
				<th>Local</th>
                <th>Vigência</th>
                <th>Inscritos</th>
                <th>Atendimentos (<?php echo $mes;?>)</th>
                <th>Frequentes</th>
                <th>Capacidade</th>
                <th>Déficit</th>
			</tr>
            <?php
            $select = mysqli_query($conn, "SELECT t2.turma_Nome as nome, t2.turma_Dias as dias, t2.turma_Id as id, 
            DATE_FORMAT(t2.turma_DataDesativacao, '%d/%m/%Y') as desativacao, t2.turma_DataDesativacao as dataDesativacao, 
            t3.local_nome as local, t4.proj_Nome as proj, t2.turma_LimiteAlunos as vagas 
            FROM tb_professorturma t1 INNER JOIN tb_turma t2 ON t2.turma_Id = t1.turma_Id 
            INNER JOIN tb_local t3 ON t3.local_id = t2.local_Id INNER JOIN tb_projeto t4 ON t4.proj_Id = t2.proj_Id 
            WHERE t1.prof_Id = '$id' ORDER BY t2.turma_Nome ASC");

            while($dados = mysqli_fetch_assoc($select)) {
                $turma = utf8_encode($dados['nome']).' - '.utf8_encode($dados['dias']);
                $local = utf8_encode($dados['local'];
                $idTurma = $dados['id'];
                $proj = utf8_encode($dados['proj']);
                $vagas = $dados['vagas'];
                strtotime($dados['dataDesativacao']) <= strtotime(date('Y-m-d')) ? $desativada = 1 : $desativada = 0;

                if($desativada == 1) {
                    $desativada = "Desativada em ".$dados['desativacao'];
                } else {
                    $desativada = "Ativa";
                }

                $select1 = mysqli_query($conn, "SELECT DISTINCT aluno_Id FROM tb_alunoturma WHERE turma_Id = '$idTurma'");
                $inscritos = mysqli_num_rows($select1);
           ?>
			<tr>
				<td><?php echo $idTurma;?></td>
				<td><?php echo $proj;?></td>
				<td><a href="../turmaChamada.php?turma=<?php echo $idTurma;?>"><?php echo $turma;?></a></td>
				<td><?php echo $local;?></td>
                <td><?php echo $desativada;?></td>
                <td><?php echo $inscritos;?></td>
                <td>XXX</td>
                <td>XX</td>
                <td><?php echo $vagas;?></td>
                <td>XX</td>
			</tr>
            <?php } ?>
        </table>
        

        <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-10 offset-2">
            <h3 class="destaque-text">Histórico dos 20 últimos acessos de <?php echo $nome;?></h3>
            <small class="text">Último acesso do professor: <?php echo $ultimoAcesso;?></small>
            <h6 class="text"><b>IMPORTANTE: </b>cheque o nome na primeira coluna para conferir se o usuário se trata do professor em questão.</h6>
        </div>
    </div>

        <table class="table-site">
			<tr>
                <th>Data e hora</th>
				<th>Local</th>
			</tr>
            <?php
            $select = mysqli_query($conn, "SELECT DATE_FORMAT(ac_timestamp, '%d/%m/%Y %H:%i') as hora, ac_ip as ip 
            FROM tb_acesso WHERE user_id = '$usuario' ORDER BY ac_timestamp DESC LIMIT 20");
            while($dados = mysqli_fetch_assoc($select)) {
                $hora = $dados['hora'];
                $ip = $dados['ip'];
                    if($ip == '186.236.88.181') {
                        $ip = "Acesso de dentro da SEEL - IP: ".$ip;
                    } else {
                        $ip = "Acesso de fora da SEEL - IP: ".$ip;
                    }
            ?>
			<tr>
				<td><?php echo $hora; ?></td>
                <td><?php echo $ip; ?></td>
			</tr>
            <?php } ?>
		</table>

</div>
</body>
</html>