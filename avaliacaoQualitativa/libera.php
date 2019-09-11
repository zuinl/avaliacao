<?php

    include('../include/connect.php');

    if(!isset($_GET['id'])) {
        header('Location: ../todosProfessores.php');
        mysqli_close($conn);
        die();
    }

    $idProf = $_GET['id'];

    if(isset($_GET['avaliacao'])) {
        $update = "UPDATE tb_avaliacao_qualitativa SET ava_liberada = 1 WHERE pro_id = '$idProf'";
        $query = mysqli_query($conn, $update);

        $_SESSION['msg'] = "Todas as avaliações do professor foram liberadas";
        mysqli_close($conn);
        header('Location: ../verProfessor.php?id='.$idProf);
        die();
    }

    if(isset($_GET['autoavaliacao'])) {
        $insert = "INSERT INTO tb_autoavaliacao_qualitativa (pro_id) VALUES ('$idProf')";
        $query = mysqli_query($conn, $insert);

        $_SESSION['msg'] = "Uma autoavaliação foi liberada para o professor";
        mysqli_close($conn);
        header('Location: ../verProfessor.php?id='.$idProf);
        die();
    }

?>