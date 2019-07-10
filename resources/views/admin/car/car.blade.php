@include('admin.includes.sidebar')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Cars</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>  <small> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">ADD CAR</button> </small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                         

                        <table class="table table-bordered" id="datatable1">
                                <thead>
                                       <th>Id</th>
                                       <th>Brand Name</th>
                                       <th>Model Name</th>
                                       <th>Color</th>
                                        <th>Description</th>
                                        <th>Fuel Type</th>
                                        <th>Car Image</th>


                                       <th>Created At</th>
                                       <th>Action</th>
                                </thead>                
                           </table>


                    </div>
                </div>
            </div>

        </div>
 

    </div>
   

</div>
<!-- /page content -->

@include('admin.includes.footer')

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Car Information</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal form-label-left" onsubmit="return false;" name="car_save" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="item form-group error_brand">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Brand <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" name="id" id="car_id" value="0">
                            <input id="brand" class="form-control col-md-7 col-xs-12" data-validate-length-range="2" data-validate-words="1" name="brand" placeholder="Brand Name" required="required" type="text" value="">
                        </div>

                    </div>
                    <div class="item form-group error_model">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="model">Model <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="modal_name" name="model" placeholder="Model Name" required="required" class="form-control col-md-7 col-xs-12" value="">
                        </div>
                    </div>
                    <div class="item form-group error_color">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Color <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="color" name="color" data-validate-linked="color" placeholder="Color Name" required="required" class="form-control col-md-7 col-xs-12" value="">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fuel">Fuel Type <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <p>
                                Petrol:
                                <input type="radio" class="flat" name="fuel_type" id="fuelP" value="petrol" checked="" required /> Diesel:
                                <input type="radio" class="flat" name="fuel_type" id="fuelD" value="diesel" />
                            </p>

                        </div>
                    </div>

                    <div class="item form-group error_description">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="description" required="required" data-validate-length-range="2" data-validate-words="1" placeholder="Short Description" name="description" class="form-control col-md-7 col-xs-12" onfocusout="validation()"></textarea>
                        </div>
                    </div>

                    <div class="item form-group error_image">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Car Image <span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input type="file" id="image" name="image" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <img id="blah" src="#" alt="your image" style="width: 50%;" />
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">

                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button id="send" type="button" class="btn btn-success submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>


<script>
    $(document).ready(function () {
        $('#datatable1').DataTable({
            "processing": false,
            "serverSide": true, 
            "ajax":{
                     "url": "{{ url('allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "brand_name" },
                { "data": "model_name" },
                { "data": "color" },
                { "data": "description" },
                { "data": "fuel_type" },
                { "data": "car_images" },
                { "data": "created_at" },
                { "data": "action" }
      
            ]    

        });
    });
</script>