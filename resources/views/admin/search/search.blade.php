@include('admin.includes.sidebar')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Search Cars</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">

                        <form>
                            @csrf
                            <input type="text" name="search" class="form-control" placeholder="Search for Brand,Model" id="search">
                            <!-- <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                      </span> -->
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content" id="search_result">

                        <table id="" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Car Image</th>
                                    <th>Brand Name</th>
                                    <th>Model Name</th>
                                    <th>Description</th>
                                    <th>Fuel Type</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $count =1; ?>
                                    @foreach($results as $result)
                                    <tr>
                                        <th>{{$count}}</th>
                                        <td> <img src="{{URL::asset('img_upload/car_images/'.$result->image)}}" width="50" height="50"></td>
                                        <td>{{ $result->brand }}</td>
                                        <td>{{ $result->model }}</td>
                                        <td>{{ $result->description }}</td>
                                        <td>{{ $result->fuel_type }}</td>
                                    </tr>
                                    <?php  $count++; ?>

                                        @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>

        </div>
         <div class="row">
    <div class="col-md-12">
               <table class="table table-bordered" id="datatable1">
                    <thead>
                           <th>Id</th>
                           <th>Title</th>
                           <th>Body</th>
                           <th>Created At</th>
                           <th>Options</th>
                    </thead>                
               </table>
        </div>
</div>

    </div>
</div>
<!-- /page content --> 
@include('admin.includes.footer')


<script>
    $(document).ready(function () {
        $('#datatable1').DataTable({
            "processing": true,
            "serverSide": true, 
            "ajax":{
                     "url": "{{ url('allposts') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "title" },
                { "data": "body" },
                { "data": "created_at" },
                { "data": "options" }
      
            ]    

        });
    });
</script>