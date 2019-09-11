<?php

    include('../include/connect.php');

    $idProf = $_POST['idProf'];
    $userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
    $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
    $query = mysqli_query($conn, $select);

    if(mysqli_num_rows($query) == 0) {
        $_SESSION['msg'] = "Hmmm... parece que você não pode avaliar um professor";
        header('Location: verProfessor.php?id='.$idProf);
        die();
    }

    $dados = mysqli_fetch_assoc($select);
    $idCoo = $dados['id'];

    $saudeProf = utf8_decode(addslashes($_POST['saudeProf']));
    $vontadeProf = utf8_decode(addslashes($_POST['vontadeProf']));
    $transformaProf = utf8_decode(addslashes($_POST['transformaProf']));
    $otimismoProf = utf8_decode(addslashes($_POST['otimismoProf']));
    $criticoProf = utf8_decode(addslashes($_POST['criticoProf']));
    $engajadoProf = utf8_decode(addslashes($_POST['engajadoProf']));
    $liderancaProf = utf8_decode(addslashes($_POST['liderancaProf']));
    $autoestimaProf = utf8_decode(addslashes($_POST['autoestimaProf']));
    $pacienteProf = utf8_decode(addslashes($_POST['pacienteProf']));
    $pegarProf = utf8_decode(addslashes($_POST['pegarProf']));
    $preocupaProf = utf8_decode(addslashes($_POST['preocupaProf']));
    $ouvirProf = utf8_decode(addslashes($_POST['ouvirProf']));

    $comprometimento = $_POST['comprometimento'];
    $obsComprometimento = utf8_decode(addslashes($_POST['obsComprometimento']));

    $dificuldades = $_POST['dificuldades'];
    $obsDificuldades = utf8_decode(addslashes($_POST['obsDificuldades']));

    $potencialidades = $_POST['potencialidades'];
    $obsPotencialidades = utf8_decode(addslashes($_POST['obsPotencialidades']));

    $emocional = $_POST['emocional'];
    $obsEmocional = utf8_decode(addslashes($_POST['obsEmocional']));

    $responsabilidade = $_POST['responsabilidade'];
    $obsResponsabilidade = $_POST['obsResponsabilidade'];

    $cooperacao = $_POST['cooperacao'];
    $obsCooperacao = utf8_decode(addslashes($_POST['obsCooperacao']));;

    $clareza = $_POST['clareza'];
    $obsClareza = utf8_decode(addslashes($_POST['obsClareza']));

    $empatia = $_POST['empatia'];
    $obsEmpatia = utf8_decode(addslashes($_POST['obsEmpatia']));

    $etica = $_POST['etica'];
    $obsEtica = utf8_decode(addslashes($_POST['obsEtica']));

    $tolerancia = $_POST['tolerancia'];
    $obsTolerancia = utf8_decode(addslashes($_POST['obsTolerancia']));

    $concentracao = $_POST['concentracao'];
    $obsConcentracao = utf8_decode(addslashes($_POST['obsConcentracao']));

    $contexto = $_POST['contexto'];
    $obsContexto = utf8_decode(addslashes($_POST['obsContexto']));

    $metodologia = $_POST['metodologia'];
    $obsMetodologia = utf8_decode(addslashes($_POST['obsMetodologia']));

    $conhecimento = $_POST['conhecimento'];
    $obsConhecimento = utf8_decode(addslashes($_POST['obsConhecimento']));

    $ideias = $_POST['ideias'];
    $obsIdeias = utf8_decode(addslashes($_POST['obsIdeias']));

    $problemas = $_POST['problemas'];
    $obsProblemas = utf8_decode(addslashes($_POST['obsProblemas']));

    $tarefas = $_POST['tarefas'];
    $obsTarefas = utf8_decode(addslashes($_POST['obsTarefas']));

    $intencionalidade = $_POST['intencionalidade'];
    $obsIntencionalidade = utf8_decode(addslashes($_POST['obsIntencionalidade']));

    $organizacao = $_POST['organizacao'];
    $obsOrganizacao = utf8_decode(addslashes($_POST['obsOrganizacao']));

    $grupo = $_POST['grupo'];
    $obsGrupo = utf8_decode(addslashes($_POST['obsGrupo']));
    $liberada = date('Y-m-d H:i:s', strtotime('+30 days')); //PADRÃO DE 30 dias PARA LIBERAÇÃO
    
    $insert = "INSERT INTO tb_avaliacao_qualitativa (coo_id, pro_id, ava_data_liberacao, ava_saude, ava_vontade, 
    ava_transformacao, ava_otimista, 
    ava_critico, ava_engajado, ava_lideranca, ava_autoestima, ava_paciente, ava_parasi, ava_preocupado, ava_ouvinte, 
    ava_comprometimento, ava_obs_comprometimento, ava_dificuldades, ava_obs_dificuldades, ava_potencialidades, 
    ava_obs_potencialidades, ava_controle_emocional, ava_obs_controle_emocional, ava_responsabilidade, 
    ava_obs_responsabilidade, ava_cooperacao, ava_obs_cooperacao, ava_dialogo, ava_obs_dialogo, ava_empatia, 
    ava_obs_empatia, ava_etico, ava_obs_etico, ava_tolerancia, ava_obs_tolerancia, ava_concentracao, ava_obs_concentracao, 
    ava_contexto, ava_obs_contexto, ava_metodologia, ava_obs_metodologia, ava_amplia, ava_obs_amplia, ava_compartilha, 
    ava_obs_compartilha, ava_problemas, ava_obs_problemas, ava_tarefas, ava_obs_tarefas, ava_intencionalidade, 
    ava_obs_intencionalidade, ava_organizacao, ava_obs_organizacao, ava_grupo, ava_obs_grupo) VALUES ('$idCoo', '$idProf', 
    '$liberada', '$saudeProf', '$vontadeProf', '$transformaProf', '$otimismoProf', '$criticoProf', '$engajadoProf', 
    '$liderancaProf', '$autoestimaProf', '$pacienteProf', '$pegarProf', '$preocupaProf', '$ouvirProf', 
    '$comprometimento', '$obsComprometimento', 
    '$dificuldades', '$obsDificuldades', '$potencialidades', '$obsPotencialidades', '$emocional', '$obsEmocional', 
    '$responsabilidade', '$obsResponsabilidade', '$cooperacao', '$obsCooperacao', '$clareza', '$obsClareza', 
    '$empatia', '$obsEmpatia', '$etica', '$obsEtica', '$tolerancia', '$obsTolerancia', '$concentracao', '$obsConcentracao', 
    '$contexto', '$obsContexto', '$metodologia', '$obsMetodologia', '$conhecimento', '$obsConhecimento', '$ideias', 
    '$obsIdeias', '$problemas', '$obsProblemas', '$tarefas', '$obsTarefas', '$intencionalidade', '$obsIntencionalidade', 
    '$organizacao', '$obsOrganizacao', '$grupo', '$obsGrupo')";

    $query = mysqli_query($conn, $insert);

    if($query) {
        $_SESSION['msg'] = "Avaliação salva com sucesso";
        header('Location: ../verProfessor.php?id='.$idProf);
        mysqli_close($conn);
        die();
    } else {
        $_SESSION['msg'] = "Houve um problema ao salvar a avaliação<br>".mysqli_error($conn);
        header('Location: ../verProfessor.php?id='.$idProf);
        mysqli_close($conn);
    }

?>