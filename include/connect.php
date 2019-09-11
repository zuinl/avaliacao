<?php
    
        session_start();
    
    $conn = mysqli_connect('localhost', 'root', '', 'db_avaliacao');

    if(!$conn) {
        echo '
        <script>
            alert("Houve algum erro na conexão com o banco de dados da Secretaria de Esportes e Lazer. Tente
            novamente mais tarde");
        ';
    }

?>
