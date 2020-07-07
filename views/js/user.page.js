$('.user-profile').change(function(){

  var image = this.files[0];

  if(image['type'] != 'image/jpeg' && image['type'] != 'image/png'){

    $('.user-profile').val('');
    $.notiny({ text: "El archivo selecionado no coincide con los formatos de imagen validos, jpeg/png.",
               theme: "danger", position: "right-top", title:"Error al cargar la imagen", delay:4000});

  }else if(image['size'] > 20971520){

    $.notiny({ text: "El archivo selecionado supera el tamaño permitido de 20MB.",
               theme: "danger", position: "right-top", title:"Error al cargar la imagen", delay:4000});

  }else {

    var imageData = new FileReader;
    imageData.readAsDataURL(image);
    $(imageData).on('load', function(){
      var imagePath = event.target.result;
      $('.img-prev').attr('src',imagePath);
    });

    $.notiny({ text: "Imagen cargada correctamente.",
               theme: "light", position: "right-top", title:"Éxito"});

  }
});

$(document).on("click",".edit-user",function(){
  var formData = new FormData();
  var userID = $(this).attr("user-id");

  formData.append("userID",userID);
  resetUserForm();

  $.ajax({
    url:"ajax/user.ajax.php",
    method: "POST",
    data: formData,
    cache:false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      //Alter html form with response information
      $('#userName').val(response["user_name"]);
      $('#userFullName').val(response["full_name"]);
      $('#userRol').val(response["profile"]);
      //Load image of response
      $('.img-prev').attr("src",response["picture"]);
      //Define that the user form is for edition of user registry in database
      $('#opc').val("1:"+response["user_id"]);

      //Add new input hidden with before password
      $('#userForm').append('<input type="hidden" name="currentPassword" id="currentPassword" value="'+
      response["password"]+'"/>');
      //Add new input hidden with current image
      $('#userForm').append('<input type="hidden" name="currentImage" id="currentImage" value="'+
      response["picture"]+'"/>');

      $('#formTitle').html('<i class="fa fa-edit"></i> Editando datos del usuario <b id="userNameTitle">'+response["user_name"]+'</b>');
      $('#userPassword').removeAttr("required");

      if($('#boxUserForm').hasClass('collapsed-box')){
        $('#btnFormUser').click();
      }
      //Edit name of buttons form
      $('#reset').html("Cancelar edición");
      $('#save').html("Modificar usuario");
    },
    error: function(response){
      showErrorMessage(response);
    }
  });
});

/**
 * This method is to completely reset the user form.
 **/
function resetUserForm(){
  $('#currentPassword').remove();
  $('#currentImage').remove();
  $('#userPassword').attr("required");
  $('#opc').val("0");
  $('#reset').html("Cancelar registro");
  $('#save').html("Nuevo registro");
  $('#formTitle').html('<i class="fa fa-user-plus"></i> Nuevo registro');
  $('.img-prev').attr('src',"views/dist/img/user1-128x128.jpg");
  $("#userNameGroup").removeClass("has-error");
}


$(document).on("click",".btn-status",function(){
  var button = $(this);
  var userID = button.attr("user-id");
  var status = button.text();
  var formData = new FormData();

  button.attr("disabled",true);

  formData.append("userID",userID);
  formData.append("status",status);

  $.ajax({
    url: "ajax/user.ajax.php",
    method: "POST",
    data: formData,
    cache: false,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function(response){
      changeStatusButton(response, button);
      button.attr("disabled",false);
      showAlertInMobileDevices();
    },
    error: function(response){
      button.attr("disabled",false);
      showErrorMessage(response);
    }
  });

});

function changeStatusButton(status, button){

  if(status === 1){

    button.removeClass("btn-danger");
    button.addClass("btn-success");
    button.text("Activo");
    button.attr("status","Activo");
  }else if(status === 0){

    button.removeClass("btn-success");
    button.addClass("btn-danger");
    button.text("Inactivo");
    button.attr("status","Inactivo");
  }else{

    $.notiny({ text: "Se encontró que existe una incongruencia en los datos involucrados en la solicitud "+
               "y no se obtuvo el resultado esperado.",theme: "danger", position: "right-top",
               title:"Error al editar el estado del usuario", delay:5000});
  }
}

$("#username").change(function(){
  var username = $(this).val();
  var formData = new FormData();
  formData.append("username",username);

  $("#userNameGroup").removeClass("has-error");

  $.ajax({
    url: "ajax/user.ajax.php",
    method: "POST",
    data: formData,
    cache: false,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function(response){
      if(response){
        $.notiny({ text: "Este usuario ya existe en el sistema.",
                   theme: "danger", position: "right-top", title:"Error en nombre de usuario", delay:4000});
        $("#userNameGroup").addClass("has-error");
        if ($('#opc').val() == 1) {
          $("#username").val($('#userNameTitle').text());
        }else {
          $("#username").val("");
        }
      }
    },
    error: function(response){
      showErrorMessage(response);
    }
  });
});

function showErrorMessage(response){
  console.log(response.responseText);
  $.notiny({ text: "No se logró completar la solicitud, error de red.",
             theme: "danger", position: "right-top", title:"Error al conectarse al servidor", delay:5000});
}

$(document).on("click",".delete-user",function(){
  var button = $(this);
  var userID = button.attr("user-id");
  var status = button.text();

  var deleteUser = confirm("¿Está realmente seguro de que desea eliminar el registro?");

  if(deleteUser){
    window.location.href = "../pos?route=users&userID="+userID;
  }
})

function showAlertInMobileDevices(){
  if (window.matchMedia("(max-width:765px)").matches) {
    alert("Acción ejecutada correctamente");
    location.reload();
  }
}
