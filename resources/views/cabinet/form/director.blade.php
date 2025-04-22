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

                                @if(isset($medical['id']))

                                    @include('parts.medical_table')

                                @endif
                            </div>
                            <!-- /.card-body -->

                            @if(isset($current_boarded_passengers['data']))

                                @include('parts.boarder_passengers')
                         
                            @elseif(!empty($err_msg))
                            
                                <h5 class="redb">{{$err_msg}}</h5>
                            
                            @endif

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
                                @if(isset($dispatcher['id']))
                                    <input type="hidden" name="data_second[type]" value="{{$page_type}}">
                                    <input type="hidden" name="data_second[status]" value="{{$status_data['confirmed']}}">
                                    <input type="hidden" name="data_second[id]" value="{{$dispatcher['id']}}">
                                @endif


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

                                <div class="clearfix"></div>
                                @php if(isset($user['post_name_'.app()->getLocale()])) {
                                    $director_label = $user['post_name_'.app()->getLocale()];
                                } else {
                                    $director_label = __('messages.result_'.$type);
                                
                                }
                                @endphp
                                <h3 class="card-title mb-2"><b>{{$director_label}}:
                                        @if(isset($director['status']))
                                            <span class="{{$status_data[$type][$director['status']]['color']}}">{{__('messages.end_status'.$director['status'])}}</span>
                                        @else
                                            <span class="grayb"> {{__('messages.not_filled')}}</span>
                                        @endif
                                    </b></h3>

                                @if(empty($director['status']) or (isset($director['status']) and $director['status']==1))

                                        <?php
                                        $label = __('messages.given_date');
                                        $column = 'given_date';
                                        ?>
                                       <input type="hidden" name="data[{{$column}}]"value="{{isset($director[$column]) ? $director[$column] : $today}}"/>

                                        <div class="row">
                                            <div class="form-group col-12">
                                                <input type="hidden" name="data[status]" value="20" />
                                            </div>
                                        @if(isset($dispatcher['status']) and $dispatcher['status']==19 and empty($err_msg))
                                            <div class="form-group col-12">
                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success">{{__('messages.status'.$status_data['confirmed'])}}</button>
                                            </div>
                                        @elseif(!empty($err_msg))
                                            <div class="alert alert-danger">{{$err_msg}}</div>    
                                        @endif
                                        </div>
                                @elseif($director['status']==20)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <input type="hidden" name="data[status]" value="20" />
                                    </div>

                                    <div class="form-group col-6">
                                        <button type="button" id="click-submit-action" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-danger">{{__('messages.status9')}}</button>
                                    </div>
                                    <div class="form-group col-6 text-right">
                                        <a href={{url('/'.app()->getLocale().'/site/document/'.$document['id'])}}><i class="fas fa-file"></i> {{__('messages.view')}}</a>
                                    </div>

                                  
                                </div>

                                <div class="modal" id="modal-dialog" tabindex="-1" data-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="redb">{{__('messages.do_you_confirm_to_cancel_document')}}</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.no')}}</button>
                                                <button type="submit" id="submit-btn" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-primary">{{__('messages.i_will_confirm')}}</button>
                                            </div>
                                        </div>
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


    <script type="text/javascript">

            let id_click_submit_action = '#click-submit-action';
            let modal_id = '#modal-dialog';
            $(id_click_submit_action).on('click', function () {
                $(modal_id).modal('show');
            });

    </script>


@endsection
