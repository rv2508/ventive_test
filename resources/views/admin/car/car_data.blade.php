<?php $count = 1; ?>
@foreach($results as $result)
<tr>
    <th>{{$count}}</th>
    <td>{{ $result->brand }}</td>
    <td>{{ $result->model }}</td>
    <td>{{ $result->color }}</td>
    <td>{{ $result->description }}</td>
    <td>{{ $result->fuel_type }}</td>
    <td> <img src="{{URL::asset('img_upload/car_images/'.$result->image)}}" width="50" height="50"></td>
    <td>{{ $result->created_at }}</td>
    <td>{{ $result->updated_at }}</td>
    <td>
        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal" data-id="{{ $result->id }}" data-brand="{{ $result->brand }}" data-modal_name="{{ $result->model }}" data-color="{{ $result->color }}" data-description="{{ $result->description }}" data-image="{{URL::asset('img_upload/car_images/'.$result->image)}}" data-fule="{{ $result->fuel_type }}"><i class="fa fa-pencil"></i> Edit </a>
        <a href="#" class="btn btn-danger btn-xs" onclick="car_delete('{{ $result->id }}')"><i class="fa fa-trash-o"></i> Delete </a>
    </td>
</tr>
<?php  $count++; ?>
@endforeach