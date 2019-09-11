<?php

    include('../include/connect.php');

    if(!isset($_GET['ata_id'])) {
        echo 'Sem permissão de acesso';
        mysqli_close($conn);
        die();
    }

    $ata_id = $_GET['ata_id'];

    $idProf = $_POST['idProf'];

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

    $update = "UPDATE tb_autoavaliacao_qualitativa SET ata_preenchida = 1, ata_saude = '$saudeProf', ata_vontade = '$vontadeProf', 
    ata_transformacao = '$transformaProf', ata_otimista = '$otimismoProf', ata_critico = '$criticoProf', 
    ata_engajado = '$engajadoProf', ata_lideranca = '$liderancaProf', ata_autoestima = '$autoestimaProf', 
    ata_paciente = '$pacienteProf', ata_parasi = '$pegarProf', ata_preocupado = '$preocupaProf', 
    ata_ouvinte = '$ouvirProf', ata_comprometimento = '$comprometimento', ata_obs_comprometimento = '$obsComprometimento', 
    ata_dificuldades = '$dificuldades', ata_obs_dificuldades = '$obsDificuldades', ata_potencialidades = '$potencialidades', 
    ata_obs_potencialidades = '$obsPotencialidades', ata_controle_emocional = '$emocional', ata_obs_controle_emocional = '$obsEmocional', 
    ata_responsabilidade = '$responsabilidade', ata_obs_responsabilidade = '$obsResponsabilidade', 
    ata_cooperacao = '$cooperacao', ata_obs_cooperacao = '$obsCooperacao', ata_dialogo = '$clareza', 
    ata_obs_dialogo = '$obsClareza', ata_empatia = '$empatia', ata_obs_empatia = '$obsEmpatia', ata_etico = '$etica', 
    ata_obs_etico = '$obsEtica', ata_tolerancia = '$tolerancia', ata_obs_tolerancia = '$obsTolerancia', 
    ata_concentracao = '$concentracao', ata_obs_concentracao = '$obsConcentracao', ata_contexto = '$contexto', 
    ata_obs_contexto = '$obsContexto', ata_metodologia = '$metodologia', ata_obs_metodologia = '$obsMetodologia', 
    ata_amplia = '$conhecimento', ata_obs_amplia = '$obsConhecimento', ata_compartilha = '$ideias', 
    ata_obs_compartilha = '$obsIdeias', ata_problemas = '$problemas', ata_obs_problemas = '$obsProblemas', 
    ata_tarefas = '$tarefas', ata_obs_tarefas = '$obsTarefas', ata_intencionalidade = '$intencionalidade', 
    ata_obs_intencionalidade = '$obsIntencionalidade', ata_organizacao = '$organizacao', 
    ata_obs_organizacao = '$obsOrganizacao', ata_grupo = '$grupo', ata_obs_grupo = '$obsGrupo' WHERE ata_id = '$ata_id'";

    $query = mysqli_query($conn, $update);

    if($query) {
        $_SESSION['msg'] = "Autoavaliação salva com sucesso";
        header('Location: ../verProfessor.php?id='.$idProf);
        mysqli_close($conn);
        die();
    } else {
        $_SESSION['msg'] = "Houve um problema ao salvar a autoavaliação<br>".mysqli_error($conn);
        header('Location: ../verProfessor.php?id='.$idProf);
        mysqli_close($conn);
    }

?>