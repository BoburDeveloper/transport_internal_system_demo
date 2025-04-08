@php
use App\Models\Data;
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
        $i = 0;
    @endphp
    @foreach($column_names[DOCUMENT]['columns'] as $key => $value)
        @php
            $i++;
        @endphp
        @if(in_array($value['column_name'], ['table_flight_id', 'time_flight']))
            @php
                $column_name = $value['column_name'];

                if($column_name=='table_flight_id') {
                        $column_name = strtr($column_name, ['table_flight_id'=>'table_time_flight']);

                       $get_flight = isset($document[$value['column_name']]) ? Data::table_flights(['id'=>$document[$value['column_name']]]) : null;
                            if(empty($get_flight)) {
                                $document[$value['column_name']] = $document[$column_name];
                            }
}

            @endphp
            <tr>
                <td>{{$i}}</td>
                <td>{{__('messages.'.$column_name)}}</td>
                <td>{{$document[$value['column_name']]}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
