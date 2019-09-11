<?php
include('../meta/meta.php');
include('../include/connect.php');
include('../include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: ../todosProfessores.php');
}
$id = $_GET['id'];
$nome = $_GET['nome'];

$select = "SELECT ava_id, DATE_FORMAT(ava_data_liberacao, '%d/%m/%Y %H:%i') as liberacao, 
DATE_FORMAT(ava_data, '%d/%m/%Y %H:%i') as data FROM tb_avaliacao_qualitativa 
WHERE pro_id = '$id' AND ava_liberada = 1 ORDER BY ava_data_liberacao DESC LIMIT 1";
$query = mysqli_query($conn, $select);

$msgAvaliacao = "";
$hrefAvaliacao = "";
if(mysqli_num_rows($query) != 0) { //HÁ UMA ÚLTIMA AVALIAÇÃO LIBERADA
    $dados = mysqli_fetch_assoc($query);
    $ava_id = $dados['ava_id'];
    $liberacao = $dados['liberacao'];
    $data = $dados['data'];

    $hrefAvaliacao .= 'href=resultados.php?id='.$id.'&nome='.$nome;
    $msgAvaliacao .= 'Avaliações liberadas de <b>'.$liberacao.'</b> para trás estão disponíveis';
} else { //NÃO HÁ AVALIAÇÃO LIBERADA, BUSCANDO A COM DATA DE LIBERAÇÃO MAIS PRÓXIMA
    $select = "SELECT ava_id, DATE_FORMAT(ava_data_liberacao, '%d/%m/%Y %H:%s') as liberacao, 
    DATE_FORMAT(ava_data, '%d/%m/%Y %H:%s') as data
    FROM tb_avaliacao_qualitativa WHERE pro_id = '$id' AND ava_liberada = 0 ORDER BY ava_data_liberacao ASC LIMIT 1";
    $query = mysqli_query($conn, $select);

    if(mysqli_num_rows($query) == 0) { //NÃO HÁ NENHUMA AVALIAÇÃO PARA O PROFESSOR, NEM DE LIBERAÇÃO PRÓXIMA
        $hrefAvaliacao .= "href=#";
        $msgAvaliacao .= 'Nenhuma avaliação foi criada para este(a) professor(a) ainda';
    } else { //CONSTA AVALIAÇÃO AINDA NÃO LIBERADA
        $dados = mysqli_fetch_assoc($query);
        $liberacao = $dados['liberacao'];
        $data = $dados['data'];

        $hrefAvaliacao .= 'href=resultados.php?id='.$id.'&nome='.$nome;
        $msgAvaliacao .= 'Avaliação criada em <b>'.$data.'</b> e será liberada para visualização em <b>'.$liberacao.'</b> ou antes, se o(a) coordenador(a) liberar. As avaliações anteriores a esta estão disponíveis para visualização';
    }  
}

$userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
  $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
  $query = mysqli_query($conn, $select);
  
  if(mysqli_num_rows($query) > 0) {
      $isCoordenador = 1;
  } else {
      $isCoordenador = 0;
  }

$select = "SELECT ata_id, DATE_FORMAT(ata_data_liberacao, '%d/%m/%Y %H:%i') as liberacao 
FROM tb_autoavaliacao_qualitativa WHERE pro_id = '$id' AND ata_liberada = 1 AND ata_preenchida = 0 ORDER BY ata_data_liberacao DESC LIMIT 1";
$query = mysqli_query($conn, $select);
echo mysqli_error($conn);

$hrefAutoavaliacao = "";
$msgAutoavaliacao = "";
$msgProfAta = "";
$autoavaliacaoLiberada = 0;
if(mysqli_num_rows($query) != 0) { //HÁ ATUALIZAÇÃO LIBERADA E NÃO PREENCHIDA
        $dados = mysqli_fetch_assoc($query);
        $avaLiberacao = $dados['liberacao'];
        $autoavaliacaoLiberada = 1;

        $hrefAutoavaliacao .= "href=#";
        $msgAutoavaliacao .= "Autoavaliação liberada em <b>".$avaLiberacao."</b> e ainda não preenchida pelo(a) professor(a). Você não pode liberar outra antes que ele(a) preencha";
        $msgProfAta .= "Autoavaliação liberada em <b>".$avaLiberacao."</b>";
} else {
        $hrefAutoavaliacao .= "href=libera.php?autoavaliacao=true&id=".$id;
        $msgAutoavaliacao .= "O(a) professor(a) não está com a autoavaliação liberada para preenchimento. Você pode liberar uma agora.";
}  

