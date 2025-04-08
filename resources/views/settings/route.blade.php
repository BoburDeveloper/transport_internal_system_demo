@extends('layouts.main')
@section('content')
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

<form action="{{url('/'.app()->getLocale().'/cabinet/form/'.$type.'/'.$id)}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
<div class="row">
    <input type="hidden" name="row_id" value="{{$id}}">
    <input type="hidden" name="form_type" value="settings">
    <div class="form-group col-lg-3">
        <?php
        $column = 'name_uz';
        $label = __('messages.column_'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'name_oz';
        $label = __('messages.column_'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'name_en';
        $label = __('messages.column_'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'name_ru';
        $label = __('messages.column_'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'num_drivers';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="sm-input form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column]) ? $row[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3 mt-md-4 mt-3">
        <?php
        $column = 'is_international';
        $label = __('messages.'.$column);
        ?>
        <label for="is_international">{{$label}}</label> 
        <input type="hidden" name="data[{{$column}}]" value="0" />
        <input type="checkbox" id="is_international" name="data[{{$column}}]" {{$row[$column] ? 'checked' : ''}} />
    </div>
</div>

@if(empty($row['status']) or (isset($row['status']) and !in_array($row['status'], [20])))
    <div class="form-group mt-md-0 mt-3">
        <button type="submit" name="submit" class="btn btn-primary mb-1">{{__('messages.save')}}</button>
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