<?php
    include('connect.php');
    if(!isset($_GET['id'])) header('../todosProfessores.php');

    $id = $_GET['id'];
    $select = "SELECT turma_Nome as nome, turma_Dias as dias, turma_LimiteAlunos as vagas FROM tb_turma 
    WHERE turma_Id = '$id'";

    $query = mysqli_query($conn, $select);
    $dados = mysqli_fetch_assoc($query);
    $turma = $dados['nome'];
    $dias = $dados['dias'];
    $vagas = $dados['vagas'];

?>
<head>
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
            title: 'Histórico de atendimentos desta turma',
            hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>


    <div class="row">
        <div class="col-sm-4">
            <h4 class="text"><b><?php echo $turma; ?></b></h4>
        </div>
        <div class="col-sm-5">
            <h4 class="text"><?php echo $dias; ?></h4>
        </div>
        <div class="col-sm-3">
            <h4 class="text">Capacidade: <?php echo $vagas; ?> </h4>
        </div>
    </div>

    <table class="table-site">
			<tr>
				<th>Data dos dados</th>
				<th>Atendimentos</th>
				<th>Déficit</th>
			</tr>
            <tr>
				<td>XX/XX/XXXX</td>
				<td>XXX</td>
				<td>XX</td>
			</tr>
        </table>