?>
<html>
<head>
    <title>Tipo de avaliação</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-1">
            <a href="../verProfessor.php?id=<?php echo $id; ?>"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
        <!-- <div class="col-sm-3">
            <a href="tel:12992439457"><button class="button button1" style="font-size: 0.8em;"></button></a>
        </div>
        <div class="col-sm-2">
            <a href="mailto:leonardosoareszuin@gmail.com"><button class="button button2" style="font-size: 0.8em;">Enviar e-mail</button></a>
        </div> -->
    </div>

    <div class="row">
        <div class="col-sm-12" style="margin-top: 1em;">
            <h1 class="high-text">Painel de avaliações de <i><span class="destaque-text"><?php echo $nome; ?></span></i></h1>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <?php if($isCoordenador == 1)  { ?>
        <div class="col-sm-4">
            <a href="observacoes.php?id=<?php echo $id; ?>&nome=<?php echo $nome; ?>"><button class="button button2">Inserir observações sobre <?php echo $nome; ?></button></a>
        </div> 
        <div class="col-sm-4">
            <a href="avaliacaoCompleta.php?id=<?php echo $id; ?>&nome=<?php echo $nome; ?>"><button class="button button1">Iniciar avaliação qualitativa completa</button></a>
        </div>
        <?php } ?>
        <?php if($autoavaliacaoLiberada == 1 && $isCoordenador == 0) { ?>
        <div class="col-sm-4">
            <a href="autoAvaliacao.php?id=<?php echo $id; ?>&nome=<?php echo $nome; ?>"><button class="button button2">Iniciar sua autoavaliação</button></a>
            <h6 class="text"><?php echo $msgProfAta; ?></h6>
        </div>
        <?php } ?>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <?php if($isCoordenador == 1)  { ?>
        <div class="col-sm-6">
            <a <?php echo $hrefAutoavaliacao; ?>><button class="button button3">Liberar nova autoavaliação para <?php echo $nome; ?></button></a>
            <h6 class="text"><?php echo $msgAutoavaliacao; ?></h6>
        </div>
        <div class="col-sm-6">
            <a href="libera.php?avaliacao=true&id=<?php echo $id; ?>"><button class="button button3">Liberar visualização das avaliações</button></a>
            <h6 class="text">Ao clicar aqui, todas as avaliações não liberadas de <?php echo $nome; ?> serão disponibilizadas para visualização</h6>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a <?php echo $hrefAvaliacao; ?>><button class="button button1">Ver resultados de <?php echo $nome; ?></button></a>
            <h6 class="text"><?php echo $msgAvaliacao; ?></h6>
        </div>
    </div>
    
    <hr class="hr-divide-light">
    
    <?php if($isCoordenador == 0)  { ?>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">ATENÇÃO professores(as)</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p class="text"><b>INICIAR SUA AUTOAVALIAÇÃO:</b> você só conseguirá realizar sua autoavaliação quando os(as) coordenadores(as) 
            liberarem. Você deve preenchê-la com cautela e depois aguardar a avaliação dos(as) coordenadores(as) para ver e comparar os resultados.</p>
            <p class="text"><b>VER RESULTADOS:</b> na sua página de resultados, você vai ver os dados referentes às suas autoavaliações 
            e as avaliações já liberadas pelos coordenadores.</p>
        </div>
    </div>
    <?php } ?>

    <hr class="hr-divide-light">

    <?php if($isCoordenador == 1)  { ?>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="high-text">ATENÇÃO coordenadores(as)</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p class="text"><b>AO LIBERAR AUTOAVALIÇÃO:</b> ao clicar neste botão, você estará criando uma nova autoavaliação e a 
            disponibilizando para que o(a) professor(a) a preencha. Você não poderá criar novas autoavaiações sem que o(a) professor(a) 
            preencha a última liberada.</p>
            <p class="text"><b>AO LIBERAR VISUALIZAÇÃO DAS VISUALIZAÇÕES:</b> ao clicar neste botão, você estará liberando para visualização 
            todas as avaliações que você, coordenador(a), criou e ainda não havia liberado. Os resultados estarão junto com os dados na página de resultados.</p>
            <p class="text"><b>VER RESULTADOS:</b> nesta página, os professores somente conseguirão visualizar os resultados 
            referentes às avaliações que já foram liberadas para ele visualizar. As autoavaliações que ele fizer, porém, 
            já estarão disponíveis nesta página. Os(as) coordenadores(as) sempre visualizam todas as avaliações e autoavaliações, 
            mesmo as não liberadas.</p>
            <p class="text"><b>INSERIR OBSERVAÇÕES:</b> nesta página, você edita as observações sobre o(a) professor(a). Elas 
            servem para te auxiliar na hora de criar a avaliação qualitativa final do(a) professor(a).</p>
            <p class="text"><b>INICIAR AVALIAÇÃO QUALITATIVA COMPLETA:</b> ao clicar neste botão, que está visível apenas para 
            coordenadores(as), você vai criar uma nova avaliação qualitativa completa para o(a) professor(a). A avaliação tem 
            um prazo padrão de liberação de 30 dias a partir de sua criação, ou seja, se você não a liberar em 30 dias, ela será 
            liberada automaticamente. Os(as) coordenadores(as) podem criar novas avaliações completas a qualquer momento. Mas lembre-se, 
            se não for mantido uma sequência com as autoavaliações dos(as) professores(as), os resultados serão afetados.</p>
        </div>
    </div>
    <?php } ?>
    
</div>
</body>
</html>