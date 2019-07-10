/*car data add & update*/
$(function () {

    $('.submit').click( function (e) {
        if($("#car_id").val()==0)
        {
            var src_url='/car-save';
            var message="Added Successfully";
        }
        else
        {
            var src_url='/car-update';
            var message="Updated Successfully";
        }    
          var form = document.car_save;
        var formData = new FormData(form);
        $(".alert").remove();
        $(".form-group").removeClass('bad');
        $.ajax({
        type:'POST',
        url:src_url,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        success: function (data) 
        {
            if(data.status == 401)
            {
                 $.each(data.error1, function(index, value) 
                {
                    $('.error_'+index).addClass('bad');
                    $('.error_'+index).append('<div class="alert">'+value+'</div>');
                });
            }

            if (data.status == 1) 
            {
                $('#myModal').modal('hide');
                //$('#datatable').DataTable().destroy();
                $('#car_data').html(data.car_data);        
                
                $('#datatable1').DataTable().draw();
                form_blank();
                success(message);
            }
        }
        });
    });

    $("#image").change(function(){
       readURL(this);
   });
  

});
function form_blank()
{
    $("#car_id").val('0');
    $("#brand").val('');
    $("#modal_name").val('');
    $("#color").val('');
    $("#description").val('');
    $("#image").val('');
    $("#blah").attr("src",'#');
}

function car_delete(id)
{

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => 
    {
      if (willDelete) {
        //ajax
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: '/car-delete',
            type: "post",
            data: {'id':id},
            success: function(data)
            {    
                //$('#datatable').DataTable().destroy();
                $('#car_data').html(data.car_data);        
                $('#datatable1').DataTable().draw();
                error();
            }
           });
      } 
    });
          
        
}

function success(msg)
{
    iziToast.success({
       title: 'Car',
       message: msg,
       position: 'topRight',
       icon: 'fa fa-check',
    });
}
function warning()
{
    iziToast.warning({
       title: 'Enquiry!',
       message: 'Your request submitted successfully',
       position: 'topRight',
       icon: 'fa fa-check',
    }).then(() => {
      //location.reload();
    });
}
function error()
{
    iziToast.error({
       title: 'Car',
       message: 'Deleted Successfully',
       position: 'topRight',
       icon: 'fa fa-check',
    });
}

function readURL(input) 
{
   if (input.files && input.files[0]) 
   {
       var reader = new FileReader();

       reader.onload = function (e) {
           $('#blah').attr('src', e.target.result);
       }

       reader.readAsDataURL(input.files[0]);
   }
}

  
function validation()
{
    $(".error_description").removeClass('bad');
}
      
$(document).ready(function() {

    $('#myModal').on('show.bs.modal', function (e) {
        var car_id = $(e.relatedTarget).data('id');
        $(".modal-body #car_id").val( car_id );

        var brand_name = $(e.relatedTarget).data('brand');
        $(".modal-body #brand").val( brand_name );

        var modal_name = $(e.relatedTarget).data('modal_name');
        $(".modal-body #modal_name").val( modal_name );

        var color_name = $(e.relatedTarget).data('color');
        $(".modal-body #color").val( color_name );

        var image = $(e.relatedTarget).data('image');
        $(".modal-body #blah").attr('src', image );

        var description_name = $(e.relatedTarget).data('description');
        $(".modal-body #description").val(description_name);

        var fule_name = $(e.relatedTarget).data('fule');
        //$(".modal-body #fule").val(fule_name);
        $("input[name=fuel_type][value='"+fule_name+"']").prop("checked",true);

    });
});