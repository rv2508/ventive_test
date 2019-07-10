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
        @foreach($search as $result)
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

  <?php $count = 1; ?>

