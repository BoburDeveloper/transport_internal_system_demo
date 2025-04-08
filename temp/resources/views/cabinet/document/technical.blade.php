<?php
use App\Models\Data;
?>
<!DOCTYPE html>
<html lang="en">
@include('parts.head')
@php
    $join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial, s.govnumber']);
    if(isset($technical)) {
        $technical = array_merge($technical, $join_row);
    }
    @endphp
<body>
<style>
    .document {
        width: 210mm;       /* A4 width */
        /*height: 297mm;      !* A4 height *!*/
        height: auto;      /* A4 height */
        margin: 0 auto;     /* Center the div horizontally (optional) */
        padding: 20mm;      /* Optional padding */
        box-sizing: border-box;
        border: 1px solid #000; /* Optional border */
    }
</style>
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
                                        {{__('messages.result_technical')}}
                                    </b></h3>
                            </div>
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
                                            <span class="{{$status_data[$page_type][$technical['status']]['color']}}">{{__('messages.send_status'.$technical['status'])}}</span>
                                        @endif
                                    </b></h3>
                                @include('parts.technical_table')
                                <div class="row">
                                    <div class="col-4">
                                        <p><b>{{__('messages.technical')}} {{__('messages.provided')}}:</b></p>
                                    </div>
                                    <div class="col-4">
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
                                        <span style="font-size: 18px;">Акмалов А.С.</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<!-- /.content -->

@include('parts.footer_scripts')
</body>
</html>
