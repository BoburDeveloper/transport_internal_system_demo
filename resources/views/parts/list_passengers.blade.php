@php
use App\Models\Data;

    if(empty($get_flight)) {
    $column = 'flight_id';
        if(isset($technical[$column]) and $technical[$column]==999) {
            $get_flight = $technical;
            $get_flight['name_uz'] = $technical['flight_name_uz'];
        } else {
            $get_flight =  Data::flights(['id'=>$technical[$column]]);
        }
    }
    $i = 0;

if(isset($flight['is_international']) and $flight['is_international']) {
    $fio_label = 'Ф.И.О';
    $seat_number_label = 'Места';
    $phone_number_label = 'Номер телефона';
    $date_birth_label = 'Год рождения';
    $passport_num_label = 'Паспорт серия и №';
    $citizenship_label = 'Гражданство';
    $route_id_label = 'До куда';
    $price_ticket_label = 'Цена билета';
    $number_ticket_label = 'Номер билета';
} else {
    $fio_label = __('messages.fio');
    $seat_number_label = __('messages.seat_number');
    $phone_number_label = __('messages.phone_number');
    $date_birth_label = __('messages.date_birth');
    $passport_num_label = __('messages.passport_num');
    $citizenship_label = __('messages.citizenship');
    $route_id_label = __('messages.route_id');
    $price_ticket_label = __('messages.price_ticket');
    $number_ticket_label = __('messages.number_ticket');
}

@endphp
<thead>
<tr>
    <th style="width: 1px;">№</th>
    <th>{{$fio_label}}</th>
    <th class="text-center" style="width: 1px;">{{$seat_number_label}}</th>
    <th>{{$phone_number_label}}</th>
    <th>{{$date_birth_label}}</th>
    <th>{{$passport_num_label}}</th>
    <th>{{$citizenship_label}}</th>
    <th style="width: 120px;">{{$route_id_label}}</th>
    <th>{{$price_ticket_label}}</th>
    <th>{{$number_ticket_label}}</th>
</tr>
</thead>
<tbody>
    @foreach($current_boarded_passengers['data'] as $key => $value)
        @php
            $i++;
        @endphp
            <tr>
                <td class="text-center">{{$i}}</td>
                <td>{{$value['full_name']}}</td>
                <td class="text-center">{{$value['seat_number']}}</td>
                <td class="text-center">{{$value['phone']}}</td>
                <td class="text-center">{{$value['birth_date']}}</td>
                <td class="text-center">{{$value['passport_number']}}</td>
                <td class="text-center"></td>
                <td class="text-center">{{$get_flight['name_uz']}}</td>
                <td class="text-center">{{$value['amount']}}</td>
                <td class="text-center">{{$value['ticket_id']}}</td>
            </tr>
    @endforeach
</tbody>
