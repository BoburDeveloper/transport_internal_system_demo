<!DOCTYPE html>
<html lang="en">
@include('parts.head')
<body>

<style>
    .document {
        width: 310mm;       /* A4 width */
        /*height: 297mm;      !* A4 height *!*/
        height: auto;      /* A4 height */
        margin: 0 auto;     /* Center the div horizontally (optional) */
        padding: 10mm;      /* Optional padding */
        box-sizing: border-box;
        border: 1px solid #000; /* Optional border */
    }
</style>
<?php
use App\Models\Data;

$join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial']);
if(isset($join_row['driver_id']) and isset($technical['driver_id'])) {
    $technical = array_merge($technical, $join_row);
}
?>

    <!-- Main content -->
    <section class="content document">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h3 class="mb-4"><b>
                                            {{__('messages.result')}}
                                        </b></h3>
                                </div>
                            <div id="message" class="col-6">
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
                                            <span class="{{$status_data[$page_type][$technical['status']]['color']}}">{{__('messages.send_status'.$technical['status'])}}</span>
                                        @endif
                                    </b></h3>
                                <div class="clearfix"></div>
                                <p><b>{{__('messages.technical')}} {{__('messages.provided')}}:</b>
                                    <span class="blueb">Акмалов А.С.</span>
                                </p>
                                <p><b>{{__('messages.provided_date')}}:</b>
                                    <span class="blueb">{{$technical['given_date']}}</span>
                                </p>
                                <p>
                                    <b><a href={{url('/'.app()->getLocale().'/site/'.$page_type.'/'.$id)}}> {{__('messages.view_conclusion')}}: </a></b>
                                </p>
                                <div id="qr-code">
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
                                    $type = pathinfo($path, PATHINFO_EXTENSION);

                                    $arrContextOptions=array(
                                        "ssl"=>array(
                                            "verify_peer"=>false,
                                            "verify_peer_name"=>false,
                                        ),
                                    );
                                    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    // echo $file3;
                                    ?>
                                    <img src="<?=$base64?>" />
                                </div>
                            </div><!-- /.card-body -->

                            <div id="message" class="col-6">
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

                                <h3 class="card-title mb-2"><b>{{__('messages.result_'.$page_type)}}: @if(isset($medical['status']))
                                            <span class="{{$status_data[$page_type][$medical['status']]['color']}}">{{__('messages.permission_status'.$medical['status'])}}</span>
                                        @endif</b></h3>
                                <div class="clearfix"></div>
                                <p><b>{{__('messages.medical')}} {{__('messages.provided')}}:</b>
                                    <span class="blueb">Мадиёров К.С.</span></p>
                                <p>

                                <p><b>{{__('messages.provided_date')}}:</b>
                                    <span class="blueb">{{$medical['given_date']}}</span>
                                </p>
                                    <b><a href={{url('/'.app()->getLocale().'/site/'.$page_type.'/'.$id)}}> {{__('messages.view_conclusion')}}: </a></b>
                                </p>
                                <div id="qr-code">
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
                                    $type = pathinfo($path, PATHINFO_EXTENSION);

                                    $arrContextOptions=array(
                                        "ssl"=>array(
                                            "verify_peer"=>false,
                                            "verify_peer_name"=>false,
                                        ),
                                    );
                                    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    // echo $file3;
                                    ?>
                                    <img src="<?=$base64?>" />
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>

                            <div class="clearfix"></div>
                            <hr style="border: 1px solid #dddddd;"/>

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

                                <h3 class="card-title mb-2 text-center col-12"><b>Йўловчилар рўйҳати</b></h3>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Ф.И.О.</th>
                                        <th>Ўриндиқ рақами</th>
                                        <th>Телефонг рақами</th>
                                        <th>Туҳилган йили</th>
                                        <th>Паспорт серияси ва рақами</th>
                                        <th>Фуқаролиги</th>
                                        <th>Қаергача</th>
                                        <th>Билет нарҳи</th>
                                        <th>Тўлов тури</th>
                                        <th>Билет рақами</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Олимжанов М.А.</td>
                                        <td>26</td>
                                        <td>+998 90 211-21-36</td>
                                        <td>10.02.1994</td>
                                        <td>АА 11422335</td>
                                        <td>Ўзбекистон</td>
                                        <td>Бухоро шахри</td>
                                        <td>77 000</td>
                                        <td>Нақд</td>
                                        <td>16</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Арифджанов М.Н.</td>
                                        <td>27</td>
                                        <td>+998 90 211-21-36</td>
                                        <td>10.02.1994</td>
                                        <td>АА 11422335</td>
                                        <td>Ўзбекистон</td>
                                        <td>Бухоро шахри</td>
                                        <td>77 000</td>
                                        <td>Нақд</td>
                                        <td>16</td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->

                        <div class="clearfix"></div>
                            <hr style="border: 1px solid #dddddd;"/>

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
                                        @endif
                                    </b></h3>

                                <div class="clearfix"></div>
                                <p><b>{{__('messages.dispatcher')}}:</b>
                                    <span class="blueb">Агзамов Р.Ш.</span></p>
                                <p>
                                    <b><a href={{url('/'.app()->getLocale().'/site/'.$page_type.'/'.$id)}}> {{__('messages.view_conclusion')}}: </a></b>
                                </p>
                                <div id="qr-code">
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
                                    $type = pathinfo($path, PATHINFO_EXTENSION);

                                    $arrContextOptions=array(
                                        "ssl"=>array(
                                            "verify_peer"=>false,
                                            "verify_peer_name"=>false,
                                        ),
                                    );
                                    $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    // echo $file3;
                                    ?>
                                    <img src="<?=$base64?>" />
                                </div>
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
                                <div class="row">
                                    <div class="col-5">
                                        <h3 class="card-title mb-2"><b>{{__('messages.result_'.$page_type)}}:
                                                @if(isset($director['status']))
                                                    <span class="{{$status_data[$page_type][$director['status']]['color']}}">{{__('messages.end_status'.$director['status'])}}</span>
                                                @endif
                                            </b></h3>
                                    </div>
                                    <div class="col-3">
                                        <div id="qr-code">
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
                                            $type = pathinfo($path, PATHINFO_EXTENSION);

                                            $arrContextOptions=array(
                                                "ssl"=>array(
                                                    "verify_peer"=>false,
                                                    "verify_peer_name"=>false,
                                                ),
                                            );
                                            $data = file_get_contents($path, false, stream_context_create($arrContextOptions));
                                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                            // echo $file3;
                                            ?>
                                            <img src="<?=$base64?>" />
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <h3 class="card-title mb-2"><b>
                                                {{__('messages.fio')}}
                                            </b></h3>
                                    </div>
                                </div>


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


@include('parts.footer_scripts')
</body>
</html>
