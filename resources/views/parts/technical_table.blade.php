@php
use App\Models\Data;
$join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial']);
if(isset($technical['driver_id'])) {
    $technical['data_first'] = $join_row;
}

    $column = 'flight_id';
    $get_flight = isset($technical[$column]) ? Data::flights(['id'=>$technical[$column]]) : null;

    $column = 'vehicle_id';
    $bus_model = Data::bus_models(['id'=>$technical[$column]]);

    if(empty($carrier)) {
        $column = 'carrier_id';
        $carrier = Data::carriers(['id'=>$technical[$column]]);
    }


    $column = 'vmodel_id';
    $vmodel = Data::vmodels(['id'=>$technical[$column]]);

    if(isset($technical['updated_time'])) {
        $technical['updated_time'] = date('d.m.Y H:i', strtotime($technical['updated_time']));
    }
    if(isset($technical['created_time'])) {
        $technical['created_time'] = date('d.m.Y H:i', strtotime($technical['created_time']));
    }


@endphp

<table class="table table-striped">
    <thead>
    <tr>
        <th style="width: 10px">№</th>
        <th>Номланиши</th>
        <th>Маълумот</th>
    </tr>
    </thead>
    <tbody>
    @php
    $i=0;
    @endphp

    @foreach($column_names[$page_type]['columns'] as $key => $value)
    @php
    $i++;
    @endphp
    @if($value['column_name']=='driver_id')

        @include('parts.driver_table')

    @elseif($value['column_name']=='flight_id')
        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{isset($get_flight['name_'.app()->getLocale()]) ? $get_flight['name_'.app()->getLocale()] : null}}</td>
        </tr>
    @elseif($value['column_name']=='vehicle_id')
        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{isset($bus_model['bus_number']) ? $bus_model['bus_number'] : null}}</td>
        </tr>
    @elseif($value['column_name']=='carrier_id')
        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{isset($carrier['name']) ? $carrier['name'] : null}}</td>
        </tr>
    @elseif($value['column_name']=='vmodel_id')
        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{isset($vmodel['name']) ? $vmodel['name'] : null}}</td>
        </tr>
    @elseif($value['column_name']=='status')
        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{__('messages.permission_status'.$technical[$value['column_name']])}}</td>
        </tr>
    @else
    <tr>
        <td>{{$i}}</td>
        <td>{{__('messages.'.$value['column_name'])}}</td>
        <td>{{$technical[$value['column_name']]}}</td>
    </tr>
    @endif


    @endforeach
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal window</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.edit-driver-info').on('click', function (){
       $.ajax({
          url:'{{url('/'.app()->getLocale().'/cabinet/form/'.TECHNICAL.'/'.$id)}}',
           method:'get',
           data: {'ctype': '{{'c'.TECHNICAL}}', 'content_not_needed':'flight_id,govnumber,vmodel_id', 'stage':'{{$type}}', 'form_type':'{{TECHNICAL}}', 'change':'{{DRIVERS}}'},
           success:function (data) {
               let modal_name = '#exampleModal';
               $(modal_name).modal('show');
               $(modal_name+' .modal-body').html(data);
           }
       });
    });
</script>
