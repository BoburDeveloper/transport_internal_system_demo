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
                            <div class="btns-top float-right">
{{--                                <a href="{{url('/'.app()->getLocale().'/cabinet/form/'.$type.'/0')}}" class="btn btn-success">{{__('messages.create')}}</a>--}}
                            </div>
                            <div class="clearfix"></div>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>{{__('messages.govnumber')}}</th>
                                    <th>{{__('messages.doc_number')}}</th>
                                    <th>{{__('messages.driver_fio')}}</th>
                                    <th>{{__('messages.last_given_date')}}}</th>
                                    <th>{{__('messages.status')}}</th>
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
                                                {{isset($value['govnumber']) ? $value['govnumber'] : __('messages.not_filled')}}
                                            </a></td>
                                        <td>{{$value['document_id']}}</td>
                                        <td>{{$value['driver_fio']}}</td>
                                        <td>{{$value['last_given_date']}}</td>
                                            <?php
                                            $status = $value['second_status'];
                                            $label_status = 'permission_status'.$status;
                                            $color = isset($status_data[$status]['color']) ? $status_data[$status]['color'] : 'blueb';

                                            if($value['status']>1) {
                                                $status = $value['status'];
                                                $color = isset($status_data[$status]['color']) ? $status_data[$status]['color'] : 'blueb';
                                                $label_status = 'end_status'.$status;
                                                if($status==9 and isset($value['guid_id'])) {
                                                    $color = 'redb';
                                                }
                                            }
                                            if(empty($status)) {
                                                $label_status = 'not_filled';
                                                $color = 'grayb';
                                            }
                                            ?>
                                        <td class="{{$color}}">
                                            {{__('messages.'.$label_status)}}
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
