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

    @foreach($column_names[$page_type]['columns'] as $key => $value)
    @php
    $i++;
    @endphp
    @if($value['column_name']=='driver_id')

    @php
    $column = 'driver_fio';
    @endphp
    <tr>
        <td>{{$i}}</td>
        <td>{{__('messages.'.$column)}}</td>
        <td>{{$technical[$column]}}
            @if($type==DISPATCHER and in_array($technical['status'], [$status_data[TECHNICAL]['status_second']]))
            <a href="javascript:void(0);" id="{{$column}}" data-id="{{$technical['driver_id']}}" class="edit-driver-info"><i class="fas fa-edit"></i></a>
            @endif
        </td>
    </tr>
    @php
    $column = 'numserial';
    @endphp
    <tr>
        <td>{{$i}}</td>
        <td>{{__('messages.'.$column)}}</td>
        <td>{{$technical[$column]}}
            @if($type==DISPATCHER and in_array($technical['status'], [$status_data[TECHNICAL]['status_second']]))
            <a href="javascript:void(0);" id="{{$column}}"  data-id="{{$technical['driver_id']}}" class="edit-driver-info"><i class="fas fa-edit"></i></a>
            @endif
        </td>
    </tr>
    @else
    <tr>
        <td>{{$i}}</td>
        <td>{{__('messages.'.$value['column_name'])}}</td>
        <td>{{$technical[$value['column_name']]}}</td>
    </tr>
    @endif


    @endforeach
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.edit-driver-info').on('click', function (){
       $.ajax({
          url:'{{url('/'.app()->getLocale().'/cabinet/form/'.TECHNICAL.'/'.$id)}}',
           method:'get',
           data: {'ctype': '{{'c'.TECHNICAL}}', 'content_not_needed':'flight_id,govnumber,vmodel_id', 'stage':'{{$type}}', 'form_type':'{{TECHNICAL}}'},
           success:function (data) {
               let modal_name = '#exampleModal';
               $(modal_name).modal('show');
               $(modal_name+' .modal-body').html(data);
           }
       });
    });
</script>
