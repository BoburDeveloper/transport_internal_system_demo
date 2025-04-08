@extends('layouts.main')
@section('content')
        <?php

        use App\Models\Data;

        $join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, s.govnumber']);

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

                                    @if(isset($row['status']))
                                    <p><b>{{__('messages.status')}}: <span class="{{$status_data[$row['status']]['color']}}">{{__('messages.permission_status'.$row['status'])}}</span></b></p>
                                        @if(!empty($row['comment']))
                                            <p><b>{{__('messages.comment')}}:</b> {{$row['comment']}}</p>
                                            <hr/>
                                        @endif
                                    @endif
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <?php
                                                $column = 'driver_id';
                                                $label = __('messages.'.$column);
                                                $drivers = Data::drivers();
                                                ?>
                                                <p><b>{{$label}}:</b> {{!empty($join_row['driver_fio']) ? $join_row['driver_fio'] : __('messages.not_filled')}}</p>
                                                <p><b>{{__('messages.govnumber')}}:</b> {{$join_row['govnumber']}}</p>
                                                <input type="hidden" name="data[{{$column}}]" value="{{$join_row['driver_id']}}">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <?php
                                                $column = 'temperature';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputEmail1">{{$label}}</label>
                                                <input type="text" name="data[{{$column}}]" class="form-control float" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                            </div>
                                            <div class="form-group col-6">
                                                <?php
                                                $label = __('messages.pulse');
                                                $column = 'pulse';
                                                ?>
                                                <label for="exampleInputEmail1">{{$label}}</label>
                                                <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <?php
                                                $column = 'bpressure_begin';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputEmail1">{{$label}}</label>
                                                <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                            </div>
                                            <div class="form-group col-6">
                                                <?php
                                                $column = 'bpressure_end';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputEmail1">{{$label}}</label>
                                                <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-6">
                                                <?php
                                                $column = 'diagnostic';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputEmail1">{{$label}}</label>
                                                <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                            </div>


                                            <div class="form-group col-3">
                                                <?php
                                                $column = 'time_begin';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                                    <input type="text" name="data[{{$column}}]" class="form-control datetimepicker-input" data-target="#datetimepicker" data-toggle="datetimepicker" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                                </div>
                                            </div>
                                            <!-- /.input group -->

                                            <div class="form-group col-3">
                                                <?php
                                                $column = 'time_end';
                                                $label = __('messages.'.$column);
                                                ?>
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <div class="input-group date" id="datetimepicker_second" data-target-input="nearest">
                                                    <input type="text" name="data[{{$column}}]" class="form-control datetimepicker-input" data-target="#datetimepicker_second"  data-toggle="datetimepicker"  placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                                </div>
                                            </div>
                                            <?php
                                            $column = 'time_med_exam';
                                            $label = __('messages.'.$column);
                                            ?>
                                            <input type="hidden" name="data[{{$column}}]" value="{{isset($row[$column]) ? $row[$column] : $today}}" />

                                            <?php
                                            $column = 'given_date';
                                            $label = __('messages.'.$column);
                                            ?>
                                            <input type="hidden" name="data[{{$column}}]"  value="{{isset($row[$column]) ? $row[$column] : $today}}" />
                                        </div>

                                        @if(empty($row['status']) or (isset($row['status']) and !in_array($row['status'], [20])))
                                        <div class="form-group">
                                            <button type="submit" name="confirm" value="{{$status_data['status_second']}}" class="btn btn-success">{{__('messages.permission_work')}}</button>
                                            <button type="submit" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-danger">{{__('messages.no_permission_work')}}</button>
                                        </div>
                                        @endif
                                    </form>


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
