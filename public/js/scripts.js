/*!
* Start Bootstrap - Freelancer v7.0.7 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 
let personaje_selected = 0;
window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

function editarPersonaje( _id = 0 ){
  if( _id == 0 )return;
  window.location.href="/editCharacter/"+_id;
}//fin de ir a editar

function actualizarPersonaje(){
  
  const elements = document.querySelectorAll(".lhelps");
  elements.forEach(_sp => {
    _sp.classList.add("d-none");
  });

  const form = document.getElementById("charForm");
  const _data = {
    "id": form.querySelector("#id").value,
    "name": form.querySelector("#name").value,
    "status": form.querySelector("#status").value,
    "species": form.querySelector("#species").value,
    "type": form.querySelector("#type").value,
    "gender": form.querySelector("#gender").value,
    "origin": form.querySelector("#origin").value
  };
  
  let _total_errors = 0;

  if(_data.name == ""){
    _total_errors+=1;
    document.getElementById("name-help").classList.remove("d-none");
  }

  if(_data.status == ""){
    _total_errors+=1;
    document.getElementById("status-help").classList.remove("d-none");
  }

  if( _total_errors > 0 )return;

  console.log( _data );
  // return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch('/updateCharacter', {
    method: "POST", 
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify(_data)
  })
  .then(response => response.json())
  .then((result) => {

    console.log( "result actualizado" );
    console.log( result );

    if( result.done ){
            
      Swal.fire({
        title: result.msg,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Seguir actualizando",
        denyButtonText: `Volver al listado de guardados`,
      }).then((result) => {
        
        if (result.isConfirmed) {
          location.reload();
        } else if (result.isDenied) {
          window.location.href="/guardados";
        }
      });

    }else{
      
      Swal.fire({
        title: "Error",
        text: result.msg,
        icon: "error",
      });

    }

  }).catch(error => {

    console.log( "error" );
    console.log( error );

  });

}//fin de la actualizacion

function verPersonaje( _id = 0, _origin = 1 ){
  // console.log( "a ver personaje", _id );
  if( _id == 0 )return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


  fetch('/getCharacter', {
    method: "POST", 
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify({"id":_id, "origin":_origin }) 
  })
  .then(response => response.json())
  .then((result) => {

    let _html=``;

    for (let _key in result.data ) {

      let _val = result.data[ _key ];   
      
      if( _key != "Img" ){
        _html+=`<p><b>${_key}</b>: ${_val}</p>`;
      }else{
        _html+=`<p><img src="${_val}" width="200" height="auto"></p>`;
      }
      
    };
    
    document.getElementById("charDescription").innerHTML=_html;
    
    let modal = new bootstrap.Modal(document.getElementById("charModal"));
    modal.show();

  }).catch(error => {

    console.log( "error" );
    console.log( error );

  });

}//fin de verPersonaje

function guardarPersonaje( _id = 0 ){
  console.log( "a ver personaje", _id );
  if( _id == 0 )return;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch('/saveCharacter', {
    method: "POST", 
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify({"id":_id}) 
  })
  .then(response => response.json())
  .then((result) => {

    if( result.done ){
      let _btn = document.getElementById("btn_save_"+_id);
      _btn.innerHTML="Guardado";      
      _btn.classList.remove("btn-primary");
      _btn.classList.add("btn-dark");      
      
      Swal.fire({
        title: "Alerta",
        text: result.msg,
        icon: "success",
      });

    }else{
      
      Swal.fire({
        title: "Alerta",
        text: result.msg,
        icon: "error",
      });

    }

  }).catch(error => {

    console.log( "error" );
    console.log( error );

  });

}//fin de verPersonaje

function borrarPersonajeConfirm(){
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch('/deleteCharacter', {
    method: "POST", 
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify({"id":personaje_selected}) 
  })
  .then(response => response.json())
  .then((result) => {

    if( result.done ){
      //borrar la fila como tal...  
      document.getElementById("personaje_"+personaje_selected).remove();
      Swal.fire({
        title: "Alerta",
        text: result.msg,
        icon: "success",
      });

    }else{
      
      Swal.fire({
        title: "Alerta",
        text: result.msg,
        icon: "error",
      });

    }

  }).catch(error => {

    console.log( "error" );
    console.log( error );

  });
}//fin de borrarPersonaje Confirmado

function borrarPersonaje( _id = 0 ){
  console.log( "a borrar personaje", _id );
  personaje_selected = _id;

  Swal.fire({
    title: "Estas seguro ?",
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: "Si, borrar",
    denyButtonText: `Cancelar`,
  }).then((result) => {
    
    if (result.isConfirmed) {
      borrarPersonajeConfirm();
    }
  });

}//fin de borrarPersonaje