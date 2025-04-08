<?php

use App\Models\Data;
$join_row = Data::get_join_row(['id'=>$id, 'select'=>'m.id driver_id, m.sort, m.name_uz driver_fio, m.numserial, s.govnumber']);
if(isset($row)) {
    $row['data_first'] = $join_row;
}

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
                        @if(isset($current_flight))
                        <p class="card-title bold">{{__('messages.flight_id')}}: {{$current_flight['route_name']}}</p>
                        <div class="clearfix"></div>
                        <p class="card-title bold mb-2">{{__('messages.table_time_flight')}}: {{$current_flight['trip_time']}}</p>
                        <div class="clearfix"></div>
                        <hr/>
                        @endif
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
                                <p><b>{{__('messages.status')}}: <span
                                            class="{{$status_data[$row['status']]['color']}}">{{__('messages.permission_status'.$row['status'])}}</span></b>
                                </p>

                                @if(!empty($row['comment']) and $row['status']==5)
                                    <p><b>{{__('messages.comment')}}:</b> 
                                        {{$row['comment']}}
                                    </p>
                                @endif
                            @endif

                            <form action="" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="row">
                                        <?php
                                        if(isset($current_flight['route_name'])) {
                                            $row_value = 999;
                                        }
                                        ?>

                                        @include('cabinet.form.content.select_flights')


                                    <?php 
                                        $readonly_flight = '';
                                        $col_class_num='3';
                                        $column = 'flight_name_uz';
                                        $column_name = 'flight_id';
                                        // $label = __('messages.or_write' );
                                        $label = __('messages.flight_id' );
                                        $visibility = 'visible';
                                        if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        $row_value = isset($row[$column]) ? $row[$column] : null;
                                         if(isset($current_flight['route_name'])) {
                                            $row_value = $current_flight['route_name'];
                                            $readonly_flight = 'readonly';
                                        }
                                       
                                    ?>
                                    <div class="form-group col-lg-{{$col_class_num}}">
                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <input type="text" class="form-control" id="{{$column}}{{$readonly_flight}}" name="data[{{$column}}]" placeholder="{{__('messages.'.$column_name)}}" value="{{$row_value}}" {{$readonly_flight}}>
                                        </div>

                                        <input type="hidden" name="data_second[type]" value="{{DOCUMENT}}">
                                         @php
                                                $column = 'sold_seats_count';
                                            @endphp
                                            @if(empty($document[$column]))
                                               <input type="hidden" name="data_second[sold_seats_count]" value="{{isset($current_flight[$column]) ? $current_flight[$column] : null}}">
                                            @endif

                                            @php
                                                $column = 'seats_count';
                                            @endphp
                                            @if(empty($document[$column]))
                                               <input type="hidden" name="data_second[seats_count]" value="{{isset($current_flight[$column]) ? $current_flight[$column] : null}}">
                                            @endif


                                            @php
                                            $column = 'table_flight_id';
                                            @endphp
                                           <input type="hidden" name="data_second[{{$column}}]" value="{{$trip_id_get}}" />

                                    </div>
                            
                                    <div class="form-group col-lg-3">
                                        <?php
                                        $column = 'carrier_id';
                                        $label = __('messages.' . $column);
                                        $carriers = Data::carriers();

                                        $visibility = 'visible';
                                        if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <select class="form-control select2 flight" id="{{$column}}" name="data[{{$column}}]">
                                                <option value="">{{__('messages.select')}}</option>
                                                @foreach($carriers as $key => $value)
                                                    <option value="{{$value['id']}}"
                                                        {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}>{{$value['label']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <?php
                                        $column = 'carrier_name';
                                        $column_name = 'carrier_id';
                                        $label = __('messages.or_write' );

                                        $visibility = 'visible';
                                        if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                            $visibility = 'hidden';
                                        }
                                        ?>

                                        <div class="{{$visibility}}">
                                            <label for="exampleInputEmail1">{{$label}}</label>
                                            <input type="text" class="form-control" id="{{$column}}" name="data[{{$column}}]" placeholder="{{__('messages.'.$column_name)}}" value="{{isset($row[$column]) ? $row[$column] : null}}" >
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $max_drivers = 3;

                                        $item = 1;
                                        $i = -1;
                                @endphp
                                @if(empty($row['data_first']))
                                    @for($item=1; $item<=$max_drivers; $item++)
                                        @php
                                            $i++;
                                        @endphp
                                        @include('cabinet.form.content.cdriver')
                                    @endfor
                                @else
                                    @foreach($row['data_first'] as $key => $value)
                                        @php
                                            $item = $key+1;
                                            $i = $key;
                                        @endphp
                                        @include('cabinet.form.content.cdriver')
                                    @endforeach
                                @endif

                                @php

                                    @endphp
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <?php
                                            $column = 'vehicle_id';
                                            $label = __('messages.govnumber').__('messages.select_of');
                                            $bus_models = Data::bus_models();

                                            $visibility = 'visible';
                                            if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                                $visibility = 'hidden';
                                            }
                                            ?>

                                            <div class="{{$visibility}}">
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <select class="form-control select2" id="{{$column}}" name="data[{{$column}}]">
                                                    <option value="">{{__('messages.select')}}</option>
                                                    @foreach($bus_models as $key => $value)
                                                        <option
                                                            value="{{$value['id']}}"
                                                            {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}
                                                            data-vmodel_name="{{htmlspecialchars($value['bus_model'], ENT_QUOTES)}}" data-govnumber="{{$value['bus_number']}}">
                                                                {{$value['label']}} - {{$value['transporter']}} - {{$value['bus_model']}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>

                                        <div class="form-group col-lg-3">
                                            <?php
                                            $column = 'govnumber';
                                            $label = __('messages.or_write');

                                            $visibility = 'visible';
                                            if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                                $visibility = 'hidden';
                                            }
                                            ?>

                                            <div class="{{$visibility}}">
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <input type="text" class="form-control numserial" id="{{$column}}" name="data[{{$column}}]" placeholder="{{__('messages.'.$column)}}" value="{{isset($row[$column]) ? $row[$column] : null}}" >
                                            </div>



                                        </div>

                                        <div class="form-group col-lg-3">
                                            <?php
                                            $column = 'vmodel_id';
                                            $label = __('messages.' . $column).__('messages.select_of');
                                            $vmodels = Data::vmodels();

                                            $visibility = 'visible';
                                            if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                                $visibility = 'hidden';
                                            }
                                            ?>

                                            <div class="{{$visibility}}">
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <select class="form-control select2" id="{{$column}}" name="data[{{$column}}]">
                                                    <option value="">{{__('messages.select')}}</option>
                                                    @foreach($vmodels as $key => $value)
                                                        <option
                                                            value="{{$value['id']}}" {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}>{{$value['label']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <?php
                                            $column = 'vmodel_name';                                        
                                            $label = __('messages.or_write' );
                                            $visibility = 'visible';
                                            if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
                                                $visibility = 'hidden';
                                            }
                                            ?>

                                            <div class="{{$visibility}}">
                                                <label for="exampleInputPassword1">{{$label}}</label>
                                                <input type="text" class="form-control" id="{{$column}}" name="data[{{$column}}]" placeholder="{{__('messages.'.$column)}}" value="{{isset($row[$column]) ? $row[$column] : null}}" >
                                            </div>
                                        </div>

                                    </div>

                                 <div class="row">
                                    <?php
                                    $label = __('messages.given_date');
                                    $column = 'given_date';
                                    ?>
                                    <input type="hidden" name="data[{{$column}}]"
                                           value="{{isset($row[$column]) ? $row[$column] : $today}}"/>
                                </div>

                                @if(empty($row['status']) or (isset($row['status']) and !in_array($row['status'], [20])))
                                    @php
                                        $cancel_btn = true;
                                        if(isset($content_nod_needed) and $user['username']==DISPATCHER) {
                                            $cancel_btn = false;
                                        }
                                    @endphp
                                    <div class="form-group">
                                        <button type="submit" name="confirm" value="{{$status_data['status_second']}}"
                                                class="btn btn-success mb-1">{{__('messages.permission_work')}}</button>
                                        @if($cancel_btn)
                                            <button type="submit" name="cancel"
                                                    value="{{$status_data['cancel_status_second']}}"
                                                    class="btn btn-danger mb-1">{{__('messages.no_permission_work')}}</button>
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

<div class="modal fade" id="modal-dialog-second" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="redb">{{__('messages.you_should_enter_ancii_symbols', ['name'=>__('messages.govnumber')])}}</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let max_drivers = {{$max_drivers}};
    let new_status_value = 999;
    
    $(document).ready(function (){
        ascii_uppercase_cymbols('govnumber', '#modal-dialog-second');
    });


    $('#flight_id').on('change', function () {
        let flight_id = $(this).val();
        let flight_text = $(this).find('option:selected').text().trim();
        let num_drivers = $(this).find('option:selected').data('num_drivers');
        let table_flight_id = $(this).find('option:selected').data('table_flight_id');
        if (typeof num_drivers !== 'undefined') {
            let i = 0;
            for (i = 1; i <= max_drivers; i++) {
                if (i <= num_drivers) {
                    $('.driver-n' + i).removeClass('hidden');
                } else {
                    $('.driver-n' + i).addClass('hidden');
                }

                if (i > 1) {
                    $('.item-num').removeClass('hidden');
                }
            }
        }

        if(typeof flight_id !== 'undefined' && flight_id != new_status_value) {
               $('#flight_name_uz').val(flight_text);
        }

    });

    $('#carrier_id').on('change', function () {
      let value = $(this).val();
      let text = $(this).find('option:selected').text().trim();

      if(typeof value !== 'undefined' && value != new_status_value) {
                $('#carrier_name').val(text);
          }

    });

    $('#vehicle_id').on('change', function () {
        let value = $(this).val();
        let text = $(this).find('option:selected').text().trim();
        let govnumber = $(this).find('option:selected').data('govnumber');
        let vmodel_name = $(this).find('option:selected').data('vmodel_name');

        if(typeof value !== 'undefined' && value != new_status_value) {
            $('#govnumber').val(govnumber);
        }

    });

    $('#vmodel_id').on('change', function () {
        let value = $(this).val();
        let text = $(this).find('option:selected').text().trim();
        if(typeof value !== 'undefined' && value != new_status_value) {
            $('#vmodel_name').val(text);
        }
    });

    $('#flight_name_uz').on('input', function () {
       $('#flight_id').val(new_status_value).trigger('change');
    });

    $('#carrier_name').on('input', function () {
        $('#carrier_id').val(new_status_value).trigger('change');
    });

    $('#govnumber').on('input', function () {
        $('#vehicle_id').val(new_status_value).trigger('change');
    });

    $('#vmodel_name').on('input', function () {
        $('#vmodel_id').val(new_status_value).trigger('change');
    });

</script>

@if(isset($stage) and isset($change))

    @include('parts.footer_scripts')
    @include('parts.bottom')

@endif
