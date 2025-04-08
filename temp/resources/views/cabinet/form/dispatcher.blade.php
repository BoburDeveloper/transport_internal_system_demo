@extends('layouts.main')
@section('content')
    <?php
    use App\Models\Data;
    $dispatcher_msg = '';
    $msg_type = 'danger';

    $join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial']);
    if(isset($join_row['driver_id']) and isset($technical['driver_id'])) {
        $technical = array_merge($technical, $join_row);
    }
    ?>
    <!-- Content Header (Page header) -->
    @include('cabinet.detail.parts.header')
    <!-- /.content-header -->

    <!-- Main content -->
    @if(isset($dispatcher['status']) && $dispatcher['status']==19 && empty($document['table_time_flight']) && empty($document['time_flight']))
    @php
        $dispatcher_msg = '<i class="fa-lg mt-2 fas fa-exclamation-circle"></i> '.__('messages.fill_the_time_table_flight');
        $readonly_attribute = '';
    @endphp
    <script type="text/javascript">
        //inputs-bottom
        document.addEventListener("DOMContentLoaded", function() {
            const inputField = document.getElementById("table_time_flight");
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
    @elseif(isset($document['table_time_flight']) and isset($document['time_flight']))
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
                                                $column = 'comment';
                                                $label = __('messages.input_'.$column);
                                                ?>
                                               <input type="hidden" name="page_type" value="{{$page_type}}">
                                            </div>

                                            <div class="form-group col-12">
                                                <input type="hidden" name="data[excepts_not]" value="{{$column}}">
                                                <textarea name="data[{{$column}}]" style="display: none;" class="form-control" placeholder="{{$label}}">{{isset($technical[$column]) ? $technical[$column] : old('data.'.$column)}}</textarea>
                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success">{{__('messages.status'.$status_data['confirmed'])}}</button>
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
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        @include('parts.medical_table')

                                        @if($medical['status']!=20)


                                        <div class="row">
                                            <div class="form-group col-12">

                                                <?php
                                                $column = 'comment';
                                                $label = __('messages.input_'.$column);
                                                ?>
                                                <input type="hidden" name="data[excepts_not]" value="{{$column}}">

                                                <input type="hidden" name="page_type" value="{{$page_type}}">

                                                <textarea name="data[{{$column}}]" style="display: none;" class="form-control" placeholder="{{$label}}">{{isset($medical[$column]) ? $medical[$column] : old('data.'.$column)}}</textarea>
                                                <button type="submit" name="confirm" value="{{$status_data['confirmed']}}" class="btn btn-success">{{__('messages.status'.$status_data['confirmed'])}}</button>
                                            </div>
                                        </div>
                                        @endif
                                </form>
                            </div>
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

                                        <div class="form-group col-6">
                                            <?php
                                            $column = 'table_time_flight';
                                            $label = __('messages.'.$column);


                                            ?>
                                            <label for="exampleInputPassword1">{{$label}}</label>
                                            <div class="input-group date" id="datetimepicker{{$readonly_attribute}}" data-target-input="nearest">
                                                <input type="text" id="{{$column}}" name="data_second[{{$column}}]" class="form-control datetimepicker-input" {{$readonly_attribute}} data-target="#datetimepicker" data-toggle="datetimepicker" placeholder="{{$label}}" value="{{isset($document[$column]) ? $document[$column] : old('data.'.$column)}}" />
                                            </div>
                                        </div>
                                        <!-- /.input group -->

                                        <div class="form-group col-6">
                                            <?php
                                            $column = 'time_flight';
                                            $label = __('messages.'.$column);
                                            ?>
                                            <label for="exampleInputPassword1">{{$label}}</label>
                                            <div class="input-group date" id="datetimepicker_second{{$readonly_attribute}}" data-target-input="nearest">
                                                <input type="text" name="data_second[{{$column}}]" class="form-control datetimepicker-input" {{$readonly_attribute}} data-target="#datetimepicker_second"  data-toggle="datetimepicker"  placeholder="{{$label}}" value="{{isset($document[$column]) ? $document[$column] : old('data.'.$column)}}" />

                                            </div>

                                            <input type="hidden" name="data_second[type]" value="{{DOCUMENT}}">

                                        </div>
                                        @if(empty($readonly_attribute))
                                                <div class="form-group col-12">

                                                    <?php
                                                    $column = 'comment';
                                                    $label = __('messages.input_'.$column);
                                                    ?>
                                                    <input type="hidden" name="data[excepts_not]" value="{{$column}}">

                                                    <input type="hidden" name="page_type" value="{{$page_type}}">

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
