<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
date_default_timezone_set('Asia/Tashkent');
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct() {
        $this->middleware(function ($request, $next){
            $excepted_url = ['/site/login',  '/ajax/refreshcaptcha', '/site/info'];
            $login_page = $excepted_url[0];
            $this->data = [];
            $this->data['today'] = date('d.m.Y');
            $this->data['today_time'] = date('d.m.Y H:i:s');
            $session_data = \session()->all();
            if(isset($session_data['user']['id'])) {
                $this->data['user'] = $session_data['user'];
            } else {
                if(in_array($request->segment(1), ['uz','oz'])) {
                    $first_symbol = $request->segment(2) ? '/' : '';
                    $current_url_action = $first_symbol.$request->segment(2).'/'.$request->segment(3);
                } else {
                    $first_symbol = $request->segment(1) ? '/' : '';
                    $current_url_action = $first_symbol.$request->segment(1).'/'.$request->segment(2);
                }

                if(!in_array($current_url_action, $excepted_url)) {
                    return  redirect(url('/'.app()->getLocale().$login_page));
                }
            }

            return $next($request);
        });
    }
}
