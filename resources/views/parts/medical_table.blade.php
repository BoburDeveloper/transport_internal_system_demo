@php
    use App\Models\Data;
        $columns_str = '';
        $column_names = Data::column_names($page_type, ['prefix'=>'n', 'not_needed'=>['n.driver_id', 'n.json_info', 'n.org_id', 'n.staff_id']]);
        foreach ($column_names['columns'] as $key => $value) {
            $columns_str .= $value['column_name'].', ';
        }
        $columns_str = substr($columns_str, 0, -2);
        $join_row = Data::get_join_row(['id'=>$id, 'select'=>'m.id driver_id, m.name_uz driver_fio, s.govnumber, '.$columns_str]);
        if(empty($medical)) {
            $medical = [];
        }
        $medical = $join_row;

        $not_needed = ['id'];

@endphp

    @php
        $i = 0;
    @endphp
    @foreach($medical as $key => $value)
        @php
            $j=0;
            $i++;
                $column = 'driver_id';
                $driver = Data::drivers(['id'=>$value[$column]]);
        @endphp
        <h3 class="card-title mb-2">
            <b>{{__('messages.result_'.$page_type)}}:</b>  {{$i}}. {{$value['driver_fio']}} -
                <b>
                @if(isset($value['status']))
                    <span class="{{$status_data[$page_type][$value['status']]['color']}}">{{__('messages.permission_status'.$value['status'])}}</span>
                @else
                    <span class="grayb"> {{__('messages.not_filled')}}</span>
                @endif
            </b></h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 10px">№</th>
                <th>Номланиши</th>
                <th>Маълумот</th>
            </tr>
            </thead>
            <tbody>
            @foreach($value as $key_item => $value_item)
            @php
            $j++;
            @endphp
            @if(isset($value[$key_item]))
                @if($key_item=='driver_id')
                    <tr>
                        <td>{{$i}}.{{$j}}</td>
                        <td>{{__('messages.'.$key_item)}}</td>
                        <td>{{$driver['name_'.app()->getLocale()]}}</td>
                    </tr>
                @elseif($key_item=='status')
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{__('messages.'.$key_item)}}</td>
                        <td>{{__('messages.permission_status'.$value[$key_item])}}</td>
                    </tr>
                @else
                    @if(!in_array($key_item, $not_needed))
                    <tr>
                        <td>{{$i}}.{{$j}}</td>
                        <td>{{__('messages.'.$key_item)}}</td>
                        <td>{{$value[$key_item]}}</td>
                    </tr>
                    @endif
                @endif
            @else
                @if(!in_array($key_item, $not_needed))
                <tr>
                    <td>{{$i}}.{{$j}}</td>
                    <td>{{__('messages.'.$key_item)}}</td>
                    <td class="before-redb">-</td>
                </tr>
                @endif
            @endif
        @endforeach
            </tbody>
        </table>
    @endforeach
