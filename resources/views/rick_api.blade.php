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
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/guardados">Ir a guardados</a></li>
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
                echo '<tr>';
                if( $personaje['saved'] == 1 ){
                  echo '
                  <td>
                    <button type="button" class="btn btn-dark btn-sm" disabled>Guardado</button>                    
                    <button type="button" id="btn_save_'.$personaje['id'].'" class="btn btn-info btn-sm" onclick="verPersonaje('.$personaje['id'].',1)">Ver completo</button>
                  </td>';
                }else if( $personaje['saved'] == 0 ){
                  echo '
                  <td>
                    <button type="button" id="btn_save_'.$personaje['id'].'" class="btn btn-primary btn-sm" onclick="guardarPersonaje('.$personaje['id'].',1)"> Guardar </button> 
                    <button type="button" class="btn btn-info btn-sm" onclick="verPersonaje('.$personaje['id'].')">Ver completo</button>
                  </td>';
                }
                
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
      
      <div class="d-flex justify-content-end">
          
        
        <nav aria-label="...">
          <ul class="pagination pagination-sm">
            
            
            <?php
              foreach ( [1,2,3,4,5] as $_page ){
                if( $_page == $page ){
                  echo '<li class="page-item active" aria-current="page"> <span class="page-link">'.$_page.'</span></li>';
                }else{
                  echo '<li class="page-item"><a class="page-link" href="?page='.$_page.'">'.$_page.'</a></li>';
                }
              }
            ?>
            
          </ul>
        </nav>

      </div>

    </div>
  </section>
    
  @include('prefabs.footer')
  
  @include('prefabs.detail_character')

  @include('prefabs.imports')
  
</body>

</html>