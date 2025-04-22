@extends('layouts.main')
@section('content')
    <?php

    use App\Models\Data;

    ?>
        <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>{{__('messages.'.$type.'_cabinet')}}</h1>
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

                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Хайдовчи Ф.И.О</th>
                                    <th>Хужжат рақами</th>
                                    <th>Транспорт давлат рақами</th>
                                    <th>Кўрик  санаси</th>
                                    <th>Ҳолати</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 0;
                                @endphp

                                @if(!empty($rows))
                                @foreach($rows as $key => $value)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td><a href="{{url('/'.app()->getLocale().'/cabinet/form/'.$type.'/'.$value['document_id'])}}">
                                                {{$value['driver_fio']}}
                                            </a></td>
                                        <td>{{$value['document_id']}}</td>
                                        <td>{{$value['govnumber']}}</td>
                                        <td>{{$value['time_med_exam']}}</td>
                                        <td class="{{$status_data[$value['second_status']]['color']}}">
                                            {{__('messages.end_status'.$value['status'])}}
                                            @if($value['status']==20)
                                                |
                                                <a href="{{url('/'.app()->getLocale().'/site/document/'.$value['document_id'])}}" class="greenb">
                                                    {{__('messages.result')}}
                                                </a>
                                            @endif
                                        </td>
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


@endsection
