<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use http\Exception\BadQueryStringException;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Request;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Data;
use Illuminate\Support\Facades\Session;

class Cabinet extends Controller {

    public function form(Request $request, $lang, $type, $id) {

        $ctype = $request->get('ctype') ? AppServiceProvider::filter_input('ctype', $request->get('ctype')) : null;
        $stage = $request->get('stage') ? AppServiceProvider::filter_input('stage', $request->get('stage')) : null;
        $form_type = $request->get('form_type') ? AppServiceProvider::filter_input('form_type', $request->get('form_type')) : null;
        if(isset($form_type) and $this->data['user']['username']==DISPATCHER) {
            $type = $form_type;
        }

        $this->data['json_info'] = [
            'stage'=>$type,
            'last_author'=>$this->data['user']['name_uz'],
            'time'=>$this->data['today_time'],
        ];

        if(isset($stage)) {
            $this->data['json_info']['stage'] = $stage;
        }

        $this->data['json_info'] = json_encode($this->data['json_info'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $content_not_needed = $request->get('content_not_needed') ? AppServiceProvider::filter_input('content_not_needed', $request->get('content_not_needed')) : null;
        if(isset($content_not_needed)) {
            $this->data['content_nod_needed'] = explode(',', $content_not_needed);
        }

        $this->data['ctype'] = $ctype;
        $status_data = AppServiceProvider::status_change($type);
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        $row = DB::table(TYPES[$type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        if(DOCUMENT!=TYPES[$type]['table']) {
           $column_names = Data::column_names(DOCUMENT);
           $columns_str = $column_names['columns_str'];
            $document = DB::table(DOCUMENT)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
        } else {
            $document = $row;
        }


        $row = (array)$row;
        $document = (array)$document;

        if(($id>0 && empty($document)) || $this->data['user']['username']!=$type) {
            if($this->data['user']['username']!=DISPATCHER || empty($ctype) || $id==0) {
                abort(404);
            }

        }

        if($request->post('data')) {
            $request_data = $request->post('data');
            var_dump($request_data);
        }

        $this->data['title'] = AppServiceProvider::get_title(['type'=>$type, 'row'=>$row]);

        $this->data['status_data'] = $status_data;

        if(in_array($type, [DISPATCHER, DIRECTOR])) {
            $get_detail_all = Data::get_detail_all($id);
            $info = $get_detail_all['info'];
            $this->data['status_data'] = array_merge($status_data, $get_detail_all['status_data']);
            $this->data['column_names'] = $get_detail_all['column_names'];

            $this->data = array_merge($this->data, $info);
        }

        $this->data['row'] = $row;
        $this->data['document'] = $document;
        $this->data['type'] = $type;
        $this->data['id'] = $id;
        $viewfile = $type;
        if(isset($ctype)) {
            $viewfile = 'content/'.$ctype;
        }
        return view('cabinet/form/'.$viewfile, $this->data);
    }

    public function list($lang, $type) {
        if($this->data['user']['username']!=$type) {
            abort(404);
        }
        $status_data = AppServiceProvider::status_change($type);
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        $rows = Data::get_join_row(['status_type'=>$type]);
        if(in_array($type, [DISPATCHER, DIRECTOR])) {
            $rows = Data::get_join_row(['status_type'=>$type]);
        }
        foreach($rows as $key => $value) {
            $rows[$key] = (array)$value;
        }

        $this->data['type'] = $type;
        $this->data['rows'] = $rows;
        $this->data['status_data'] = $status_data;
        return view('cabinet/list/'.$type, $this->data);
    }

    public function detail($lang, $type, $id) {
        die;
        $info = [];
        $page_type = $type;

        $status_data = AppServiceProvider::status_change($page_type);
        $column_names = Data::column_names(TYPES[$page_type]['table']);
        $columns_str = $column_names['columns_str'];

        $row = DB::table(TYPES[$page_type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $row = (array)$row;

        if(($id>0 && empty($row)) || $this->data['user']['username']!=$type) {
            abort(404);
        }

        if(in_array($type, [DISPATCHER, DIRECTOR])) {
            $get_detail_all = Data::get_detail_all($id);
            $info = $get_detail_all['info'];
            $this->data['status_data'] = array_merge($status_data, $get_detail_all['status_data']);
            $this->data['column_names'] = $get_detail_all['column_names'];

        }


        $this->data['title'] = AppServiceProvider::get_title(['type'=>$type, 'row'=>$row]);
        $this->data['type'] = $type;
        $this->data['id'] = $id;
        $this->data['row'] = $row;

        $this->data = array_merge($this->data, $info);

        return view('cabinet/detail/'.$type, $this->data);
    }

    public function form_save(Request $request, $lang, $type, $id) {

        $saved = false;
        $second_saved = true;
        $this->data['err_msg'] = '';
        $this->data['err_type'] = 1;
        $form_type = $request->post('form_type') ? $request->post('form_type') : null;
        if(isset($form_type) and $this->data['user']['username']==DISPATCHER) {
            $type = $form_type;
        }
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        $row = DB::table(TYPES[$type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();

        if(DOCUMENT!=TYPES[$type]['table']) {
            $is_main = false;
            $column_names = Data::column_names(DOCUMENT);
            $columns_str = $column_names['columns_str'];
            $document = DB::table(DOCUMENT)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
        } else {
            $is_main = true;
            $document = $row;
        }

        $row = (array)$row;
        $document = (array)$document;
        $row_second = null;

        $validation_rules = [];
        $columns = '';
        $bindings = '';
        $values = '';
        $binding_values = '';
        $binding_arr = [];
        $driver_id = 0;
        $one_driver_secondly_today = false;
        if ($request->post('data_second')) {
            $request_data = $request->post('data_second');
            $first_data = $request_data;
            $type_second = $request_data['type'];
            if($type_second!=DOCUMENT) {
                $is_main = false;
            } else {
                $is_main = true;
            }

            $driver_id = isset($first_data['driver_id']) ? $first_data['driver_id'] : $driver_id;
            $column_names = Data::column_names(TYPES[$type_second]['table'],['type_id'=>1, 'not_needed'=>['id', 'name_oz', 'created_time', 'updated_time', 'status']]);
            $columns_str = $column_names['columns_str'];
            $lang_val = [];
            foreach ($column_names['columns'] as $key => $value) {
                $lang_val[$key] = $value['column_name'];
                if(in_array($value['column_name'], ['name_uz'])) {
                    if($type_second==DRIVERS AND $type==TECHNICAL) {
                        $lang_val[$key] = 'driver_fio';
                    }
                }

                $validation_labels['data_second.'.$value['column_name']] = __('messages.'.$value['column_name'],['name'=>__('messages.'.$lang_val[$key])]);
            }

            foreach($first_data as $key => $value) {
                $first_data[$key] = AppServiceProvider::filter_input($key, $value);
                if(isset($validation_labels['data_second.'.$key])) {
                    $validation_rules['data_second.'.$key] = 'required';
                }
                $columns .= $key.',';
                $bindings .= '?,';
                $values .= $value.',';
                $binding_values .= ':'.$key.',';
                $binding_arr[$key] = $value;
            }
            $validator = Validator::make($request->post(), $validation_rules);
            $validator->setAttributeNames($validation_labels);
            $validated = $validator->validate();

            if($validated || empty($validation_rules)) {
                if(isset($first_data['driver_id'])) {
                    $condition = [
                        'id'=>$first_data['driver_id'],
                    ];
                    if($type==TECHNICAL and $type_second==DRIVERS) {
                            $one_driver_secondly_today = true;
                            $condition = [
                                'numserial'=>$first_data['numserial'],
                                'given_date'=>$this->data['today'],
                                'driver_id'=>$first_data['driver_id'],
                            ];
                    }
                    if($one_driver_secondly_today) {
                        $row_additional = Data::check_one_driver_secondly_today($condition);
                        if(!empty($row_additional)) {
                            foreach($row_additional as $key => $value) {
                                $row_additional[$key] = (array)$row_additional[$key];
                            }
                            if(isset($row_additional[0])) {
                                $row_additional = $row_additional[0];
                            }
                        }
                    } else {
                        $row_additional = DB::table(TYPES[$type_second]['table'])->select(DB::raw($columns_str))->where($condition)->where('status','>',0)->first();
                    }




                    unset($first_data['driver_id']);
                }
                unset($first_data['type']);


                if(empty($row_additional) && !$is_main) {
                    $first_data['id'] = Data::get_sequence(TYPES[$type_second]['sequence'])[0]->nextval;
                    $driver_id = $first_data['id'];
                    $result_row = DB::table(TYPES[$type_second]['table'])->insert($first_data);
                } elseif(!$is_main) {
                    if(!$one_driver_secondly_today) {
                        $result_row = DB::table(TYPES[$type_second]['table'])
                            ->where(['id'=>$request_data['driver_id']])->where('status','>',0)
                            ->update($first_data);
                    } else {
                        $result_row = null;
                        $this->data['err_msg'] = __('messages.this_driver_second_time_today');
                        $this->data['err_type'] = 2;
                    }

                } else {
                    $result_row = DB::table(TYPES[$type_second]['table'])
                        ->where(['id'=>$id])->where('status','>',0)
                        ->update($first_data);
                }

                if($result_row) {
                    $saved = true;
                }

            }
        }

        $saved = false;

        if($request->post('data')) {
            $request_data = $request->post('data');
            $confirm = (int)$request->post('confirm');
            $cancel = (int)$request->post('cancel');
            $page_type = $request->post('page_type');
            $first_data = $request_data;
            $driver_id = isset($first_data['driver_id']) ? $first_data['driver_id'] : $driver_id;
            $second_data = [];
            $secondly = false;
            if(isset($page_type) and $page_type!=$type) {
                $secondly = true;
                $column_names = Data::column_names(TYPES[$page_type]['table']);
                $columns_str = $column_names['columns_str'];
                $row_second = DB::table(TYPES[$page_type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
                $row_second = (array)$row_second;
                $first_data = [];
            }
            $column_names = Data::column_names(TYPES[$type]['table'],1);
            foreach ($column_names['columns'] as $key => $value) {
                $validation_labels['data.'.$value['column_name']] = __('messages.'.$value['column_name']);
            }

            $temp_data = [];

            foreach($first_data as $key => $value) {

                $first_data[$key] = AppServiceProvider::filter_input($key, $value);
                if(isset($validation_labels['data.'.$key])) {
                    $validation_rules['data.'.$key] = 'required';
                    if($key=='govnumber') {
                        $validation_rules['data.'.$key] .= '|string|max:20';
                    }
                    if($key=='diagnostic') {
                        $validation_rules['data.'.$key] .= '|string|max:150';
                    }
                    if($key=='comment') {
                        $validation_rules['data.'.$key] .= '|string|max:1000';
                    }
                }
                $columns .= $key.',';
                $bindings .= '?,';
                $values .= $value.',';
                $binding_values .= ':'.$key.',';
                $binding_arr[$key] = $value;

                if(isset($first_data['excepts_not'])) {
                    if(strpos($first_data['excepts_not'], $key)===false) {
                        $temp_data[$key] = $first_data[$key];
                    }
                }
            }

            if(!empty($temp_data) and isset($first_data['excepts_not'])) {
                $first_data = $temp_data;
            }
            unset($first_data['excepts_not']);
            if($secondly) {
                $second_data = $first_data;
            }
            $validator = Validator::make($request->post(), $validation_rules);
            $validator->setAttributeNames($validation_labels);
            $validated = $validator->validate();
            if($validated || empty($validation_rules)) {

                if($confirm>0 && $cancel==0) {
                    $first_data['status'] = $confirm;
                } elseif ($cancel>0 && $confirm==0) {
                    $first_data['status'] = $cancel;
                }
                if($secondly) {
                    $second_data = array_merge($second_data, $first_data);

                    if(isset($row['status']) and isset($first_data['status'])) {
                        $row['status'] = $first_data['status'];
                    }
                    $status_data = AppServiceProvider::status_change($type, ['row'=>$row, 'row_second'=>$row_second]);
                    $first_data['status'] = $status_data[$type];
                    $second_data['status'] = $status_data['status_second'];
                } else {
                    if(isset($row['status']) and isset($first_data['status'])) {
                        $row['status'] = $first_data['status'];
                    }
                    $status_data = AppServiceProvider::status_change($type, ['row'=>$row]);
                    $first_data['status'] = $status_data[$type];
                }
                if(in_array($type, [TECHNICAL, MEDICAL])) {
                    if(isset($row['driver_id'])) {
                        $driver_id = $row['driver_id'];
                    }
                    if($driver_id>0) {
                        if(empty($first_data['driver_id'])) {
                            $first_data['driver_id'] = $driver_id;
                        }

                    } else {
                        if($this->data['err_type']==1 or empty($this->data['err_msg'])) {
                            $this->data['err_msg'] = __('messages.driver_not_found');
                        }

                    }
                }

                if(empty($this->data['err_msg'])) {
                    if(empty($document)) {
                        $id = Data::get_sequence('document_id_seq')[0]->nextval;
                        $result_document = DB::table(DOCUMENT)->insert([
                            'id'=>$id,
                        ]);
                    } else {
                        $info_data = [
                          'status'=>$status_data['status'],
                        ];
                        if($status_data['status']==20 && $type==DIRECTOR) {
                            $guid_id = AppServiceProvider::generate_guid_id();
                            $info_data['guid_id'] = $guid_id;
                        }
                        $result_document = DB::table(DOCUMENT)
                            ->where(['id'=>$id])->where('status','>',0)
                            ->update($info_data);
                    }

                    if(empty($row)) {

                        $first_data['staff_id'] = $this->data['user']['id'];
                        $first_data['org_id'] = $this->data['user']['org_id'];
                        $first_data['id'] = Data::get_sequence(TYPES[$type]['sequence'])[0]->nextval;
                        $first_data['document_id'] = $id;
                        $result_row = DB::table(TYPES[$type]['table'])->insert($first_data);
                    } else {
                        DB::enableQueryLog();
                        $result_row = DB::table(TYPES[$type]['table'])
                            ->where(['document_id'=>$id])->where('status','>',0)
                            ->update($first_data);
                        DB::getQueryLog();
                    }
                    if(isset($row_second['id']) and $secondly) {
                        $result_second = DB::table(TYPES[$page_type]['table'])
                            ->where(['document_id'=>$id])->where('status','>',0)
                            ->update($second_data);
                        $second_saved = $result_second;
                    }

                    if(($result_document and $result_row)) {
                        $saved = true;
                    }

                    if($saved and $second_saved) {
                        Session::flash('msg', __('messages.successfully_sent'));
                        Session::flash('css_class', 'success');

                    }
                } else {

                    Session::flash('msg', $this->data['err_msg']);
                    Session::flash('css_class', 'danger');
                }

                $back_url = url()->previous();
                $back_url = strtr($back_url, [$type.'/0'=>$type.'/'.$id]);

                return redirect($back_url);



            }
        }

    }

}
