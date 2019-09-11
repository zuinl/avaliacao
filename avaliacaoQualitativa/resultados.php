<?php
include('../meta/meta.php');
include('../include/connect.php');
include('../include/navbar.php');

if(!isset($_GET['id'])) {
  mysqli_close($conn);
  header('Location: ../todosProfessores.php');
  die();
}

$id = $_GET['id'];
$nome = $_GET['nome'];

$select = "SELECT * FROM tb_avaliacao_qualitativa WHERE pro_id = '$id' AND ava_liberada = 1";
$query = mysqli_query($conn, $select);
$avaliacoes = mysqli_num_rows($query);

$select = "SELECT * FROM tb_autoavaliacao_qualitativa WHERE pro_id = '$id' AND ata_preenchida = 1";
$query = mysqli_query($conn, $select);
$autoavaliacoes = mysqli_num_rows($query);

if($avaliacoes == 0 || $autoavaliacoes == 0) {
  echo 'Não há um conjunto de avaliações para exibir ainda. Esta página só irá carregar quando houver ao menos uma 
  avaliação do coordenação liberada E uma autoavaliação preenchida pelo(a) professor(a)';
  mysqli_close($conn);
  die();
} else {
  $select = "SELECT AVG(ava_comprometimento) as comprometimento, AVG(ava_dificuldades) as dificuldades, 
  AVG(ava_potencialidades) as potencialidades, AVG(ava_controle_emocional) as emocional, 
  AVG(ava_responsabilidade) as responsabilidade, AVG(ava_cooperacao) as cooperacao, AVG(ava_dialogo) as dialogo, 
  AVG(ava_empatia) as empatia, AVG(ava_etico) as etico, AVG(ava_tolerancia) as tolerancia,
  AVG(ava_concentracao) as concentracao, AVG(ava_contexto) as contexto, AVG(ava_metodologia) as metodologia,
  AVG(ava_amplia) as amplia, AVG(ava_compartilha) as compartilha, AVG(ava_problemas) as problemas,
  AVG(ava_tarefas) as tarefas, AVG(ava_intencionalidade) as intencionalidade, AVG(ava_organizacao) as organizacao,
  AVG(ava_grupo) as grupo FROM tb_avaliacao_qualitativa WHERE pro_id = '$id'";
  $query = mysqli_query($conn, $select);
  $dados = mysqli_fetch_assoc($query);
  $AVG_SER = ($dados['comprometimento'] + $dados['dificuldades'] + $dados['potencialidades'] + $dados['emocional'] + $dados['responsabilidade']) / 5;
  $AVG_CONVIVER = ($dados['cooperacao'] + $dados['dialogo'] + $dados['empatia'] + $dados['etico'] + $dados['tolerancia']) / 5;
  $AVG_CONHECER = ($dados['concentracao'] + $dados['contexto'] + $dados['metodologia'] + $dados['amplia'] + $dados['compartilha']) / 5;
  $AVG_FAZER = ($dados['problemas'] + $dados['tarefas'] + $dados['intencionalidade'] + $dados['organizacao'] + $dados['grupo']) / 5;
  $AVG_SER = round($AVG_SER, 1);
  $AVG_CONVIVER = round($AVG_CONVIVER, 1);
  $AVG_CONHECER = round($AVG_CONHECER, 1);
  $AVG_FAZER = round($AVG_FAZER, 1);


  //--------------------SESSÃO DA AVALIAÇÃO DA COORDENAÇÃO ----------------------

  $select = "SELECT DATE_FORMAT(ava_data, '%d/%m/%Y %H:%i') as data FROM tb_avaliacao_qualitativa 
  WHERE pro_id = '$id' AND ava_liberada = 1 ORDER BY ava_data DESC LIMIT 1";
  $query = mysqli_query($conn, $select);
  $dados = mysqli_fetch_assoc($query);
  $ultimaAvaliacao = $dados['data'];

  $select = "SELECT * FROM tb_avaliacao_qualitativa WHERE pro_id = '$id' AND ava_liberada = 1 
  ORDER BY ava_data DESC LIMIT 1";
  $query = mysqli_query($conn, $select);
  $dados = mysqli_fetch_assoc($query);
  $comprometimento1 = $dados['ava_comprometimento'];
  $dificuldades1 = $dados['ava_dificuldades'];
  $potencialidades1 = $dados['ava_potencialidades'];
  $emocional1 = $dados['ava_controle_emocional'];
  $responsabilidade1 = $dados['ava_responsabilidade'];
  $cooperacao1 = $dados['ava_cooperacao'];
  $dialogo1 = $dados['ava_dialogo'];
  $empatia1 = $dados['ava_empatia'];
  $etica1 = $dados['ava_etico'];
  $tolerancia1 = $dados['ava_tolerancia'];
  $concentracao1 = $dados['ava_concentracao'];
  $contexto1 = $dados['ava_contexto'];
  $metodologia1 = $dados['ava_metodologia'];
  $amplia1 = $dados['ava_amplia'];
  $compartilha1 = $dados['ava_compartilha'];
  $problemas1 = $dados['ava_problemas'];
  $tarefas1 = $dados['ava_tarefas'];
  $intencionalidade1 = $dados['ava_intencionalidade'];
  $organizacao1 = $dados['ava_organizacao'];
  $grupo1 = $dados['ava_grupo'];
  $obsSER = 'COMPROMETIMENTO: '.utf8_encode($dados['ava_obs_comprometimento']).
  '<br>DIFICULDADES: '.utf8_encode($dados['ava_obs_dificuldades']).
  '<br>POTENCIALIDADES: '.utf8_encode($dados['ava_obs_potencialidades']).
  '<br>CONTROLE EMOCIONAL: '.utf8_encode($dados['ava_obs_controle_emocional']).
  '<br>RESPONSABILIDADE: '.utf8_encode($dados['ava_obs_responsabilidade']);
  $obsCONVIVER = 'COOPERAÇÃO: '.utf8_encode($dados['ava_obs_cooperacao']).
  '<br>DIÁLOGO COM CLAREZA: '.utf8_encode($dados['ava_obs_dialogo']).
  '<br>EMPATIA: '.utf8_encode($dados['ava_obs_empatia']).
  '<br>ÉTICA: '.utf8_encode($dados['ava_obs_etico']).
  '<br>TOLERÂNCIA: '.utf8_encode($dados['ava_obs_tolerancia']);
  $obsCONHECER = 'CONCENTRAÇÃO: '.utf8_encode($dados['ava_obs_concentracao']).
  '<br>INTERPRETAÇÃO DE CONTEXTO: '.utf8_encode($dados['ava_obs_contexto']).
  '<br>CONHECIMENTO METODOLÓGICO INSTITUCIONAL: '.utf8_encode($dados['ava_obs_metodologia']).
  '<br>EXPANSÃO DO CONHECIMENTO: '.utf8_encode($dados['ava_obs_amplia']).
  '<br>COMPARTILHAMENTO DE IDEIAS: '.utf8_encode($dados['ava_obs_compartilha']);
  $obsFAZER = 'SOLUCIONA PROBLEMAS: '.utf8_encode($dados['ava_obs_problemas']).
  '<br>COMPARTILHA TAREFAS: '.utf8_encode($dados['ava_obs_tarefas']).
  '<br>PLANEJAMENTO COM INTENCIONALIDADE: '.utf8_encode($dados['ava_obs_intencionalidade']).
  '<br>ORGANIZAÇÃO: '.utf8_encode($dados['ava_obs_organizacao']).
  '<br>PRODUZ EM GRUPO: '.utf8_encode($dados['ava_obs_grupo']);

  $select = "SELECT * FROM tb_avaliacao_qualitativa WHERE pro_id = '$id' AND ava_liberada = 1 
  ORDER BY ava_data DESC LIMIT 1 OFFSET 1";
  $query = mysqli_query($conn, $select);

  if(mysqli_num_rows($query) == 0) {
    $dataAnterior1 = 'Sem registros';
    $comprometimento2 = 0;
    $dificuldades2 = 0;
    $potencialidades2 = 0;
    $emocional2 = 0;
    $responsabilidade2 = 0;
    $cooperacao2 = 0;
    $dialogo2 = 0;
    $empatia2 = 0;
    $etica2 = 0;
    $tolerancia2 = 0;
    $concentracao2 = 0;
    $contexto2 = 0;
    $metodologia2 = 0;
    $amplia2 = 0;
    $compartilha2 = 0;
    $problemas2 = 0;
    $tarefas2 = 0;
    $intencionalidade2 = 0;
    $organizacao2 = 0;
    $grupo2 = 0;
  } else {
    $dados = mysqli_fetch_assoc($query);
    $comprometimento2 = $dados['ava_comprometimento'];
    $dificuldades2 = $dados['ava_dificuldades'];
    $potencialidades2 = $dados['ava_potencialidades'];
    $emocional2 = $dados['ava_controle_emocional'];
    $responsabilidade2 = $dados['ava_responsabilidade'];
    $cooperacao2 = $dados['ava_cooperacao'];
    $dialogo2 = $dados['ava_dialogo'];
    $empatia2 = $dados['ava_empatia'];
    $etica2 = $dados['ava_etico'];
    $tolerancia2 = $dados['ava_tolerancia'];
    $concentracao2 = $dados['ava_concentracao'];
    $contexto2 = $dados['ava_contexto'];
    $metodologia2 = $dados['ava_metodologia'];
    $amplia2 = $dados['ava_amplia'];
    $compartilha2 = $dados['ava_compartilha'];
    $problemas2 = $dados['ava_problemas'];
    $tarefas2 = $dados['ava_tarefas'];
    $intencionalidade2 = $dados['ava_intencionalidade'];
    $organizacao2 = $dados['ava_organizacao'];
    $grupo2 = $dados['ava_grupo'];
    $dataAnterior1 = date_create($dados['ava_data']);
    $dataAnterior1 = date_format($dataAnterior1, 'd/m/Y');
  }

  
  $select = "SELECT * FROM tb_avaliacao_qualitativa WHERE pro_id = '$id' AND ava_liberada = 1 
  ORDER BY ava_data DESC LIMIT 1 OFFSET 2";
  $query = mysqli_query($conn, $select);

  if(mysqli_num_rows($query) == 0) {
    $dataAnterior2 = 'Sem registros';
    $comprometimento3 = 0;
    $dificuldades3 = 0;
    $potencialidades3 = 0;
    $emocional3 = 0;
    $responsabilidade3 = 0;
    $cooperacao3 = 0;
    $dialogo3 = 0;
    $empatia3 = 0;
    $etica3 = 0;
    $tolerancia3 = 0;
    $concentracao3 = 0;
    $contexto3 = 0;
    $metodologia3 = 0;
    $amplia3 = 0;
    $compartilha3 = 0;
    $problemas3 = 0;
    $tarefas3 = 0;
    $intencionalidade3 = 0;
    $organizacao3 = 0;
    $grupo3 = 0;
  } else {
    $dados = mysqli_fetch_assoc($query);
    $comprometimento3 = $dados['ava_comprometimento'];
    $dificuldades3 = $dados['ava_dificuldades'];
    $potencialidades3 = $dados['ava_potencialidades'];
    $emocional3 = $dados['ava_controle_emocional'];
    $responsabilidade3 = $dados['ava_responsabilidade'];
    $cooperacao3 = $dados['ava_cooperacao'];
    $dialogo3 = $dados['ava_dialogo'];
    $empatia3 = $dados['ava_empatia'];
    $etica3 = $dados['ava_etico'];
    $tolerancia3 = $dados['ava_tolerancia'];
    $concentracao3 = $dados['ava_concentracao'];
    $contexto3 = $dados['ava_contexto'];
    $metodologia3 = $dados['ava_metodologia'];
    $amplia3 = $dados['ava_amplia'];
    $compartilha3 = $dados['ava_compartilha'];
    $problemas3 = $dados['ava_problemas'];
    $tarefas3 = $dados['ava_tarefas'];
    $intencionalidade3 = $dados['ava_intencionalidade'];
    $organizacao3 = $dados['ava_organizacao'];
    $grupo3 = $dados['ava_grupo'];
    $dataAnterior2 = date_create($dados['ava_data']);
    $dataAnterior2 = date_format($dataAnterior1, 'd/m/Y');
  }



  //------------------- SESSÃO DA AUTOAVALIAÇÃO -----------------------------
  $select = "SELECT DATE_FORMAT(ata_data_liberacao, '%d/%m/%Y %H:%i') as data FROM tb_autoavaliacao_qualitativa 
  WHERE pro_id = '$id' AND ata_preenchida = 1 ORDER BY ata_data_liberacao DESC LIMIT 1";
  $query = mysqli_query($conn, $select);
  $dados = mysqli_fetch_assoc($query);
  $ultimaAutoavaliacao = $dados['data'];

  $select = "SELECT * FROM tb_autoavaliacao_qualitativa WHERE pro_id = '$id' AND ata_preenchida = 1 
  ORDER BY ata_data_liberacao DESC LIMIT 1";
  $query = mysqli_query($conn, $select);
  $dados = mysqli_fetch_assoc($query);
  $ata_comprometimento1 = $dados['ata_comprometimento'];
  $ata_dificuldades1 = $dados['ata_dificuldades'];
  $ata_potencialidades1 = $dados['ata_potencialidades'];
  $ata_emocional1 = $dados['ata_controle_emocional'];
  $ata_responsabilidade1 = $dados['ata_responsabilidade'];
  $ata_cooperacao1 = $dados['ata_cooperacao'];
  $ata_dialogo1 = $dados['ata_dialogo'];
  $ata_empatia1 = $dados['ata_empatia'];
  $ata_etica1 = $dados['ata_etico'];
  $ata_tolerancia1 = $dados['ata_tolerancia'];
  $ata_concentracao1 = $dados['ata_concentracao'];
  $ata_contexto1 = $dados['ata_contexto'];
  $ata_metodologia1 = $dados['ata_metodologia'];
  $ata_amplia1 = $dados['ata_amplia'];
  $ata_compartilha1 = $dados['ata_compartilha'];
  $ata_problemas1 = $dados['ata_problemas'];
  $ata_tarefas1 = $dados['ata_tarefas'];
  $ata_intencionalidade1 = $dados['ata_intencionalidade'];
  $ata_organizacao1 = $dados['ata_organizacao'];
  $ata_grupo1 = $dados['ata_grupo'];

  $select = "SELECT * FROM tb_autoavaliacao_qualitativa WHERE pro_id = '$id' AND ata_preenchida = 1 
  ORDER BY ata_data_liberacao DESC LIMIT 1 OFFSET 1";
  $query = mysqli_query($conn, $select);

  if(mysqli_num_rows($query) == 0) {
    $ata_dataAnterior1 = 'Sem registros';
    $ata_comprometimento2 = 0;
    $ata_dificuldades2 = 0;
    $ata_potencialidades2 = 0;
    $ata_emocional2 = 0;
    $ata_responsabilidade2 = 0;
    $ata_cooperacao2 = 0;
    $ata_dialogo2 = 0;
    $ata_empatia2 = 0;
    $ata_etica2 = 0;
    $ata_tolerancia2 = 0;
    $ata_concentracao2 = 0;
    $ata_contexto2 = 0;
    $ata_metodologia2 = 0;
    $ata_amplia2 = 0;
    $ata_compartilha2 = 0;
    $ata_problemas2 = 0;
    $ata_tarefas2 = 0;
    $ata_intencionalidade2 = 0;
    $ata_organizacao2 = 0;
    $ata_grupo2 = 0;
  } else {
    $dados = mysqli_fetch_assoc($query);
    $ata_comprometimento2 = $dados['ata_comprometimento'];
    $ata_dificuldades2 = $dados['ata_dificuldades'];
    $ata_potencialidades2 = $dados['ata_potencialidades'];
    $ata_emocional2 = $dados['ata_controle_emocional'];
    $ata_responsabilidade2 = $dados['ata_responsabilidade'];
    $ata_cooperacao2 = $dados['ata_cooperacao'];
    $ata_dialogo2 = $dados['ata_dialogo'];
    $ata_empatia2 = $dados['ata_empatia'];
    $ata_etica2 = $dados['ata_etico'];
    $ata_tolerancia2 = $dados['ata_tolerancia'];
    $ata_concentracao2 = $dados['ata_concentracao'];
    $ata_contexto2 = $dados['ata_contexto'];
    $ata_metodologia2 = $dados['ata_metodologia'];
    $ata_amplia2 = $dados['ata_amplia'];
    $ata_compartilha2 = $dados['ata_compartilha'];
    $ata_problemas2 = $dados['ata_problemas'];
    $ata_tarefas2 = $dados['ata_tarefas'];
    $ata_intencionalidade2 = $dados['ata_intencionalidade'];
    $ata_organizacao2 = $dados['ata_organizacao'];
    $ata_grupo2 = $dados['ata_grupo'];
    $ata_dataAnterior1 = date_create($dados['ata_data']);
    $ata_dataAnterior1 = date_format($dataAnterior1, 'd/m/Y');
  }

  
  $select = "SELECT * FROM tb_autoavaliacao_qualitativa WHERE pro_id = '$id' AND ata_preenchida = 1 
  ORDER BY ata_data_liberacao DESC LIMIT 1 OFFSET 2";
  $query = mysqli_query($conn, $select);

  if(mysqli_num_rows($query) == 0) {
    $ata_dataAnterior2 = 'Sem registros';
    $ata_comprometimento3 = 0;
    $ata_dificuldades3 = 0;
    $ata_potencialidades3 = 0;
    $ata_emocional3 = 0;
    $ata_responsabilidade3 = 0;
    $ata_cooperacao3 = 0;
    $ata_dialogo3 = 0;
    $ata_empatia3 = 0;
    $ata_etica3 = 0;
    $ata_tolerancia3 = 0;
    $ata_concentracao3 = 0;
    $ata_contexto3 = 0;
    $ata_metodologia3 = 0;
    $ata_amplia3 = 0;
    $ata_compartilha3 = 0;
    $ata_problemas3 = 0;
    $ata_tarefas3 = 0;
    $ata_intencionalidade3 = 0;
    $ata_organizacao3 = 0;
    $ata_grupo3 = 0;
  } else {
    $dados = mysqli_fetch_assoc($query);
    $ata_comprometimento3 = $dados['ata_comprometimento'];
    $ata_dificuldades3 = $dados['ata_dificuldades'];
    $ata_potencialidades3 = $dados['ata_potencialidades'];
    $ata_emocional3 = $dados['ata_controle_emocional'];
    $ata_responsabilidade3 = $dados['ata_responsabilidade'];
    $ata_cooperacao3 = $dados['ata_cooperacao'];
    $ata_dialogo3 = $dados['ata_dialogo'];
    $ata_empatia3 = $dados['ata_empatia'];
    $ata_etica3 = $dados['ata_etico'];
    $ata_tolerancia3 = $dados['ata_tolerancia'];
    $ata_concentracao3 = $dados['ata_concentracao'];
    $ata_contexto3 = $dados['ata_contexto'];
    $ata_metodologia3 = $dados['ata_metodologia'];
    $ata_amplia3 = $dados['ata_amplia'];
    $ata_compartilha3 = $dados['ata_compartilha'];
    $ata_problemas3 = $dados['ata_problemas'];
    $ata_tarefas3 = $dados['ata_tarefas'];
    $ata_intencionalidade3 = $dados['ata_intencionalidade'];
    $ata_organizacao3 = $dados['ata_organizacao'];
    $ata_grupo3 = $dados['ata_grupo'];
    $ata_dataAnterior2 = date_create($dados['ata_data']);
    $ata_dataAnterior2 = date_format($dataAnterior1, 'd/m/Y');
  }
}
?>
<html>
<head>
    <title>Resultados de Nome do Prof</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Nota', 'Educador', 'Coordenação'],
          ['Comprometimento',  1,      <?php echo $comprometimento1; ?>],
          ['Conhece suas dificuldades',  1,      <?php echo $dificuldades1; ?>],
          ['Reconhe suas potencialidades',  2,       <?php echo $potencialidades1; ?>],
          ['Controle emocional',  5,      <?php echo $emocional1; ?>],
          ['Responsabilidade', 2, <?php echo $responsabilidade1; ?>]
        ]);

        var options = {
          title: 'VISÃO: SER',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Nota', 'Educador', 'Coordenação'],
          ['Cooperação',  <?php echo $ata_cooperacao1; ?>,      <?php echo $cooperacao1; ?>],
          ['Diálogo com clareza',  <?php echo $ata_dialogo1; ?>,      <?php echo $dialogo1; ?>],
          ['Empatia',  <?php echo $ata_empatia1; ?>,       <?php echo $empatia1; ?>],
          ['Agir de forma ética',  <?php echo $ata_etica1; ?>,      <?php echo $etica1; ?>],
          ['Tolerância', <?php echo $ata_tolerancia1; ?>, <?php echo $tolerancia1; ?>]
        ]);

        var options = {
          title: 'VISÃO: CONVIVER',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart1'));

        chart.draw(data, options);
      }
    </script>


