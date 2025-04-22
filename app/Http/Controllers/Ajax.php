<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemQRCode;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Facades\Captcha;
use Illuminate\Http\Request;
use App\Models\Data;

class Ajax extends Controller {

    public function refreshCaptcha(){
        return captcha_src();
    }

    public function get_bus_models(Request $request, $lang, $id) {
    
        $bus_models = Data::bus_models(['condition'=>['transporter_id'=>$id]]);

        $column = 'vehicle_id';

        $output = '<option value="">'.__('messages.select').'</option>';

        foreach($bus_models as $key => $value) {

            $label = $value['label']." - ".$value['transporter']." - ".$value['bus_model'];

            $selected = isset($row[$column]) && (old('data.'.$column)==$row[$column] || $value['id']==$row[$column]) ? 'selected' : '';

            $output .= "<option value='".$value['id']."'
                            ".$selected."
                            data-vmodel_name='".htmlspecialchars($value['bus_model'], ENT_QUOTES)."' data-govnumber='".$value['bus_number']."'>
                            ".$label."
                    </option>";
        }

    return $output;

    }

}
