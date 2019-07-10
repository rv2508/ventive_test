/*mobile data add & update*/
$(function () {

    $('.mobile_submit').click( function (e) {
        if($("#mobile_id").val()==0)
        {
            var src_url='/mobile-save';
            var message="Added Successfully";
        }
        else
        {
            var src_url='/mobile-update';
            var message="Updated Successfully";
        }    
          var form = document.mobile_save;
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
                $('#myModal1').modal('hide');
                //$('#datatable').DataTable().destroy();
                $('#mobile_data').html(data.mobile_data);        
                
                $('#datatable11_m').DataTable().draw();
                form_blank_mobile();
                successM(message);
            }
        }
        });
    });

    $("#image").change(function(){
       readURL(this);
   });
  

});
function form_blank_mobile()
{
    $("#mobile_id").val('0');
    $("#brand").val('');
    $("#modal_name").val('');
    $("#color").val('');
    $("#description").val('');
    $("#image").val('');
    $("#blah").attr("src",'#');
}

function mobile_delete(id)
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
            url: '/mobile-delete',
            type: "post",
            data: {'id':id},
            success: function(data)
            {    
                //$('#datatable').DataTable().destroy();
                $('#mobile_data').html(data.mobile_data);        
                $('#datatable11_m').DataTable().draw();
                errorM();
            }
           });
      } 
    });
          
        
}

function successM(msg)
{
    iziToast.success({
       title: 'Mobile',
       message: msg,
       position: 'topRight',
       icon: 'fa fa-check',
    });
}
function warningM()
{
    iziToast.warning({
       title: 'Mobile!',
       message: 'Your request submitted successfully',
       position: 'topRight',
       icon: 'fa fa-check',
    }).then(() => {
      //location.reload();
    });
}
function errorM()
{
    iziToast.error({
       title: 'Mobile',
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

    $('#myModal1').on('show.bs.modal', function (e) {
        var mobile_id = $(e.relatedTarget).data('id');
        $(".modal-body #mobile_id").val( mobile_id );

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