<!-- Select2 -->
<link rel="stylesheet" href="{{asset($asset_theme.'plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset($asset_theme.'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="{{asset($asset_theme.'plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/site.js?v='.$time)}}"></script>
<style>
    .select2-container .select2-selection--single{
        height: 37px;
    }

</style>

<script type="text/javascript">
    //Timepicker
    //Date and time picker
    $('#datetimepicker').datetimepicker(
    { 
        icons: { time: 'far fa-clock' }, 
        format: 'DD.MM.YYYY HH:mm',
        use24hours: true   
    });

    $('#datetimepicker_second').datetimepicker(
    { 
        icons: { time: 'far fa-clock' }, 
        format: 'DD.MM.YYYY HH:mm',
        use24hours: true 
    });

    //Date picker
    $('#datepicker').datetimepicker({
        format: 'DD.MM.YYYY',
        use24hours: true
    });
    $('#datepicker_second').datetimepicker({
        format: 'DD.MM.YYYY',
        use24hours: true
    });
    //Initialize Select2 Elements
    $('.select2').select2();

    @if(isset($bottom_view))
        @include($bottom_view)
    @endif
</script>
