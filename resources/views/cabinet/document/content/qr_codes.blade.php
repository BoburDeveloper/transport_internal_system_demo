@php
use App\Models\Data;

if(isset($flight['is_international']) and $flight['is_international']) {
    $drivers_label = 'Водители';
    $govnumber_label = 'Гос.номер Автобуса';
    $time_flight_label = 'Отправление';
    $num_passengers_label = 'Пассажиры';
    $driver_fio_label = 'Водител Ф.И.О';
    $carrier_label = 'Перевозчик';
} else {
    $drivers_label = __('messages.drivers');
    $govnumber_label = __('messages.govnumber');
    $time_flight_label = __('messages.time_flight');
    $num_passengers_label = __('messages.sold_seats_count');
    $driver_fio_label = __('messages.driver_fio');
    $carrier_label = __('messages.carrier_id');
}

@endphp

<div class="confirmed-block">

    <div class="row mb-3 mt-3">
        <div class="col-4">
            @php

                 $page_type = TECHNICAL;
                 $column = 'carrier_id';
                 $carrier = Data::carriers(['id'=>$technical[$column]]);
                 if(empty($carrier['name']) or (isset($carrier['id']) and $carrier['id']==999)) {
                     $carrier_name = $technical['carrier_name'];
                 } else {
                     $carrier_name = $carrier['name'];
                 }
            @endphp
            <div id="qr-code-{{$page_type}}" class="float-left qr-code-div">
                <?php
                $url = url('/site/info/'.$page_type).'/';
                $guid_is_ready = isset($document['guid_id']) ? true : false;
                if($guid_is_ready) {
                    $qrCodeText = $url.$document['guid_id'];
                } else {
                    $hash = \App\Providers\AppServiceProvider::generate_guid_id();
                    $qrCodeText = $url.$hash;
                }
                $path = config('app.url').'/SystemQRCode.php?s=qr&d='.$qrCodeText.'&sf=3&ms=r&md=1&wq=0';
                $mime_type = pathinfo($path, PATHINFO_EXTENSION);

                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                $base64 = 'data:image/' . $mime_type . ';base64,' . base64_encode($data);
                // echo $file3;
                ?>
                <img src="<?=$base64?>" class="qr-code-image" />
            </div>
            <h3 class="card-title qr-code-title">{{__('messages.result_'.$page_type)}}:
                @if(isset($technical['status']))
                    <span class="{{$status_data[$page_type][$technical['status']]['color']}}">{{__('messages.end_status'.$technical['status'])}}</span>
                @endif
            </h3>
            <p class="card-title qr-code-text "><span class="bold">{{__('messages.technical')}} {{__('messages.provided')}}:</span><br/>
                <span class="blueb">{{$staffs[$page_type]['name_uz']}}</span>
            </p>
            <p class="card-title qr-code-text"><span class="bold">{{__('messages.provided_date')}}:</span>
                <span class="blueb">{{$technical['given_date']}}</span>
            </p>
            <p class="card-title qr-code-text bold">
                <a href={{$qrCodeText}}> {{__('messages.view_conclusion')}}: </a>
            </p>
        </div>

        <div class="col-4">
            @php
                $page_type = MEDICAL;
            @endphp
            <div id="qr-code-{{$page_type}}" class="float-left qr-code-div">
                <?php
                $url = url('/site/info/'.$page_type).'/';
                $guid_is_ready = isset($document['guid_id']) ? true : false;
                if($guid_is_ready) {
                    $qrCodeText = $url.$document['guid_id'];
                } else {
                    $hash = \App\Providers\AppServiceProvider::generate_guid_id();
                    $qrCodeText = $url.$hash;
                }
                $path = config('app.url').'/SystemQRCode.php?s=qr&d='.$qrCodeText.'&sf=3&ms=r&md=1&wq=0';
                $mime_type = pathinfo($path, PATHINFO_EXTENSION);

                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                $base64 = 'data:image/' . $mime_type . ';base64,' . base64_encode($data);
                // echo $file3;
                ?>
                <img src="<?=$base64?>" class="qr-code-image" />
            </div>
            <h3 class="card-title qr-code-title">{{__('messages.result_'.$page_type)}}:
                @if(isset($medical['status']))
                    <span class="{{$status_data[$page_type][$medical['status']]['color']}}">{{__('messages.end_status'.$medical['status'])}}</span>
                @endif
            </h3>
            <p class="card-title qr-code-text "><span class="bold">{{__('messages.medical')}} {{__('messages.provided')}}:</span><br/>
                <span class="blueb">{{$staffs[$page_type]['name_uz']}}</span>
            </p>
            <p class="card-title qr-code-text"><span class="bold">{{__('messages.provided_date')}}:</span>
                <span class="blueb">{{$medical['given_date']}}</span>
            </p>
            <p class="card-title qr-code-text bold">
                <a href={{$qrCodeText}}> {{__('messages.view_conclusion')}}: </a>
            </p>
        </div>


        <div class="col-4">
            @php
                $page_type = DISPATCHER;
            @endphp
            <div id="qr-code-{{$page_type}}" class="float-left qr-code-div">
                <?php
                $url = url('/site/info/'.$page_type).'/';
                $guid_is_ready = isset($document['guid_id']) ? true : false;
                if($guid_is_ready) {
                    $qrCodeText = $url.$document['guid_id'];
                } else {
                    $hash = \App\Providers\AppServiceProvider::generate_guid_id();
                    $qrCodeText = $url.$hash;
                }
                $path = config('app.url').'/SystemQRCode.php?s=qr&d='.$qrCodeText.'&sf=3&ms=r&md=1&wq=0';
                $mime_type = pathinfo($path, PATHINFO_EXTENSION);

                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );
                $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                $base64 = 'data:image/' . $mime_type . ';base64,' . base64_encode($data);
                // echo $file3;
                ?>
                <img src="<?=$base64?>" class="qr-code-image" />
            </div>
            <h3 class="card-title qr-code-title">{{__('messages.result_'.$page_type)}}:
                @if(isset($medical['status']))
                    <span class="{{$status_data[$page_type][$medical['status']]['color']}}">{{__('messages.end_status'.$medical['status'])}}</span>
                @endif
            </h3>
            <p class="card-title qr-code-text"><span class="bold">{{__('messages.dispatcher')}} :</span><br/>
                <span class="blueb">{{$staffs[$page_type]['name_uz']}}</span>
            </p>
            <p class="card-title qr-code-text"><span class="bold">{{__('messages.provided_date')}}:</span>
                <span class="blueb">{{$dispatcher['given_date']}}</span>
            </p>
            <p class="card-title qr-code-text bold">
                <a href={{$qrCodeText}}> {{__('messages.view_conclusion')}}: </a>
            </p>
        </div>

    </div>

    <div class="row">
            @php
                $page_type = DIRECTOR;
            @endphp

            <div class="col-4">
               @php 
               if(isset($join_row)) {
                   $drivers = $join_row;
               }
               @endphp
               @if(!empty($drivers))
                    <br/>
                    <p class="card-title qr-code-text bold col-12">{{$drivers_label}}:</p>
                    @foreach($drivers as $key => $value)
                    @php  $i = $key+1; @endphp
                         <p class="card-title qr-code-text col-12"><span class="bold">{{$i}}. {{$driver_fio_label}} :</span>
                            <span class="blueb">{{$value['driver_fio']}}</span>
                        </p>
                    @endforeach
               @endif
            </div>
            <div class="col-4">
                 <div id="qr-code-{{$page_type}}" class="qr-code-div float-left">
                    <?php
                    $url = url('/site/info/'.$type).'/';
                    $guid_is_ready = isset($document['guid_id']) ? true : false;
                    if($guid_is_ready) {
                        $qrCodeText = $url.$document['guid_id'];
                    } else {
                        $hash = \App\Providers\AppServiceProvider::generate_guid_id();
                        $qrCodeText = $url.$hash;
                    }
                    $path = config('app.url').'/SystemQRCode.php?s=qr&d='.$qrCodeText.'&sf=3&ms=r&md=1&wq=0';
                    $mime_type = pathinfo($path, PATHINFO_EXTENSION);

                    $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
                    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                    $base64 = 'data:image/' . $mime_type . ';base64,' . base64_encode($data);

                    // echo $file3;
                    ?>
                    <img src="<?=$base64?>" class="qr-code-image" />
                </div>
                <h3 class="card-title qr-code-title mt-5">{{$staffs[$page_type]['post_name_'.app()->getLocale()]}}:
                    @if(isset($director['status']))
                        <span class="{{$status_data[$page_type][$director['status']]['color']}}">{{__('messages.end_status'.$director['status'])}}</span>
                    @endif
                </h3>
                   @if($director['status']==STATUS_CONFIRMED and isset($director['updated_time']))
                        <p class="card-title qr-code-text"><span class="bold">{{__('messages.date')}}:</span>
                            <span class="blueb">{{$director['updated_time']}}</span>
                        </p>
                    @endif
                <div class="clearfix"></div>
            </div>

            <div class="col-4">
                <p class="card-title qr-code-text col-12"><span class="bold">{{$govnumber_label}}:</span>
                    <span class="blueb">{{$technical['govnumber']}}</span>
                </p>
                <p class="card-title qr-code-text col-12"><span class="bold">{{$carrier_label}}:</span><br/>
                    <span class="blueb">{{$carrier_name}}</span>
                </p>
                <p class="card-title qr-code-text col-12"><span class="bold">{{$time_flight_label}}:</span>
                    <span class="blueb">{{$document['time_flight']}}</span>
                </p>
                <p class="card-title qr-code-text col-12"><span class="bold">{{$num_passengers_label}}:</span>
                    <span class="blueb">{{$real_sold_seats}}</span>
                </p>
            </div>

    </div>
</div>
    <!-- /.card-body -->
