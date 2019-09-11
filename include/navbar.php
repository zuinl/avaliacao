<?php
  $userId = $_SESSION['user']['id']; //ATUALIZAR COM $_SESSION
  $select = "SELECT coo_id FROM tb_coordenador WHERE usu_id = '$userId'";
  $query = mysqli_query($conn, $select);
  
  if(mysqli_num_rows($query) > 0) {
      $isCoordenador = 1;
  } else {
      $isCoordenador = 0;
  }
?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="position: fixed;top: 0; width: 100%;">
  <a class="navbar-brand high-text" href="index.php">Mural dos professores</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link high-text" href="/avaliacao/index.php">Início <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Professores
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/avaliacao/todosProfessores.php">Ver todos</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Projetos
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="/avaliacao/todosProjetos.php">Ver todos</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Coordenadores
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php if($isCoordenador == 1) { ?>
          <a class="dropdown-item" href="/avaliacao/novoCoordenador.php">Novo coordenador</a>
        <?php } ?>
          <a class="dropdown-item" href="/avaliacao/todosCoordenadores.php">Ver todos</a>
          <!-- <a class="dropdown-item" href="/avaliacao/lancarFrequencia.php">Lançar frequências</a> -->
          <!-- <a class="dropdown-item" href="/avaliacao/ajustarCapacidade.php">Ajustar capacidade</a> -->
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">Meus dados</a>
      </li> -->
      <li class="nav-item">
        <a href="http://taubate.sp.gov.br/secretarias/seel/sistema/admin/index.php"><button class="btn btn-warning" style="font-size: 0.8em;">Voltar ao sistema</button></a>
      </li>
    </ul>
  </div>
</nav>