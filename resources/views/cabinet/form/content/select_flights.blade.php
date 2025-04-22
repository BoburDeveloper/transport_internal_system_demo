<?php
use App\Models\Data;
?>

    <div class="form-group col-lg-3">
        <?php
        $column = 'flight_id';
        $label = __('messages.' . $column);
        $flights = Data::flights();
        $visibility = 'visible';
        if (isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
            $visibility = 'hidden';
        }
        if(isset($row_value)) {
            $row[$column] = $row_value;
        }
        ?>

        <div class="{{$visibility}}">
            <label for="exampleInputEmail1">{{$label}}</label>
            <select class="form-control select2 flight" id="{{$column}}" name="data[{{$column}}]">
                <option value="">{{__('messages.select')}}</option>
                @foreach($flights as $key => $value)
                    <option value="{{$value['id']}}"
                            data-num_drivers="{{$value['num_drivers']}}" data-table_flight_id="{{$value['table_flight_id']}}" {{isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : ''}}>{{$value['label']}}</option>
                @endforeach
            </select>
        </div>
        
        <?php
        $column = 'table_flight_id';
        ?>
        <input type="hidden" id="{{$column}}" name="data_second[{{$column}}]" value="{{isset($document[$column]) ? $document[$column] : 0}}">

        <input type="hidden" name="data_second[type]" value="{{DOCUMENT}}">
    </div>
