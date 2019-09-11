<?php

    include('../include/connect.php');

    $idProf = $_POST['id'];


    $userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
    $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
    $query = mysqli_query($conn, $select);

    if(mysqli_num_rows($query) == 0) {
        $_SESSION['msg'] = "Hmmm... parece que você não tem permissão de adicionar observações";
        header('Location: verProfessor.php?id='.$idProf);
        die();
    }

    $dados = mysqli_fetch_assoc($select);
    $idCoo = $dados['id'];

    $comprometimento = utf8_decode(addslashes($_POST['comprometimento']));
    $dificuldades = utf8_decode(addslashes($_POST['dificuldades']));
    $potencialidade = utf8_decode(addslashes($_POST['potencialidade']));
    $responsabilidade = utf8_decode(addslashes($_POST['responsabilidade']));
    $emocional = utf8_decode(addslashes($_POST['emocional']));
    $cooperacao = utf8_decode(addslashes($_POST['cooperacao']));
    $dialogo = utf8_decode(addslashes($_POST['dialogo']));
    $empatia = utf8_decode(addslashes($_POST['empatia']));
    $etico = utf8_decode(addslashes($_POST['etico']));
    $tolerancia = utf8_decode(addslashes($_POST['tolerancia']));
    $concentracao = utf8_decode(addslashes($_POST['concentracao']));
    $interpretacao = utf8_decode(addslashes($_POST['interpretacao']));
    $metodologia = utf8_decode(addslashes($_POST['metodologia']));
    $conhecimento = utf8_decode(addslashes($_POST['conhecimento']));
    $compartilha = utf8_decode(addslashes($_POST['compartilha']));
    $problemas = utf8_decode(addslashes($_POST['problemas']));
    $tarefas = utf8_decode(addslashes($_POST['tarefas']));
    $intencionalidade = utf8_decode(addslashes($_POST['intencionalidade']));
    $organizacao = utf8_decode(addslashes($_POST['organizacao']));
    $grupo = utf8_decode(addslashes($_POST['grupo']));

    $insert = "INSERT INTO tb_avaliacao_observacoes (pro_id, coo_id, obs_comprometimento, obs_dificuldades, obs_potencialidades, 
    obs_emocional, obs_cooperacao, obs_responsabilidade, obs_clareza, obs_empatia, obs_etica, obs_tolerancia, obs_concentracao, 
    obs_contexto, obs_metodologia, obs_conhecimento, obs_ideias, obs_problemas, obs_tarefas, obs_intencionalidade,
    obs_organizacao, obs_grupo) VALUES ('$idProf', '$idCoo', '$comprometimento', '$dificuldades', '$potencialidade', '$emocional', 
    '$cooperacao', '$responsabilidade', '$dialogo', '$empatia', '$etico', '$tolerancia', '$concentracao', '$interpretacao', 
    '$metodologia', '$conhecimento', '$compartilha', '$problemas', '$tarefas', '$intencionalidade', '$organizacao', '$grupo')";
    $query = mysqli_query($conn, $insert);
    if($query) {
        $_SESSION['msg'] = "Observações salvas com sucesso";
    } else {
        $_SESSION['msg'] = "Houve um erro ao salvar as observações<br>".mysqli_error($conn);
    }

    header('Location: ../verProfessor.php?id='.$idProf);
        
    die();
?>