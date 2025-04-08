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
    @foreach($column_names[$page_type]['columns'] as $key => $value)
        @php
            $i++;
        @endphp

        <tr>
            <td>{{$i}}</td>
            <td>{{__('messages.'.$value['column_name'])}}</td>
            <td>{{$medical[$value['column_name']]}}</td>
        </tr>

    @endforeach
    </tbody>
</table>
