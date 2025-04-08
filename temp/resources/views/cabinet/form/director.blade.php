@extends('layouts.main')
@section('content')
    <?php
    use App\Models\Data;

    $join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial']);
    if(isset($join_row['driver_id']) and isset($technical['driver_id'])) {
        $technical = array_merge($technical, $join_row);
    }
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
                                @php
                                    $page_type = TECHNICAL;
                                @endphp
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


                                <h3 class="card-title mb-2"><b>{{__('messages.result_'.$page_type)}}:
                                        @if(isset($technical['status']))
                                            <span class="{{$status_data[$page_type][$technical['status']]['color']}}">{{__('messages.permission_status'.$technical['status'])}}</span>
                                        @else
                                            <span class="grayb"> {{__('messages.not_filled')}}</span>
                                        @endif
                                    </b></h3>

                                @if(isset($technical['id']))

                                    @include('parts.technical_table')

                                @endif
                            </div><!-- /.card-body -->
<br/>
                            <hr style="border: 1px solid #dddddd;"/>

                            <div id="message">
                                @php
                                    $page_type = MEDICAL;
                                @endphp

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

                                <h3 class="card-title mb-2"><b>{{__('messages.result_'.$page_type)}}:
                                        @if(isset($medical['status']))
                                            <span class="{{$status_data[$page_type][$medical['status']]['color']}}">{{__('messages.permission_status'.$medical['status'])}}</span>
                                        @else
                                            <span class="grayb"> {{__('messages.not_filled')}}</span>
                                        @endif
                                    </b></h3>

                                @if(isset($medical['id']))

                                    @include('parts.medical_table')

                                @endif
                            </div>
                            <!-- /.card-body -->
<br/>
                            <hr style="border: 1px solid #dddddd;"/>
                    <form action="" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div id="message row col-12">
                                @php
                                    $page_type = DISPATCHER;
                                @endphp

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

                                <h3 class="card-title mb-2"><b>{{__('messages.result_'.$page_type)}}:
                                        @if(isset($dispatcher['status']))
                                            <span class="{{$status_data[$page_type][$dispatcher['status']]['color']}}">{{__('messages.end_status'.$dispatcher['status'])}}</span>
                                        @else
                                            <span class="grayb"> {{__('messages.not_filled')}}</span>
                                        @endif
                                    </b></h3>
                                @if(isset($dispatcher['id']) and isset($document['id']))
                                    @include('parts.dispatcher_table')
                                @endif

                                <input type="hidden" name="page_type" value="{{$page_type}}" />
                            </div>
                            <!-- /.card-body -->

                            <br/>
                            <hr style="border: 1px solid #dddddd;"/>

                            <div id="message">
                                @php
                                    $page_type = DIRECTOR;
                                @endphp

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

                                <h3 class="card-title mb-2 col-12"><b>{{__('messages.result_'.$type)}}:
                                        @if(isset($director['status']))
                                            <span class="{{$status_data[$type][$director['status']]['color']}}">{{__('messages.end_status'.$director['status'])}}</span>
                                        @else
                                            <span class="grayb"> {{__('messages.not_filled')}}</span>
                                        @endif
                                    </b></h3>

                                @if(empty($director['status']))
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <input type="hidden" name="data[status]" value="20" />
                                            </div>

                                            <div class="form-group col-12">
                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success">{{__('messages.status'.$status_data['confirmed'])}}</button>
                                            </div>
                                        </div>
                                @elseif($director['status']==20)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <input type="hidden" name="data[status]" value="20" />
                                    </div>

                                    <div class="form-group col-12">
                                        <button type="submit" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-danger">{{__('messages.status5')}}</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!-- /.card-body -->

                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </section>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
