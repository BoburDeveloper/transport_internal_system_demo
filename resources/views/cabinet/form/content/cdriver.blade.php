@php
    $hidden_class = $item>1 ? 'hidden' : '';
    if(isset($value['driver_fio'])) {
        $row = $value;
        $hidden_class = '';
    }

@endphp
<div class="row driver-form driver-n{{$item}} {{$hidden_class}}">
    <div class="form-group col-lg-6">
        <?php
        $column = 'name_uz';
        $label = __('messages.driver_fio');
        $column_value = 'driver_fio';

        $visibility = 'visible';
        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
            $visibility = 'hidden';
        }
        ?>
        <div class="{{$visibility}}">
            <label><span class="item-num hidden">{{$item}}.</span> {{$label}}</label>
            <input type="text" name="data_multiple[{{$i}}][{{$column}}]" class="form-control" id="exampleInputEmail1" placeholder="{{$label}}" value="{{isset($row[$column_value]) ? $row[$column_value] : old('data_second.'.$column_value)}}" />
            <input type="hidden" name="data_multiple[{{$i}}][type]" value="{{DRIVERS}}" />
            <input type="hidden" name="data_multiple[{{$i}}][driver_id]" value="{{isset($row['driver_id']) ? $row['driver_id'] : 0}}" />
            <input type="hidden" name="form_type" value="{{isset($type) ? $type : null}}" />
            <input type="hidden" name="stage" value="{{isset($stage) ? $stage : null}}" />
            <input type="hidden" name="change" value="{{isset($change) ? $change : null}}" />
        </div>
    </div>
    <div class="form-group col-lg-6">
        <?php
        $column = 'numserial';
        $label = __('messages.'.$column);
        $column_value = 'numserial';

        $id_column = $item.'-'.$column;

        $visibility = 'visible';
        if(isset($content_nod_needed) and in_array($column, $content_nod_needed)) {
            $visibility = '$hidden';
        }
        ?>

        <div class="{{$visibility}}">
            <label for="exampleInputEmail1">{{$label}}</label>
            <input type="text" id="{{$id_column}}" name="data_multiple[{{$i}}][{{$column}}]" maxlength="32" class="form-control {{$column}}" placeholder="{{$label}}" value="{{isset($row[$column_value]) ? $row[$column_value] : old('data_second.'.$column_value)}}" />
        </div>
    </div>
</div>

<div class="modal fade" id="modal-dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="redb">{{__('messages.you_should_enter_ancii_symbols', ['name'=>__('messages.numserial')])}}</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        ascii_uppercase_cymbols('{{$id_column}}', '#modal-dialog');
    });
</script>
