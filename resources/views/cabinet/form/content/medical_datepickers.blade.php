@if(isset($type) and $type==MEDICAL and !empty($row) and empty($readonly_attribute))
    @foreach($row as $key => $value)

        $('#datetimepicker-{{$value['driver_id']}}').datetimepicker({ icons: { time: 'far fa-clock' }, format: 'DD.MM.YYYY HH:mm',minDate:new Date(), 
        use24hours: true  });

        $('#datetimepicker_second-{{$value['driver_id']}}').datetimepicker(
            { 
                icons: { time: 'far fa-clock' }, 
                format: 'DD.MM.YYYY HH:mm',
                minDate:new Date(), 
                use24hours: true  
            });

    @endforeach
@endif
