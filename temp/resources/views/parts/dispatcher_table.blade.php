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
        @if(in_array($value['column_name'], ['table_time_flight', 'time_flight']))
            <tr>
                <td>{{$i}}</td>
                <td>{{__('messages.'.$value['column_name'])}}</td>
                <td>{{$document[$value['column_name']]}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
