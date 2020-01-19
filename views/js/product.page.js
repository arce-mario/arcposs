$(document).ready(function(){
    $('#productsTable').DataTable( {
       "ajax": 'ajax/product.ajax.php'
    });

    //iCheck for checkbox and radio inputs
    $('.icheck').iCheck({
      checkboxClass: 'icheckbox_line-blue',
      radioClass: 'iradio_line-blue',
      insert : '<i class="icheck_line-icon"></i>' + 'Precio de venta por porcentaje'
    }).on('ifChecked', function(event){

  		$('#salePrice').attr('disabled',true);
      $('#percentGroup').show();
      calculateSalePrice();

  	}).on('ifUnchecked', function(event){
      $('#percentGroup').hide();
      $('#salePrice').attr('disabled',false);

  	});
});

$('#category').change(function(){
  var formData = new FormData();
  var categoryID = $(this).val();

  if (categoryID <= 0) {
    $('#code').val("");
    return;
  }
  formData.append("categoryID",categoryID);

  $.ajax({
    url:"ajax/product.ajax.php",
    method: "POST",
    data: formData,
    cache:false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){

      if (response != null) {
        $('#code').val(parseInt(response)+1);
      }else{
        $('#code').val(categoryID+"01");
      }
    },
    error: function(response){
      console.log(response);
      $.notiny({ text: "No se logró completar la solicitud, error de red.",
                 theme: "danger", position: "right-top", title:"Error al conectarse al servidor", delay:5000});
    }
  });
});

$('#purchasePrice, #percent').change(function(){
  calculateSalePrice();
});

function calculateSalePrice(){
  var purchasePrice = Number($('#purchasePrice').val());
  var percent = Number($('#percent').val());

  if($('.icheck'). is(":checked") && percent != 0){

    if (percent === 0) {
      $(this).val('');
      $.notiny({ text: "No se logró calcular el precio de venta",
                 theme: "danger", position: "right-top", title:"Error en porcentaje de ganancia", delay:5000});
      return;
    }

    var result = ( purchasePrice * percent / 100) + purchasePrice;
    $('#salePrice').val(result);

  }
}

$('#productForm').submit(function(e){
  if ($("#percent, #purchasePrice").is(":focus")) {
    return false;
  }
});
