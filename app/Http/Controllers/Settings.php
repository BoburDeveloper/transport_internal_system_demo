<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use http\Exception\BadQueryStringException;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Request;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Data;
use Illuminate\Support\Facades\Session;

class Settings extends Cabinet {

    public function routes($lang) {
        
        $this->data['flights'] =  Data::flights(['not_needed'=>999]);

        return view('settings/routes', $this->data);
    }

    public function route($lang, $id) {
        
        $this->data['type']=FLIGHTS;
        $this->data['id']=$id;
        $this->data['row'] = Data::flights(['id'=>$id]);
        $this->data['title'] = __('messages.routes').': '.$this->data['row']['name_uz'];
        return view('settings/route', $this->data);
    }

}
