<!DOCTYPE html>
<html lang="en">

<head>
  @include('prefabs.header')
</head>

<body id="page-top">
  
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="#page-top">Rick and Morty</a>
      <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/">Ir a listado</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <section class="page-section portfolio" id="portfolio">
    <div class="container">
      
      <h2 class="page-section-heading text-center text-uppercase text-secondary m-3">Personajes</h2>
      <hr>
      <div class="row justify-content-center">
        
        <table class="table">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Estado</th>
              <th scope="col">Especie</th>
            </tr>
          </thead>
          <tbody>
            
            <?php
              foreach ( $personajes as $personaje ){
                echo '<tr id="personaje_'.$personaje['id'].'">';
                
                echo '
                <td>
                  <button type="button" id="btn_delete_'.$personaje['id'].'" class="btn btn-danger btn-sm" onclick="borrarPersonaje('.$personaje['id'].')"> Borrar </button> 
                  <button type="button" id="btn_save_'.$personaje['id'].'" class="btn btn-warning btn-sm" onclick="editarPersonaje('.$personaje['id'].')"> Editar </button> 
                  <button type="button" class="btn btn-info btn-sm" onclick="verPersonaje('.$personaje['id'].',2)">Ver completo</button>
                </td>';
                                
                echo '<td>'.$personaje['id'].'</td>';
                echo '<td>'.$personaje['name'].'</td>';
                echo '<td>'.$personaje['status'].'</td>';
                echo '<td>'.$personaje['species'].'</td>';
                echo '</tr>';
              }
            ?>
           
          </tbody>

        </table>

      </div>
      
    </div>
  </section>
    
  @include('prefabs.footer')
  
  @include('prefabs.detail_character')

  @include('prefabs.imports')
  
</body>

</html>