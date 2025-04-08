@extends('layouts.main')
@section('content')
        <?php

        use App\Models\Data;
        use App\Providers\AppServiceProvider;

        $columns_str = '';
        $column_names = Data::column_names($type, ['prefix'=>'n', 'not_needed'=>['n.driver_id']]);
        foreach ($column_names['columns'] as $key => $value) {
            $columns_str .= $value['column_name'].', ';
        }
        $columns_str = substr($columns_str, 0, -2);
        $join_row = Data::get_join_row(['id'=>$id, 'select'=>'m.id driver_id, m.name_uz driver_fio, s.govnumber, '.$columns_str]);
        if(empty($row)) {
            $row = [];
        }
        $row = $join_row;

        $bottom_view = 'cabinet.form.content.medical_datepickers';

        $readonly_attribute = AppServiceProvider::readonly_attribute(['row'=>$row]);

        ?>
            <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>{{$title}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Асосий</a></li>
                            <li class="breadcrumb-item active">Маълумотларни киритиш</li>
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
                                <div id="message">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(session()->has('msg'))
                                        <div class="alert alert-{{session()->get('css_class')}}">{{session('msg')}}</div>
                                    @endif


                                                <?php
                                                $column = 'driver_id';
                                                $label = __('messages.'.$column);
                                                $drivers = Data::drivers();
                                                ?>
                                                @foreach($row as $key => $value)
                                                    @php
                                                        $item = $key+1;
                                                    @endphp
                                                    @if($key==0)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <p><b>{{__('messages.govnumber')}}:</b> {{$value['govnumber']}}</p>
                                                    </div>
                                                </div>

                                                    @endif


                                            <div class="card">
                                                <div class="card-header">
                                                    <p><b>{{$item}}. {{$label}}:</b> {{!empty($value['driver_fio']) ? $value['driver_fio'] : __('messages.not_filled')}}</p>
                                                </div>
                                                <div class="card-body">
                                                    @include('cabinet.form.content.cmedical')
                                                </div>
                                            </div>



{{--                                                    <hr class="bold-line"/>--}}

                                                @endforeach




                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <!-- /.content -->

@endsection
