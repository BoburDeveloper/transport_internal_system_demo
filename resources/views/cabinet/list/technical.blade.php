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
                            <div class="btns-top">
                            <div class="btn-group dropright">
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    {{__('messages.create')}}  <span class="badge badge-light">{{$count_flights_from_api}}</span>
  </button>
  <div class="dropdown-menu dropdown-menu-technical">
        @if(isset($flights_from_api))
            @foreach($flights_from_api['data'] as $key => $value)
                <ul>
                    <li>
                        <a href="{{url('/'.app()->getLocale().'/cabinet/form/'.$type.'/0?trip_id='.$value['trip_id'])}}"> {{$value['trip_time']}} - {{$value['route_name']}}</a>
                    </li>
                </ul>
            @endforeach
        @else
            <div class="col-12">...</div>
        @endif
  </div>
</div>
                            </div>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>{{__('messages.govnumber')}}</th>
                                    <th>{{__('messages.doc_number')}}</th>
                                    <th>{{__('messages.driver_fio')}}</th>
                                    <th>{{__('messages.last_given_date')}}</th>
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
                                            {!! isset($value['govnumber']) ? $value['govnumber'] : '<span class="grayb">'.__('messages.not_filled').' <i class="fa fa-plus"></i> </span>' !!}
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
