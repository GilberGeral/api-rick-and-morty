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
          <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="/guardados">Volver al listado</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <section class="page-section portfolio" id="portfolio">
    <div class="container">
      
      <h2 class="page-section-heading text-center text-uppercase text-secondary m-3">Editar personaje : <b class="text-info">{{ $personaje->name }}</b></h2>
      <hr>
      <div class="row justify-content-center">
        
        <div class="col-12 col-sm-12 col-md-6">

          <form id="charForm" name="charForm" method="post" >
            <input type="hidden" id="id" name="id" value="{{ $personaje->id }}">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="name" value="{{ $personaje->name }}">
              <small id="name-help" name="name-help" class="lhelps form-text text-danger d-none">El nombre del personaje es necesario</small>
            </div>
            
            <div class="mb-3">
              <label for="status" class="form-label">Estado</label>
              <input type="text" class="form-control" id="status" value="{{ $personaje->status }}">
              <small id="status-help" name="status-help" class="lhelps form-text text-danger d-none">El estado del personaje es necesario</small>
            </div>

            <div class="mb-3">
              <label for="species" class="form-label">Especie</label>
              <input type="text" class="form-control" id="species" value="{{ $personaje->species }}">
            </div>

            <div class="mb-3">
              <label for="type" class="form-label">Tipo</label>
              <input type="text" class="form-control" id="type" value="{{ $personaje->type }}">
            </div>

            <div class="mb-3">
              <label for="gender" class="form-label">Genero</label>
              <input type="text" class="form-control" id="gender" value="{{ $personaje->gender }}">
            </div>

            <div class="mb-3">
              <label for="origin" class="form-label">Origen</label>
              <input type="text" class="form-control" id="origin" value="{{ $personaje->origin }}">
            </div>

            
          </form>
          <button type="button" class="btn btn-primary" onclick="actualizarPersonaje()">Actualizar</button>
        </div>

        <div class="col-12 col-sm-12 col-md-6">
          <div class="mt-3">
            <img src="https://rickandmortyapi.com/api/{{ $personaje->image }}" width="420" height="auto">
          </div>
        </div>


      </div>
      
    </div>
  </section>
    
  @include('prefabs.footer')
  
  @include('prefabs.detail_character')

  @include('prefabs.imports')
  
</body>

</html>