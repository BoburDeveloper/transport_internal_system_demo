@php
    $column = 'driver_fio';

//    $is_edit = ($type==DISPATCHER and in_array($technical['status'], [$status_data[TECHNICAL]['status_second']])) ? true : false;
    $is_edit = false;

@endphp
@foreach($technical['data_first'] as $key => $value)
@php
    $j = $key+1;
@endphp
<tr>
    <td>{{$i}}.{{$j}}</td>
    <td>
        @php
            $column = 'driver_fio';
        @endphp
        {{__('messages.'.$column)}}: {{$value[$column]}}
        @if($is_edit)
            <a href="javascript:void(0);" id="{{$column}}" data-id="{{$value['driver_id']}}" class="edit-driver-info"><i class="fas fa-edit"></i></a>
        @endif</td>
    <td>
        @php
        $column = 'numserial';
        @endphp
        {{__('messages.'.$column)}}:
        {{$value[$column]}}
        @if($is_edit)
            <a href="javascript:void(0);" id="{{$column}}"  data-id="{{$value['driver_id']}}" class="edit-driver-info"><i class="fas fa-edit"></i></a>
        @endif
    </td>
</tr>

@endforeach