<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Nota', 'Educador', 'Coordenação'],
          ['Concentração',  <?php echo $ata_concentracao1; ?>,      <?php echo $concentracao1; ?>],
          ['Interpretação de contexto',  <?php echo $ata_contexto1; ?>,      <?php echo $contexto1; ?>],
          ['Conhecimento metodológico institucional',  <?php echo $ata_metodologia1; ?>,       <?php echo $metodologia1; ?>],
          ['Amplia seu conhecimento',  <?php echo $ata_amplia1; ?>,      <?php echo $amplia1; ?>],
          ['Compartilhamento de ideias', <?php echo $ata_compartilha1; ?>, <?php echo $compartilha1; ?>]
        ]);

        var options = {
          title: 'VISÃO: CONHECER',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart.draw(data, options);
      }
    </script>


<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Nota', 'Educador', 'Coordenação'],
          ['Soluciona problemas',  <?php echo $ata_problemas1; ?>,      <?php echo $problemas1; ?>],
          ['Compartilha tarefas',  <?php echo $ata_tarefas1; ?>,      <?php echo $tarefas1; ?>],
          ['Planeja com intencionalidade',  <?php echo $ata_intencionalidade1; ?>,       <?php echo $intencionalidade1; ?>],
          ['Organização',  <?php echo $ata_organizacao1; ?>,      <?php echo $organizacao1; ?>],
          ['Produz em grupo', <?php echo $ata_grupo1; ?>, <?php echo $grupo1; ?>]
        ]);

        var options = {
          title: 'VISÃO: FAZER',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart3'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_comprometimento3; ?>,      <?php echo $comprometimento3; ?>],
          ['Penúltima nota',  <?php echo $ata_comprometimento2; ?>,      <?php echo $comprometimento2; ?>],
          ['Última nota',  <?php echo $ata_comprometimento1; ?>,       <?php echo $comprometimento1; ?>]
        ]);

        var options = {
          title: 'SER: Comprometimento',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart4'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_dificuldades3; ?>,      <?php echo $dificuldades3; ?>],
          ['Penúltima nota',  <?php echo $ata_dificuldades2; ?>,      <?php echo $dificuldades2; ?>],
          ['Última nota',  <?php echo $ata_dificuldades1; ?>,       <?php echo $dificuldades1; ?>]
        ]);

        var options = {
          title: 'SER: Conhecimento de suas dificuldades',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart5'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_potencialidades3; ?>,      <?php echo $potencialidades3; ?>],
          ['Penúltima nota',  <?php echo $ata_potencialidades2; ?>,      <?php echo $potencialidades2; ?>],
          ['Última nota',  <?php echo $ata_potencialidades1; ?>,       <?php echo $potencialidades1; ?>]
        ]);

        var options = {
          title: 'SER: Reconhecimento de potencialidades',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart6'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_emocional3; ?>,      <?php echo $emocional3; ?>],
          ['Penúltima nota',  <?php echo $ata_emocional2; ?>,      <?php echo $emocional2; ?>],
          ['Última nota',  <?php echo $ata_emocional1; ?>,       <?php echo $emocional1; ?>]
        ]);

        var options = {
          title: 'SER: Controle emocional',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart7'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_responsabilidade3; ?>,      <?php echo $responsabilidade3; ?>],
          ['Penúltima nota',  <?php echo $ata_responsabilidade2; ?>,      <?php echo $responsabilidade2; ?>],
          ['Última nota',  <?php echo $ata_responsabilidade1; ?>,       <?php echo $responsabilidade1; ?>]
        ]);

        var options = {
          title: 'SER: Responsabilidade',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart8'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_cooperacao3; ?>,      <?php echo $cooperacao3; ?>],
          ['Penúltima nota',  <?php echo $ata_cooperacao2; ?>,      <?php echo $cooperacao2; ?>],
          ['Última nota',  <?php echo $ata_cooperacao1; ?>,       <?php echo $cooperacao1; ?>]
        ]);

        var options = {
          title: 'CONVIVER: Cooperação',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart9'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_dialogo3; ?>,      <?php echo $dialogo3; ?>],
          ['Penúltima nota',  <?php echo $ata_dialogo2; ?>,      <?php echo $dialogo2; ?>],
          ['Última nota',  <?php echo $ata_dialogo1; ?>,       <?php echo $dialogo1; ?>]
        ]);

        var options = {
          title: 'CONVIVER: Diálogo com clareza',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart10'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_empatia3; ?>,      <?php echo $empatia3; ?>],
          ['Penúltima nota',  <?php echo $ata_empatia2; ?>,      <?php echo $empatia2; ?>],
          ['Última nota',  <?php echo $ata_empatia1; ?>,       <?php echo $empatia1; ?>]
        ]);

        var options = {
          title: 'CONVIVER: Empatia',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart11'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_etica3; ?>,      <?php echo $etica3; ?>],
          ['Penúltima nota',  <?php echo $ata_etica2; ?>,      <?php echo $etica2; ?>],
          ['Última nota',  <?php echo $ata_etica1; ?>,       <?php echo $etica1; ?>]
        ]);

        var options = {
          title: 'CONVIVER: Agir de forma ética',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart12'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_tolerancia3; ?>,      <?php echo $tolerancia3; ?>],
          ['Penúltima nota',  <?php echo $ata_tolerancia2; ?>,      <?php echo $tolerancia2; ?>],
          ['Última nota',  <?php echo $ata_tolerancia1; ?>,       <?php echo $tolerancia1; ?>]
        ]);

        var options = {
          title: 'CONVIVER: Tolerância',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart13'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_concentracao3; ?>,      <?php echo $concentracao3; ?>],
          ['Penúltima nota',  <?php echo $ata_concentracao2; ?>,      <?php echo $concentracao2; ?>],
          ['Última nota',  <?php echo $ata_concentracao1; ?>,       <?php echo $concentracao1; ?>]
        ]);

        var options = {
          title: 'CONHECER: Concentração',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart14'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_contexto3; ?>,      <?php echo $contexto3; ?>],
          ['Penúltima nota',  <?php echo $ata_contexto2; ?>,      <?php echo $contexto2; ?>],
          ['Última nota',  <?php echo $ata_contexto1; ?>,       <?php echo $contexto1; ?>]
        ]);

        var options = {
          title: 'CONHECER: Interpretação de contexto',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart15'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_metodologia3; ?>,      <?php echo $metodologia3; ?>],
          ['Penúltima nota',  <?php echo $ata_metodologia2; ?>,      <?php echo $metodologia2; ?>],
          ['Última nota',  <?php echo $ata_metodologia1; ?>,       <?php echo $metodologia1; ?>]
        ]);

        var options = {
          title: 'CONHECER: Conhecimento metodológico institucional',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart16'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_amplia3; ?>,      <?php echo $amplia3; ?>],
          ['Penúltima nota',  <?php echo $ata_amplia2; ?>,      <?php echo $amplia2; ?>],
          ['Última nota',  <?php echo $ata_amplia1; ?>,       <?php echo $amplia1; ?>]
        ]);

        var options = {
          title: 'CONHECER: Amplia seu conhecimento',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart17'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_compartilha3; ?>,      <?php echo $compartilha3; ?>],
          ['Penúltima nota',  <?php echo $ata_compartilha2; ?>,      <?php echo $compartilha2; ?>],
          ['Última nota',  <?php echo $ata_compartilha1; ?>,       <?php echo $compartilha1; ?>]
        ]);

        var options = {
          title: 'CONHECER: Compartilha suas ideias',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart18'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_problemas3; ?>,      <?php echo $problemas3; ?>],
          ['Penúltima nota',  <?php echo $ata_problemas2; ?>,      <?php echo $problemas2; ?>],
          ['Última nota',  <?php echo $ata_problemas1; ?>,       <?php echo $problemas1; ?>]
        ]);

        var options = {
          title: 'FAZER: Solução de problemas',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart19'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_tarefas3; ?>,      <?php echo $tarefas3; ?>],
          ['Penúltima nota',  <?php echo $ata_tarefas2; ?>,      <?php echo $tarefas2; ?>],
          ['Última nota',  <?php echo $ata_tarefas1; ?>,       <?php echo $tarefas1; ?>]
        ]);

        var options = {
          title: 'FAZER: Compartilhamento de tarefas',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart20'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_intencionalidade3; ?>,      <?php echo $intencionalidade3; ?>],
          ['Penúltima nota',  <?php echo $ata_intencionalidade2; ?>,      <?php echo $intencionalidade2; ?>],
          ['Última nota',  <?php echo $ata_intencionalidade1; ?>,       <?php echo $intencionalidade1; ?>]
        ]);

        var options = {
          title: 'FAZER: Planejamento com intencionalidade',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart21'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_organizacao1; ?>,      <?php echo $organizacao3; ?>],
          ['Penúltima nota',  <?php echo $ata_organizacao2; ?>,      <?php echo $organizacao2; ?>],
          ['Última nota',  <?php echo $ata_organizacao1; ?>,       <?php echo $organizacao1; ?>]
        ]);

        var options = {
          title: 'FAZER: Organização',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart22'));

        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Educador', 'Coordenação'],
          ['Antepenúltima nota',  <?php echo $ata_grupo3; ?>,      <?php echo $grupo3; ?>],
          ['Penúltima nota',  <?php echo $ata_grupo2; ?>,      <?php echo $grupo2; ?>],
          ['Última nota',  <?php echo $ata_grupo1; ?>,       <?php echo $grupo1; ?>]
        ]);

        var options = {
          title: 'FAZER: Produz em grupo',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart23'));

        chart.draw(data, options);
      }
    </script>
