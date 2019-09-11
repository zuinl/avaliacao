<?php
include('../meta/meta.php');
//include('../include/connect.php');
include('../include/navbar.php');

if(!isset($_GET['id'])) {
    header('Location: ../todosProfessores.php');
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
$nome = $_GET['nome'];
?>
<html>
<head>
    <title>Observações para <?php echo $nome; ?></title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-1">
            <a onclick="window.history.go(-1)" href="#"><button class="button button3" style="font-size: 0.8em;">Voltar</button></a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="margin-top: 1em;">
            <h1 class="high-text">Observações de campos para <i><span class="destaque-text"><?php echo $nome; ?></span></i></h1>
        </div>
    </div>

    <hr class="hr-divide">

    <form action="db_observacoes.php" method="POST">
    <div class="row">
        <div class="col-sm-2 offset-sm-4">
            <h1 class="destaque-text">SER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-4">
            <label>Comprometimento</label>
            <textarea  maxlength="300" class="form-control" name="comprometimento"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Conhecimento de suas dificuldades</label>
            <textarea  maxlength="300" class="form-control" name="dificuldades"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Reconhecimento de suas potencialidades</label>
            <textarea  maxlength="300" class="form-control" name="potencialidade"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label>Responsabilidade</label>
            <textarea  maxlength="300" class="form-control" name="responsabilidade"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Controle emocional</label>
            <textarea  maxlength="300" class="form-control" name="emocional"></textarea>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-3 offset-sm-4">
            <h1 class="destaque-text">CONVIVER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-4">
            <label>Cooperação</label>
            <textarea  maxlength="300" class="form-control" name="cooperacao"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Diálogo com clareza</label>
            <textarea  maxlength="300" class="form-control" name="dialogo"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Empatia</label>
            <textarea  maxlength="300" class="form-control" name="empatia"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label>Agir de forma ética</label>
            <textarea  maxlength="300" class="form-control" name="etico"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Tolerância</label>
            <textarea  maxlength="300" class="form-control" name="tolerancia"></textarea>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-3 offset-sm-4">
            <h1 class="destaque-text">CONHECER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-4">
            <label>Concentração</label>
            <textarea  maxlength="300" class="form-control" name="concentracao"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Interpretação do contexto</label>
            <textarea  maxlength="300" class="form-control" name="interpretacao"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Conhecimento metodológico institucional</label>
            <textarea  maxlength="300" class="form-control" name="metodologia"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label>Amplia seu conhecimento</label>
            <textarea  maxlength="300" class="form-control" name="conhecimento"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Compartilha suas ideias</label>
            <textarea  maxlength="300" class="form-control" name="compartilha"></textarea>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-3 offset-sm-4">
            <h1 class="destaque-text">FAZER</h1>
        </div>
    </div>

    <hr class="hr-divide-light">

    <div class="row">
        <div class="col-sm-4">
            <label>Solução de problemas</label>
            <textarea  maxlength="300" class="form-control" name="problemas"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Compartilha tarefas</label>
            <textarea  maxlength="300" class="form-control" name="tarefas"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Planeja com intencionalidade</label>
            <textarea  maxlength="300" class="form-control" name="intencionalidade"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label>Organização</label>
            <textarea  maxlength="300" class="form-control" name="organizacao"></textarea>
        </div>
        <div class="col-sm-4">
            <label>Produz em grupo</label>
            <textarea  maxlength="300" class="form-control" name="grupo"></textarea>
        </div>
    </div>

    <hr class="hr-divide">

    <div class="row">
        <div class="col-sm-12">
            <h5 class="text"><b>IMPORTANTE:</b> essas observações são privadas dos(as) coordenadores(as), para auxiliar na hora da avaliação.</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 offset-sm-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input class="button button1" style="font-size: 1.5em;" value="Salvar observações" type="submit">
        </div>
    </div>
    </form>    
</div>
</body>
</html>