@if(isset($type) and $type==DISPATCHER and !empty($row))
@php
$column = 'time_flight';
@endphp
    $('#datetimepicker_{{$column}}').datetimepicker({
        format: 'DD.MM.YYYY HH:mm',
        minDate:new Date(),
        use24hours: true, 
    });

@endif