</head>
<body>
<div class="container">

    <div class="row">
        <div class="col-sm-1">
            <a onclick="window.history.go(-1)" href="#"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-9" style="margin-top: 1em;">
            <h2 class="high-text">Resultados qualitativos de <i><span class="destaque-text"><?php echo $nome;?></span></i></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 1em;">
            <h6 class="text">Última autoavaliação: <?php echo $ultimaAutoavaliacao;?></h6>
            <h6 class="text">Última avaliação da coordenação: <?php echo $ultimaAvaliacao;?></h6>
        </div>
        
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-2">
            <h5 class="text"><b>MÉDIAS</b></h5>
        </div>
        <div class="col-sm-2">
            <h5 class="text">SER: <?php echo $AVG_SER; ?></h5>
        </div>
        <div class="col-sm-2">
            <h5 class="text">CONVIVER: <?php echo $AVG_CONVIVER; ?></h5>
        </div>
        <div class="col-sm-2">
            <h5 class="text">CONHECER: <?php echo $AVG_CONHECER; ?></h5>
        </div>
        <div class="col-sm-2">
            <h5 class="text">FAZER: <?php echo $AVG_FAZER; ?></h5>
        </div>
    </div>

    <hr class="hr-divide-light">

    <h2 class="high-text">Dados da última <i><span class="destaque-text">avaliação</span></i> e <i><span class="destaque-text">autoavaliação</span></i></h2>

    <div class="row">
        <div class="col-sm-12">
            <div id="curve_chart" style="width: 100%; height: 30em;"></div>
            <p class="text"><?php echo $obsSER; ?></p>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <div id="curve_chart1" style="width: 100%; height: 30em;"></div>
            <p class="text"><?php echo $obsCONVIVER; ?></p>
        </div>
    </div>

    
    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <div id="curve_chart2" style="width: 100%; height: 30em;"></div>
            <p class="text"><?php echo $obsCONHECER; ?></p>
        </div>
    </div>


    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <div id="curve_chart3" style="width: 100%; height: 30em;"></div>
            <p class="text"><?php echo $obsFAZER; ?></p>
        </div>
    </div>


    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">Histórico de avaliações - <i><span class="destaque-text">SER</span></i></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart4" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart5" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart6" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart7" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart8" style="width: 100%; height: 15em;"></div>
        </div>
    </div>



    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">Histórico de avaliações - <i><span class="destaque-text">CONVIVER</span></i></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart9" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart10" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart11" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart12" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart13" style="width: 100%; height: 15em;"></div>
        </div>
    </div>


    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">Histórico de avaliações - <i><span class="destaque-text">CONHECER</span></i></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart14" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart15" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart16" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart17" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart18" style="width: 100%; height: 15em;"></div>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">Histórico de avaliações - <i><span class="destaque-text">FAZER</span></i></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart19" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart20" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart21" style="width: 100%; height: 15em;"></div>
        </div>
        <div class="col-sm-6">
            <div id="curve_chart22" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div id="curve_chart23" style="width: 100%; height: 15em;"></div>
        </div>
    </div>
</div>
</body>
</html>