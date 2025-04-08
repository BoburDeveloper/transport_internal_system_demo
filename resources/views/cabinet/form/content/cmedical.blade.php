@php
    $row_id = isset($value['id']) ? $value['id'] : 0;

@endphp
@if(isset($value['status']))
    <p><b>{{__('messages.status')}}: <span class="{{$status_data[$value['status']]['color']}}">{{__('messages.permission_status'.$value['status'])}}</span></b></p>
    @if(!empty($value['comment']) and $value['status']==5)
        <p><b>{{__('messages.comment')}}:</b> {{$value['comment']}}</p>
        <hr/>
    @endif
@endif

<form action="" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
<div class="row">

    <input type="hidden" name="row_id" value="{{$row_id}}">
    <?php
    $column = 'driver_id';
    ?>
    <input type="hidden" name="data[{{$column}}]" value="{{$value[$column]}}">

    <div class="form-group col-lg-3">
        <?php
        $column = 'temperature';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control float" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $label = __('messages.pulse');
        $column = 'pulse';
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'bpressure_begin';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
    </div>
    <div class="form-group col-lg-3">
        <?php
        $column = 'bpressure_end';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control integer-positive" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
    </div>
</div>

<div class="row">

    <div class="form-group col-lg-6">
        <?php
        $column = 'diagnostic';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" name="data[{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
    </div>

    <div class="form-group col-lg-3">
        <?php
        $column = 'time_begin';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputPassword1">{{$label}}</label>
        <div class="input-group date" id="datetimepicker-{{$value['driver_id']}}{{$readonly_attribute}}" data-target-input="nearest">
            <input type="text" name="data[{{$column}}]" class="form-control datetimepicker-input" data-target="#datetimepicker-{{$value['driver_id']}}" data-toggle="datetimepicker" placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
        </div>
    </div>
    <!-- /.input group -->

    <div class="form-group col-lg-3">
        <?php
        $column = 'time_end';
        $label = __('messages.'.$column);
        ?>
        <label for="exampleInputPassword1">{{$label}}</label>
        <div class="input-group date" id="datetimepicker_second-{{$value['driver_id']}}{{$readonly_attribute}}" data-target-input="nearest">
            <input type="text" name="data[{{$column}}]" class="form-control datetimepicker-input" data-target="#datetimepicker_second-{{$value['driver_id']}}"  data-toggle="datetimepicker"  placeholder="{{$label}}" value="{{isset($value[$column]) ? $value[$column] : old('data.'.$column)}}" />
        </div>
    </div>
</div>

<div class="row">


    <?php
    $column = 'time_med_exam';
    $label = __('messages.'.$column);
    ?>
    <input type="hidden" name="data[{{$column}}]" value="{{isset($value[$column]) ? $value[$column] : $today}}" />

    <?php
    $column = 'given_date';
    $label = __('messages.'.$column);
    ?>
    <input type="hidden" name="data[{{$column}}]"  value="{{isset($value[$column]) ? $value[$column] : $today}}" />
</div>

@if(empty($value['status']) or (isset($value['status']) and !in_array($value['status'], [20])))
    <div class="form-group">
        <button type="submit" name="confirm" value="{{$status_data['status_second']}}" class="btn btn-success mb-1">{{__('messages.permission_work')}}</button>
        <button type="submit" name="cancel" value="{{$status_data['cancel_status_second']}}" class="btn btn-danger mb-1">{{__('messages.no_permission_work')}}</button>
    </div>
@endif

</form>
