<?php

use App\Models\Data;

?>
@include('parts.head')
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
                                    <div class="form-group col-6">
                                        <?php
                                        $column = 'name_uz';
                                        $label = __('messages.driver_fio');
                                        $column_value = 'driver_fio';

                                        $visibility = 'visible';
                                        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = '$hidden';
                                        }
                                        ?>
                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <input type="text" name="data_second[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($join_row[$column_value]) ? $join_row[$column_value] : old('data_second.'.$column_value)}}" />
                                            <input type="hidden" name="data_second[type]" value="{{DRIVERS}}" />
                                            <input type="hidden" name="data_second[driver_id]" value="{{isset($row['driver_id']) ? $row['driver_id'] : 0}}" />
                                            <input type="hidden" name="data_second[json_info]" value="{{isset($json_info) ? $json_info : null}}" />
                                            <input type="hidden" name="form_type" value="{{isset($type) ? $type : null}}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <?php
                                        $column = 'numserial';
                                        $label = __('messages.'.$column);
                                        $column_value = 'numserial';

                                        $visibility = 'visible';
                                        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = '$hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <input type="text" name="data_second[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($join_row[$column_value]) ? $join_row[$column_value] : old('data_second.'.$column_value)}}" />
                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-4">
                                        <?php
                                        $column = 'flight_id';
                                        $label = __('messages.'.$column);
                                        $flights = Data::flights();

                                        $visibility = 'visible';
                                        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <select class="form-control select2" name="data[{{$column}}]">
                                                <option value="">{{__('messages.select')}}</option>
                                                @foreach($flights as $key => $value)
                                                    <option value="{{$value['id']}}" {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group col-4">
                                        <?php
                                        $column = 'govnumber';
                                        $label = __('messages.'.$column);

                                        $visibility = 'visible';
                                        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
                                        </div>

                                    </div>
                                    <div class="form-group col-4">
                                        <?php
                                        $column = 'vmodel_id';
                                        $label = __('messages.'.$column);
                                        $vmodels = Data::vmodels();

                                        $visibility = 'visible';
                                        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputPassword1">{{$label}}</label>
                                            <select class="form-control select2" name="data[{{$column}}]">
                                                <option value="">{{__('messages.select')}}</option>
                                                @foreach($vmodels as $key => $value)
                                                    <option value="{{$value['id']}}" {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    $label = __('messages.given_date');
                                    $column = 'given_date';
                                    ?>
                                    <input type="hidden" name="data[{{$column}}]"  value="{{isset($row[$column]) ? $row[$column] : $today}}" />
                                </div>

                                @if(empty($row['status']) or (isset($row['status']) and !in_array($row['status'], [20])))
                                    @php
                                    $cancel_btn = true;
                                    if(isset($content_nod_needed) and $user['username']==DISPATCHER) {
                                        $cancel_btn = false;
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <button type="submit" name="confirm" value="{{$status_data['status_second']}}" class="btn btn-success">{{__('messages.permission_work')}}</button>
                                        @if($cancel_btn)
                                        <button type="submit" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-danger">{{__('messages.no_permission_work')}}</button>
                                        @endif
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
@include('parts.footer_scripts')
@include('parts.bottom')
