<?php
    
        session_start();
    
    $conn = mysqli_connect('servidor.taubate.sp.gov.br', 'taubates_seel', 'esportes@2017', 'taubates_seel');

    if(!$conn) {
        echo '
        <script>
            alert("Houve algum erro na conexão com o banco de dados da Secretaria de Esportes e Lazer. Tente
            novamente mais tarde");
        ';
    }

?>