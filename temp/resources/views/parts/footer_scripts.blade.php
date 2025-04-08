
<!-- jQuery UI 1.11.4 -->
<script src="{{asset($asset_theme.'plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset($asset_theme.'plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset($asset_theme.'plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
{{--<script src="{{asset($asset_theme.'plugins/sparklines/sparkline.js')}}"></script>--}}
<!-- JQVMap -->
<script src="{{asset($asset_theme.'plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset($asset_theme.'plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset($asset_theme.'plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset($asset_theme.'plugins/moment/moment.min.js')}}"></script>
<script src="{{asset($asset_theme.'plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset($asset_theme.'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset($asset_theme.'plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset($asset_theme.'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset($asset_theme.'dist/js/adminlte.js')}}"></script>

<script src="{{asset('js/site.js')}}"></script>
<!-- AdminLTE for demo purposes -->
{{--<script src="{{asset($asset_theme.'dist/js/demo.js')}}"></script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{asset($asset_theme.'dist/js/pages/dashboard.js')}}"></script>--}}
