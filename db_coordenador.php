<?php
include('include/connect.php');
$msg = "";

if(isset($_GET['cadastrar'])) {
    
    try {
        $primeiroNome = utf8_decode(addslashes($_POST['nome']));
        $nomeCompleto = utf8_decode(addslashes($_POST['nome'].' '.$_POST['sobrenome']));
        $email = utf8_decode(addslashes($_POST['email']));
        $usuario_id = $_POST['usuario'];
        $descricao = utf8_decode(addslashes($_POST['descricao']));
        $arqNome = "";
        
        if($_FILES["foto"]["error"] == 0){
            $foto = $_FILES['foto'];
            $diretorio = "uploads/";

                if(!file_exists($diretorio)){
                    mkdir($diretorio);
                }
            $arqNome = $diretorio.$foto['name'];
            move_uploaded_file($foto['tmp_name'], $arqNome);
        }
        else if ($_FILES["foto"]["error"] > 0) {
            $msg .= "Houve um erro com a imagem que você selecionou.<br>";
        } else {
            $arqNome = "";
        }

        $insert = "INSERT INTO tb_coordenador (coo_primeiro_nome, coo_nome_completo, coo_email, usu_id, coo_descricao, coo_foto) 
        VALUES ('$primeiroNome', '$nomeCompleto', '$email', '$usuario_id', '$descricao', '$arqNome')";
        $query = mysqli_query($conn, $insert);
        if($query) $msg .= "Coordenador cadastrado com sucesso<br>";
        else $msg .= "Erro ao cadastrar coordenador<br>";

        $select = "SELECT coo_id as id FROM tb_coordenador ORDER BY coo_id DESC LIMIT 1";
        $query = mysqli_query($conn, $select);
        $fetch = mysqli_fetch_assoc($query);
        $coo_id = $fetch['id'];

        $projetos = $_POST['projetos'];

        foreach($projetos as $proj) {
            $insert = "INSERT INTO tb_projeto_coordenador (prj_id, coo_id) VALUES ('$proj', '$coo_id')";
            $query = mysqli_query($conn, $insert);
            
            $selectProf = mysqli_query($conn, "SELECT DISTINCT t2.prof_Id as id FROM tb_turma t1 INNER JOIN tb_professorturma t2 ON t2.turma_Id = 
            t1.turma_Id WHERE t1.proj_Id = '$proj'");
            while($dados = mysqli_fetch_assoc($selectProf)) {
                $prof = $dados['id'];
                $insert = mysqli_query($conn, "INSERT INTO tb_professor_coordenador (pro_id, coo_id) VALUES ('$prof', '$coo_id')");
            }
        }

        mysqli_close($conn);

        $_SESSION['msg'] = $msg;
        header('Location: novoCoordenador.php');
        die();
    } catch (Exception $e) {
        $_SESSION['msg'] = 'Houve um erro ao cadastrar o coordenador: '.$e->getMessage();
        header('Location: novoCoordenador.php');
        die();
    }

} else if (isset($_GET['atualizar'])) {
    
    try {    
        $id = $_POST['id'];
        $primeiroNome = utf8_decode(addslashes($_POST['nome']));
        $nomeCompleto = utf8_decode(addslashes($_POST['nomeCompleto']));
        $email = utf8_decode(addslashes($_POST['email']));
        $descricao = utf8_decode(addslashes($_POST['descricao']));

        $update = "UPDATE tb_coordenador SET coo_primeiro_nome = '$primeiroNome', coo_nome_completo = '$nomeCompleto', 
        coo_email = '$email', coo_descricao = '$descricao', coo_data_alteracao = NOW() WHERE coo_id = '$id'";
        $query = mysqli_query($conn, $update);

        $projetos = $_POST['projetos'];
            if(sizeof($projetos) > 0) {
                $delete = "DELETE FROM tb_projeto_coordenador WHERE coo_id = '$id'";
                $query = mysqli_query($conn, $delete);

                $delete = "DELETE FROM tb_professor_coordenador WHERE coo_id = '$id'";
                $query = mysqli_query($conn, $delete);
                foreach($projetos as $proj) {
                    $insert = "INSERT INTO tb_projeto_coordenador (prj_id, coo_id) VALUES ('$proj', '$id')";
                    $query = mysqli_query($conn, $insert);
                    
                    $selectProf = mysqli_query($conn, "SELECT DISTINCT t2.prof_Id as id FROM tb_turma t1 INNER JOIN tb_professorturma t2 ON t2.turma_Id = 
                    t1.turma_Id WHERE t1.proj_Id = '$proj'");
                    while($dados = mysqli_fetch_assoc($selectProf)) {
                        $prof = $dados['id'];
                        $insert = mysqli_query($conn, "INSERT INTO tb_professor_coordenador (pro_id, coo_id) VALUES ('$prof', '$id')");
                    }
                }
            }
        $_SESSION['msg'] = "Coordenador atualizado com sucesso";
        header('Location: verCoordenador.php?id='.$id);
        die();
    } catch (Exception $e) {
        $_SESSION['msg'] = 'Houve um erro ao atualizar o coordenador: '.$e->getMessage();
        header('Location: verCoordenador.php?id='.$id);
        die();
    }

} else if (isset($_GET['deletar'])) {
    
    try {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $delete = "DELETE FROM tb_coordenador WHERE coo_id = '$id'";
            $query = mysqli_query($conn, $delete);
            
            $_SESSION['msg'] = "Coordenador excluído com sucesso";
            header('Location: todosCoordenadores.php?');
            die();
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = 'Houve um erro ao deletar o coordenador: '.$e->getMessage();
        header('Location: verCoordenador.php?id='.$id);
        die();
    }

} else if (isset($_GET['foto'])) {
    
    $id = $_POST['id'];
    $arqNome = "";
        
    if($_FILES["foto"]["error"] == 0){
        $foto = $_FILES['foto'];
        $diretorio = "uploads/";

            if(!file_exists($diretorio)){
                mkdir($diretorio);
            }
        $arqNome = $diretorio.$foto['name'];
        move_uploaded_file($foto['tmp_name'], $arqNome);
    } else {
        $arqNome = "";
    }

    $update = "UPDATE tb_coordenador SET coo_foto = '$arqNome' WHERE coo_id = '$id'";
    $query = mysqli_query($conn, $update);

    $_SESSION['msg'] = "Foto atualizado com sucesso";
    header('Location: verCoordenador.php?id='.$id);
    die();

} else {
    mysqli_close($conn);
    header('Location: index.php');
}
?>