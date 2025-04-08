<?php
use App\Models\Data;

$get_vmodels = Data::vmodels();
$vmodel = \App\Providers\AppServiceProvider::searchForId($technical['vmodel_id'], 'id', $get_vmodels);
$get_flights = Data::flights();
$flight = \App\Providers\AppServiceProvider::searchForId($technical['flight_id'], 'id', $get_flights);

$join_row = Data::get_join_row(['id'=>$id, 'select'=>'s.driver_id, m.name_uz driver_fio, m.numserial']);
if(isset($join_row['driver_id']) and isset($technical['driver_id'])) {
    $technical = array_merge($technical, $join_row);
}

$real_sold_seats = $document['sold_seats_count'];

if(!empty($current_boarded_passengers['data'])) {
    $real_sold_seats = count($current_boarded_passengers['data']);
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
                <div class="card document-card">

                    <div class="card-body">
                        <div class="row">
                            <div class="text-left col-6">
                                <img src="{{asset('img/mintrans.svg')}}" class="document-symbols" />
                            </div>
                            <div class="text-right col-6">
                                <img src="{{asset('img/icon.png')}}" class="document-symbols" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-12 text-center">
                                <h3 class="mb-4"><b>
                                        {{__('messages.last_document')}} №{{$id}}
                                    </b></h3>
                            </div>

                        </div>

                        <div class="clearfix"></div>
                        <hr style="border: 1px solid #dddddd;"/>

                        <div class="passengers-block">
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

                            <h3 class="card-title mb-2 text-center col-12"><b>{{__('messages.list_passengers')}}</b></h3>
                            <table class="table table-striped table-bordered passengers-table">
                                @include('parts.list_passengers', ['current_boarded_passengers'=>$current_boarded_passengers])
                                <tfoot>
                                <tr>
                                    <td colspan="11">
                                        @include('cabinet.document.content.qr_codes')
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

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
