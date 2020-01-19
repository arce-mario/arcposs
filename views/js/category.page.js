$(document).on("click",".edit-category",function(){

  var button = $(this);
  var categoryID = button.attr('category-id');
  var formData = new FormData();
  formData.append('categoryID',categoryID);

  $.ajax({
    url:"ajax/category.ajax.php",
    data: formData,
    contentType: false,
    method: "POST",
    processData: false,
    dataType:"json",
    cache:false,
    success: function (response){
      //Alter html form with response information
      $('#category').val(response['category']);
      $('#opc').val("1:"+response['category_id']);
      $('#btnFormCategory').text("Editar registro");
      $('#btnReset').text("Cancelar edición");
      $('#infoMessage').html('<div class="callout callout-info"><i class="fa fa-exclamation"></i> Editando <strong>'
                             +response['category']+'</strong></div>');
    },
    error: function(response){
      console.log(response);
    }
  });
});

$(document).on("click",".delete-category",function(){
  var button = $(this);
  var categoryID = button.attr("category-id");
  var status = button.text();

  var deleteCategory = confirm("¿Está realmente seguro de que desea eliminar el registro?");

  if(deleteCategory){
    window.location.href = "../pos?route=categories&categoryID="+categoryID;
  }
});

$('#btnReset').click(function (){
  $('#opc').val(0);
  $('#infoMessage').html('');
  $('#btnFormCategory').text("Guardar categoría");
  $(this).text("Cancelar registro");
});
