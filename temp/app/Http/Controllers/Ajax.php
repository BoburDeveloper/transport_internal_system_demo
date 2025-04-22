<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemQRCode;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Facades\Captcha;

class Ajax extends Controller {

    public function refreshCaptcha(){
        return captcha_src();
    }

}
