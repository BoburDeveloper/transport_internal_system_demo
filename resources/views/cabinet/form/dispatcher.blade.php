@extends('layouts.main')
@section('content')
    <?php
    use App\Models\Data;

    $dispatcher_msg = '';
    $msg_type = 'danger';

    $bottom_view = 'cabinet.form.content.dispatcher_datepickers';
    ?>
    <!-- Content Header (Page header) -->
    @include('cabinet.detail.parts.header')
    <!-- /.content-header -->

    <!-- Main content -->
    @if(isset($dispatcher['status']) && in_array($dispatcher['status'], [18,19]) && empty($document['time_flight']))
    @php
        $dispatcher_msg = '<i class="fa-lg mt-2 fas fa-exclamation-circle"></i> '.__('messages.fill_the_time_table_flight');
        $readonly_attribute = '';
    @endphp


    <script type="text/javascript">
        //inputs-bottom
        document.addEventListener("DOMContentLoaded", function() {
            const inputField = document.getElementById("time_flight");
           @if(session()->has('msg'))
            const secondInputField = document.getElementById('inputs-bottom');
            if (secondInputField) {
                // Задержка перед скроллом
                setTimeout(() => {
                    secondInputField.scrollIntoView({ behavior: "smooth", block: "center" });
                    inputField.focus(); // Установка фокуса после скролла
                }, 2000); // Задержка в 2 секунды
            }
          @else

            if (inputField) {
                inputField.scrollIntoView({ behavior: "smooth", block: "center" });
                // Установка фокуса на элемент
                inputField.focus(); // Устанавливаем фокус на инпут
            }
          @endif
        });

    </script>
    @elseif(isset($dispatcher['status']) and in_array($dispatcher['status'], [19,20]) and isset($document['time_flight']))
        @php
            $readonly_attribute = 'readonly';
        @endphp
    @else
        @php
            $readonly_attribute = 'hidden';
        @endphp
    @endif

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
                                  $page_id = isset($technical['id']) ? $technical['id'] : null;
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
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                         @include('parts.technical_table')

                                         @if($technical['status']!=20)
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <?php
                                                $column = 'page_type';
                                                $label = __('messages.input_'.$column);
                                                ?>
                                               <input type="hidden" name="{{$column}}" value="{{$page_type}}">
                                            </div>

                                            <div class="form-group col-12">
                                                <input type="hidden" name="data[excepts_not]" value="{{$column}}">
                                                @php
                                                    $column = 'comment';
                                                    $label= __('messages.input_comment');
                                                @endphp
                                                <textarea name="data_second[{{$column}}]"  class="form-control" placeholder="{{$label}}">{{isset($technical[$column]) ? $technical[$column] : old('data.'.$column)}}</textarea>

                                                <input type="hidden" name="data_second[type]"  class="form-control" placeholder="{{$label}}" value="{{$page_type}}">
                                                <input type="hidden" name="data_second[id]"  class="form-control" value="{{$page_id}}">

                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success mb-1">{{__('messages.status'.$status_data['confirmed'])}}</button>
                                                <button type="submit" name="cancel" value="{{$status_data['cancelled']}}" class="btn btn-danger mb-1">{{__('messages.status'.$status_data['cancelled'])}}</button>
                                            </div>
                                        </div>
                                        @endif
                                </form>

                                @endif
                            </div><!-- /.card-body -->
