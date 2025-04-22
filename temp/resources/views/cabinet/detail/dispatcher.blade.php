@extends('layouts.main')
@section('content')
    <?php

    use App\Models\Data;

    ?>
        <!-- Content Header (Page header) -->
    @include('cabinet.detail.parts.header')
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
                                    <p><b>{{__('messages.status')}}: <span class="{{$status_data[$row['status']]['color']}}">{{__('messages.send_status'.$row['status'])}}</span></b></p>
                                @endif
                                <h3 class="card-title mb-2"><b>{{__('messages.technical')}} {{__('messages.informations_of')}}</b></h3>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">№</th>
                                        <th>Номланиши</th>
                                        <th>Маълумот</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=0;
                                        @endphp
                                        @if(isset($technical['id']))
                                            @foreach($column_names[TECHNICAL]['columns'] as $key => $value)
                                                @php
                                                    $i++;
                                                @endphp

                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{__('messages.'.$value['column_name'])}}</td>
                                                    <td>{{$technical[$value['column_name']]}}</td>
                                                </tr>

                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div><!-- /.card-body -->

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
                                        <p><b>{{__('messages.status')}}: <span class="{{$status_data[$row['status']]['color']}}">{{__('messages.send_status'.$row['status'])}}</span></b></p>
                                    @endif

                                        <h3 class="card-title mb-2"><b>{{__('messages.medical')}} {{__('messages.informations_of')}}</b></h3>

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">№</th>
                                            <th>Номланиши</th>
                                            <th>Маълумот</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i = 0;
                                            @endphp
                                            @if(isset($medical['id']))
                                                @foreach($column_names[MEDICAL]['columns'] as $key => $value)
                                                    @php
                                                        $i++;
                                                    @endphp

                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{__('messages.'.$value['column_name'])}}</td>
                                                        <td>{{$medical[$value['column_name']]}}</td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </section>
                </div>
            </div>
        </section>


@endsection
