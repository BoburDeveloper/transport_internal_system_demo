@extends('layouts.main')
@section('content')
    <?php

    use App\Models\Data;

    ?>

    <style>
        #infoTable_filter{
            float: right;
        }
    </style>
        <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>{{__('messages.routes')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Асосий</a></li>
                        <li class="breadcrumb-item active">Маълумотлар</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover text-nowrap" id="infoTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>{{__('messages.route_id')}}</th>
                                    <th>{{__('messages.column_name_oz')}}</th>
                                    <th>{{__('messages.num_drivers')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @if(!empty($flights))
                                @foreach($flights as $key => $value)
                                    @php
                                        $i++;
                                    @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><a href="{{url('/'.app()->getLocale().'/settings/route/'.$value['id'])}}">
                                            {{$value['name_uz']}}
                                        </a></td>
                                    <td>{{$value['name_oz']}}</td>
                                    <td>{{$value['num_drivers']}}</td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">{{__('messages.data_not_found')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                       <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </section>
            </div>
        </div>
    </section>
    <!-- /.content -->


<!-- DataTables  & Plugins -->
<script src="{{asset($asset_theme.'/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset($asset_theme.'/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $('#infoTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@endsection