<br/>
                            <hr style="border: 1px solid #dddddd;"/>

                            <div id="message">
                                @php
                                    $page_type = MEDICAL;
                                    $page_id = isset($medical['id']) ? $medical['id'] : null;
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
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        @include('parts.medical_table')

                                        @if($medical['status']!=20)


                                        <div class="row">
                                            <div class="form-group col-12">

                                                <?php
                                                $column = 'page_type';
                                                $label = __('messages.input_'.$column);
                                                ?>
                                                <input type="hidden" name="data[excepts_not]" value="{{$column}}">

                                                <input type="hidden" name="{{$column}}" value="{{$page_type}}">
                                                @php
                                                    $column = 'comment';
                                                    $label= __('messages.input_comment');
                                                @endphp
                                                <textarea name="data_second[{{$column}}]" class="form-control" placeholder="{{$label}}">{{isset($medical[$column]) ? $medical[$column] : old('data.'.$column)}}</textarea>

                                                <input type="hidden" name="data_second[type]"  class="form-control" placeholder="{{$label}}" value="{{$page_type}}">
                                                <input type="hidden" name="data_second[id]"  class="form-control" value="{{$page_id}}">

                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success mb-1">{{__('messages.status'.$status_data['confirmed'])}}</button>
                                                <button type="submit" name="cancel" value="{{$status_data['cancelled']}}" class="btn btn-danger mb-1">{{__('messages.status'.$status_data['cancelled'])}}</button>
                                            </div>
                                        </div>
                                        @endif
                                </form>
                            </div>
                                @endif

                            @if(empty($document['table_flight_id']) and isset($flights_from_api) and empty($trip_id_get))

                              @include('parts.current_flights')

                            @endif

                            @if(isset($current_boarded_passengers['data']))

                              @include('parts.boarder_passengers')

                            @endif

                            <div id="message" class="grid">
                                <br/><br/>

                                @php
                                    $page_type = $type;
                                @endphp

                                <form action="" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="row {{$readonly_attribute=='hidden' ? $readonly_attribute : ''}}" id="inputs-bottom">
                                        @if(!empty($dispatcher_msg))
                                            <div class="col-12 alert alert-{{$msg_type}}"><h5><b>{!! $dispatcher_msg !!}</b></h5></div>
                                        @endif

                                            @if ($errors->any())
                                                <div class="col-12 alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <?php
                                            $label = __('messages.given_date');
                                            $column = 'given_date';
                                            ?>
                                            <input type="hidden" name="data[{{$column}}]"value="{{isset($row[$column]) ? $row[$column] : $today}}"/>

                                        <div class="form-group col-lg-6">
                                            <?php
                                            $column = 'table_flight_id';

                                                $trip_time = isset($current_flight['trip_time']) ? date('d.m.Y H:i', strtotime($current_flight['trip_time'])) : null;

                                                $get_flight = !empty($document[$column]) ? Data::table_flights(['id'=>$document[$column]]) : null;
                                                if(empty($get_flight)) {
                                                    $column = 'table_time_flight';
                                                }
                                                $column_value = 'table_time_flight';
                                                $label = __('messages.table_time_flight').' - '.__('messages.depend_on_flight');


                                                $value_column = isset($document[$column]) ? $document[$column] : old('data_second.'.$column);

                                            ?>
                                            <label for="exampleInputPassword1">{{$label}}</label>
                                            <input type="text" id="{{$column}}" name="data_second[{{$column}}]" class="form-control" readonly placeholder="{{$label}}" value="{{isset($trip_time) ? $trip_time : old('data.'.$column)}}" />
                                            <input type="hidden" name="data_second[{{$column}}]" value="{{$value_column}}" />
                                        </div>

                                        <!-- /.input group -->

                                        <div class="form-group col-lg-6">
                                            <?php
                                            $column = 'time_flight';
                                            $label = __('messages.'.$column).' - '.__('messages.current_time');

                                            ?>
                                            <label for="exampleInputPassword1">{{$label}}</label>
                                            <div class="input-group date" id="datetimepicker_{{$column}}{{$readonly_attribute}}" data-target-input="nearest">
                                                <input type="text" name="data_second[{{$column}}]" class="form-control datetimepicker-input" {{$readonly_attribute}} data-target="#datetimepicker_{{$column}}"  data-toggle="datetimepicker"  placeholder="{{$label}}" value="{{isset($trip_time) ? $trip_time : $today_time}}" />
                                            </div>

                                            <input type="hidden" name="data_second[type]" value="{{DOCUMENT}}">
                                            @php
                                                $column = 'sold_seats_count';
                                            @endphp
                                            @if(empty($document[$column]))
                                               <input type="hidden" name="data_second[sold_seats_count]" value="{{isset($current_flight[$column]) ? $current_flight[$column] : null}}">
                                            @endif
                                        </div>
                                        @if(empty($readonly_attribute))
                                                <div class="form-group col-12">

                                                    <?php
                                                    $column = 'page_type';
                                                    $label = __('messages.input_'.$column);
                                                    ?>
                                                    <input type="hidden" name="data[excepts_not]" value="{{$column}}">

                                                    <input type="hidden" name="{{$column}}" value="{{$page_type}}">
                                                    @if(isset($dispatcher['status']) and $dispatcher['status']==18)
                                                    <input type="hidden" name="status[{{$type}}]" value="{{$status_data['preview']}}">
                                                    @endif
                                                    <textarea name="data[{{$column}}]" style="display: none;" class="form-control" placeholder="{{$label}}">{{isset($medical[$column]) ? $medical[$column] : old('data.'.$column)}}</textarea>
                                                    <button type="submit" value="{{$status_data['confirmed']}}" class="btn btn-success">{{__('messages.input')}}</button>
                                                </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
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
