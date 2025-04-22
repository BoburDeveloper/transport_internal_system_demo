    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>№</th>
                <th>{{__('messages.table_time_flight')}}</th>
                <th>{{__('messages.route_id')}}</th>
                <th>{{__('messages.carrier_id')}}</th>
                <th>{{__('messages.vmodel_id')}}</th>
                <th>{{__('messages.price')}}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($flights_from_api['data'] as $key => $value)
            <tr>
                <td>{{$value['trip_id']}}</td>
                <td>
                    <a href="{{request()->fullUrlWithQuery(['trip_id' => $value['trip_id']])}}"> {{$value['trip_time']}}</a>
                </td>
                <td>{{$value['route_name']}}</td>
                <td>{{$value['transporter_name']}}</td>
                <td>{{$value['bus_model_name']}}</td>
                <td>{{$value['price']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>