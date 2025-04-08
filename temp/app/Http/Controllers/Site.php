<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\SystemQRCode;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;

class Site extends Controller {

    public function index($lang=null) {
       return view('site/index', $this->data);
    }

    public function login(Request $request, $lang) {
        $validation_rules = [];
        $columns = '';
        $bindings = '';
        $values = '';
        $binding_values = '';
        $binding_arr = [];
        $this->data['err_msg'] = '';
        if($request->post('signin')) {
            $request_data = $request->post('signin');
            $validation_rules = [
              'signin.username'=>'required',
              'signin.password'=>'required',
              'captcha'=>'required|captcha',
            ];
            $validator = Validator::make($request->all(), $validation_rules);
            if($validator->validate()) {
                $column_names = Data::column_names(USERS,['type_id'=>1, 'not_needed'=>['id', 'name_oz', 'created_time', 'updated_time', 'status']]);
                $columns_str = $column_names['columns_str'];
                $user = DB::table('users')->select(DB::raw($columns_str))->where(['username'=>$request_data['username'], 'password'=>$request_data['password']])->where('status', '>', 0)->first();
                $user = (array)$user;
                if(isset($user['id'])) {

                    Session::put('user', $user);
                    return redirect(url('/'.app()->getLocale()));
                } else {
                    $this->data['err_msg'] = __('messages.user_not_found');

                    Session::flash('msg', $this->data['err_msg']);
                    Session::flash('css_class', 'danger');
                }
            }
        }
        return view('site/login', $this->data);
    }

    public function logout() {
        Session::remove('user');
        return redirect(url('/'.app()->getLocale().'/site/login'));
    }


    public function document($lang, $type, $id=null) {
        $page_type = $type;
        if($type==DOCUMENT) {
            $page_type = DIRECTOR;
        }

        $info = [];
        if(empty($id)) {
            $id = $type;
            $type = $lang;
            $page_type = $type;
            if($type==DOCUMENT) {
                $page_type = DIRECTOR;
            }
        }

        $column = is_numeric($id) ? 'id' : 'guid_id';

        $status_data = AppServiceProvider::status_change($page_type);

        $column_names = Data::column_names(TYPES[DOCUMENT]['table']);
        $columns_str = $column_names['columns_str'];
        $document = DB::table(DOCUMENT)->select(DB::raw($columns_str))->where([$column=>$id])->where('status','>',0)->first();
        $document = (array)$document;

        if(isset($document['id'])) {
            $id = $document['id'];

            $column_names = Data::column_names(TYPES[$page_type]['table']);
            $columns_str = $column_names['columns_str'];

            $row = DB::table(TYPES[$page_type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
            $row = (array)$row;
        }

        if(($id>0 && empty($document)) or (isset($document['status']) && $document['status']==$status_data['cancel_status_second'])) {
            abort(404);
        }

        $get_detail_all = Data::get_detail_all($id);
        $info = $get_detail_all['info'];
        $this->data['status_data'] = array_merge($status_data, $get_detail_all['status_data']);
        $this->data['column_names'] = $get_detail_all['column_names'];



        $this->data['title'] = AppServiceProvider::get_title(['type'=>$type, 'row'=>$row]);
        $this->data['type'] = $type;
        $this->data['id'] = $id;
        $this->data['row'] = $row;
        $this->data['document'] = $document;

        $this->data = array_merge($this->data, $info);


        return view('cabinet/document/'.$type, $this->data);
    }

}
