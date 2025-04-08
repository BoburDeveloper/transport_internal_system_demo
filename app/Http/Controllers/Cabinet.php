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

class Cabinet extends Controller {

    public function form(Request $request, $lang, $type, $id) {

        $ctype = $request->get('ctype') ? AppServiceProvider::filter_input('ctype', $request->get('ctype')) : null;
        $stage = $request->get('stage') ? AppServiceProvider::filter_input('stage', $request->get('stage')) : null;
        $change = $request->get('change') ? AppServiceProvider::filter_input('change', $request->get('change')) : null;
        $form_type = $request->get('form_type') ? AppServiceProvider::filter_input('form_type', $request->get('form_type')) : null;
        $trip_id_get = $request->get('trip_id') ? $request->get('trip_id') : null;
        if(isset($form_type) and $this->data['user']['role_name']==DISPATCHER) {
            $type = $form_type;
        }

        $this->data['stage'] = $stage;
        $this->data['change'] = $change;


        $content_not_needed = $request->get('content_not_needed') ? AppServiceProvider::filter_input('content_not_needed', $request->get('content_not_needed')) : null;
        if(isset($content_not_needed)) {
            $this->data['content_nod_needed'] = explode(',', $content_not_needed);
        }

        $this->data['ctype'] = $ctype;
        $status_data = AppServiceProvider::status_change($type);
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        $this->data['column_names'] = $column_names;
        $row = DB::table(TYPES[$type]['table'])->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        if(DOCUMENT!=TYPES[$type]['table']) {
           $column_names = Data::column_names(DOCUMENT);
           $columns_str = $column_names['columns_str'];
            $document = DB::table(DOCUMENT)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
        } else {
            $document = $row;
        }


        if(isset($row)) {
            $row = (array)$row;
        }
        if(isset($document)) {
            $document = (array)$document;
        }
        if(isset($document['table_flight_id'])) {
            $trip_id_get = $document['table_flight_id'];
        }
        $this->data['trip_id_get'] = $trip_id_get;
        if(($id>0 && empty($document)) || $this->data['user']['role_name']!=$type) {
            if($this->data['user']['role_name']!=DISPATCHER || empty($ctype) || $id==0) {
                abort(404);
            }

        }
        
        $today_date = date('Y-m-d', strtotime($this->data['today']));

        $this->data['title'] = AppServiceProvider::get_title(['type'=>$type, 'row'=>$row]);

        $this->data['status_data'] = $status_data;
        $this->data['type'] = $type;
        $this->data['id'] = $id;
        $this->data['today_date'] = $today_date;

        if(in_array($type, [DISPATCHER, DIRECTOR, TECHNICAL])) {

            if($type==TECHNICAL and (empty($trip_id_get) or !is_numeric($trip_id_get)) and empty($document)) {
                abort(404);
            }
            $get_detail_all = Data::get_detail_all($id);
            $info = $get_detail_all['info'];
            if(in_array($type, [DISPATCHER, DIRECTOR])) {
            $this->data['status_data'] = array_merge($status_data, $get_detail_all['status_data']);
            }

            $this->data['column_names'] = $get_detail_all['column_names'];

            $this->data = array_merge($this->data, $info);
            if(!empty($this->data['technical'])) {
                $ids_columns_three = AppServiceProvider::ids_columns_three(['technical'=>$this->data['technical']]);
                extract($ids_columns_three); 
            }



            if(isset($this->data['dispatcher']['given_date']) and $type==DISPATCHER) {
                $today_date = $this->data['dispatcher']['given_date'];
            } elseif(isset($this->data['technical']['given_date']) and $type==TECHNICAL) {
                $today_date = $this->data['technical']['given_date'];
            }

            $this->data['row'] = $row;
            $this->data['document'] = $document;
            $this->data['today_date'] = $today_date;

            $params_current_flights_data = [
                'data'=>$this->data,
            ];

            if(isset($ids_columns_three)) {
                $params_current_flights_data = array_merge($params_current_flights_data, $ids_columns_three);
            }

            $params_current_flights_data = array_merge($params_current_flights_data, $this->data);

            $current_flights_data = $this->current_flights_data($params_current_flights_data);
            extract($current_flights_data);
            $this->data = array_merge($this->data, $current_flights_data);
            if(isset($this->data['flights_from_api'])) {
                $this->data['current_flight'] = AppServiceProvider::searchForId($trip_id_get, 'trip_id', $this->data['flights_from_api']['data']);
            }

            if($type==DIRECTOR and !file_exists($this->data['basepath_boarded_passengers'])) {
                $this->data['err_msg'] = 'Passengers not found!';
            }
        }


        $viewfile = $type;
        if(isset($ctype)) {
            $viewfile = 'content/'.$ctype;
        }

        return view('cabinet/form/'.$viewfile, $this->data);
    }

    public function list(Request $request, $lang, $type) {
        if($this->data['user']['role_name']!=$type) {
            abort(404);
        }

        $trip_id_get = null;
        $filter = $request->get('filter');
        if($filter and is_array($filter)) {
            foreach($filter as $key => $value) {
                $filter[$key] = AppServiceProvider::filter_input($key, $value);
            }
        }
        $this->data['filter'] = $filter;
        $status_data = AppServiceProvider::status_change($type);
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        $params_rows = [
            'status_type'=>$type
            ];
        if(!empty($filter)) {
            $params_rows['filter'] = $filter;
        }    
        $rows = Data::get_join_row($params_rows);
        if(in_array($type, [DISPATCHER, DIRECTOR])) {
            $rows = Data::get_join_row($params_rows);
        }
        foreach($rows as $key => $value) {
            $rows[$key] = (array)$value;
        }
        $this->data['type'] = $type;
        $this->data['rows'] = $rows;
        $this->data['status_data'] = $status_data;
        if($type==TECHNICAL) {
        
            $today_date = date('Y-m-d', strtotime($this->data['today']));
            if(isset($this->data['dispatcher']['given_date'])) {
                $today_date = $this->data['dispatcher']['given_date'];
            }

            $this->data['type'] = $type;
            $this->data['today_date'] = $today_date;
            $this->data['trip_id_get'] = $trip_id_get;

            $params_current_flights_data = [
                'data'=>$this->data,
            ];
            $params_current_flights_data = array_merge($params_current_flights_data, $this->data);

            $current_flights_data = $this->current_flights_data($params_current_flights_data);
            extract($current_flights_data);
            $this->data = array_merge($this->data, $current_flights_data);

            foreach($this->data['rows'] as $key =>$value) {
                foreach($this->data['flights_from_api']['data'] as $key_second=>$value_second) {
                    if($value['table_flight_id']==$value_second['trip_id']) {
                        unset($this->data['flights_from_api']['data'][$key_second]);
                    }
                }
            }
            $this->data['count_flights_from_api'] = count($this->data['flights_from_api']['data']);

        }


        return view('cabinet/list/'.$type, $this->data);
    }

    public function form_save(Request $request, $lang, $type, $id) {

        $today_date = date('Y-m-d', strtotime($this->data['today']));
        $trip_id_get = $request->get('trip_id') ? $request->get('trip_id') : null;
        $saved = false;
        $second_saved = true;
        $document_secondly_coming = false;
        $is_agree = false;
        $this->data['err_msg'] = '';
        $this->data['err_type'] = 1;
        $this->data['json_info']['stage'] = $type;
        $form_type = $request->post('form_type') ? $request->post('form_type') : null;
        $stage = $request->post('stage') ? $request->post('stage') : null;
        $change = $request->post('change') ? $request->post('change') : null;
        $row_id = $request->post('row_id');
        if(isset($form_type) and $form_type != SETTINGS and $this->data['user']['role_name']==DISPATCHER) {
            $type = $form_type;
        }
        $column_names = Data::column_names(TYPES[$type]['table']);
        $columns_str = $column_names['columns_str'];
        if(isset($row_id)) {
            $condition_row = ['id'=>$row_id];
            if($form_type != SETTINGS) {
                $condition_row['document_id'] = $id;
            }
            $row = DB::table(TYPES[$type]['table'])->select(DB::raw($columns_str))->where($condition_row)->where('status','>',0)->first();
        } else {
            $condition_row = ['document_id'=>$id];
            $row = DB::table(TYPES[$type]['table'])->select(DB::raw($columns_str))->where($condition_row)->where('status','>',0)->first();
        }


        if(DOCUMENT==$type) {
            $is_main = true;
            $document = $row;
        } else {
            $is_main = false;
            $column_names = Data::column_names(DOCUMENT);
            $columns_str = $column_names['columns_str'];
            $document = DB::table(DOCUMENT)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
        }

        if(isset($row)) {
            $row = (array)$row;
        }
        if(isset($document)) {
            $document = (array)$document;
        }

        $row_second = null;

        $validation_rules = [];
        $validation_labels = [];
        $columns = '';
        $bindings = '';
        $values = '';
        $binding_values = '';
        $binding_arr = [];
        $driver_id = 0;
        $one_driver_secondly_today = false;

        $params_post = [
            'type'=>$type,
            'all_post_data'=>$request->post(),
            'is_main'=>$is_main,
            'driver_id'=>$driver_id,
            'id'=>$id,
            'one_driver_secondly_today'=>$one_driver_secondly_today,
            'saved'=>$saved,
            'data'=>$this->data,
            'row_second'=>$row_second,
            'validation_rules'=>$validation_rules,
            'validation_labels'=>$validation_labels,
            'columns'=>$columns,
            'bindings'=>$bindings,
            'values'=>$values,
            'binding_values'=>$binding_values,
            'binding_arr'=>$binding_arr,
            'row'=>$row,
            'document'=>$document,
            'stage'=>$stage,
            'change'=>$change,
        ];

        $post_name = POST_NAMES['data_second'];
        if($request->post($post_name)) {

            $params_post['post_name'] = $post_name;
            $post_data = $request->post($post_name);
            $params_post['post_data'] = $post_data;
            if($params_post['post_data']['type']==DOCUMENT) {
                $document_secondly_coming = true;
            }
            $params_post['document_secondly_coming'] = $document_secondly_coming;
            $second_post_data = $this->second_post_data($params_post);
            $this->data[$post_name] = $second_post_data;
            extract($second_post_data);
            $this->data = array_merge($this->data, $second_post_data['data']);
        }

        $post_name = POST_NAMES['data_multiple'];
        $driver_ids_all = [];
        if($request->post($post_name)) {
            $params_post['post_data'] = [];
            $params_post['post_name'] = $post_name;
            $post_data = $request->post($post_name);
            foreach($post_data as $key => $value) {

                if(empty($value['numserial'])) {
                    unset($post_data[$key]);
                }
            }

            foreach($post_data as $key => $value) {

                    $params_post['post_data'] = $post_data[$key];
                    $second_post_data = $this->second_post_data($params_post);
                    $this->data[$post_name] = $second_post_data;
                    extract($second_post_data);
                    $this->data = array_merge($this->data, $second_post_data['data']);
                    if(isset($second_post_data['driver_id'])) {
                        $driver_ids_all[$key] = $second_post_data['driver_id'];
                    }
            }

        }

        $driver_ids_str = implode(',', $driver_ids_all);

        $post_name = POST_NAMES['data'];
        if($request->post($post_name)) {
            $request_data = $request->post('data');
            $confirm = (int)$request->post('confirm');
            $cancel = (int)$request->post('cancel');
            $page_type = $request->post('page_type');
            $post_status = $request->post('status');
            $all_post = [
                $post_name => $request_data
            ];

            $stage_arr = [];
            if(isset($change) and isset($stage)) {
                $stage_arr[$post_name]['change'] = $change;
                $stage_arr[$post_name]['stage'] = $type.'; '.$stage;
            } else {
                $stage_arr[$post_name]['stage'] = $type;
                $stage_arr[$post_name]['change'] = 'whole_form';
            }

            $params_combine_data = [
                'info_data'=>$all_post,
                'json_info'=>$this->data['json_info'],
                'post_name'=>$post_name,
                'stage'=>$stage_arr,
            ];

            $combine_data = AppServiceProvider::combine_data($params_combine_data);


            $all_post = $combine_data['info_data'];
            $request_data = $all_post[$post_name];
            $first_data = $request_data;

            $driver_id = isset($driver_ids_str) ? $driver_ids_str : $driver_id;
            if(isset($first_data['driver_id'])) {
                $driver_id = $first_data['driver_id'];
            }
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
                $column_name = $value['column_name'];
                    if(in_array($column_name, ['table_flight_id'])) {
                        $lang_val[$key] = 'flight_id';
                    }

                $validation_labels['data.'.$column_name] = __('messages.'.$column_name);
            }

            $temp_data = [];
            foreach($first_data as $key => $value) {

                $first_data[$key] = AppServiceProvider::filter_input($key, $value);
                if(isset($validation_labels['data.'.$key]) and !in_array($key, TYPES[$type]['optional_columns'])) {
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

            $validator = Validator::make($all_post, $validation_rules);
            $validator->setAttributeNames($validation_labels);
            $validated = $validator->validate();

            if($validated || empty($validation_rules)) {
                $status_came = false;
                if($confirm>0 && $cancel==0) {
                    $status_came = true;
                    $is_agree = true;
                    $first_data['status'] = $confirm;

                } elseif ($cancel>0 && $confirm==0) {
                    $status_came = true;
                    $is_agree = false;
                    $first_data['status'] = $cancel;
                }
                if($secondly) {
                    $second_data = array_merge($second_data, $first_data);

                    if(isset($row['status']) and isset($first_data['status'])) {
                        if($type==DISPATCHER) {
                            $row_second['status'] = $first_data['status'];
                            if(empty($row['status'])) {
                                $row['status'] = 1;
                            }
                        }  else {
                            $row['status'] = $first_data['status'];
                        }

                        $status_rows = [
                            'row_second'=>$row_second,
                            'row'=>$row,
                        ];
                    } else {
                        if($type==DISPATCHER) {
                            $row_second['status'] = $first_data['status'];
                            if(empty($row['status'])) {
                            }
                        }

                        $status_rows = [
                          'row_second'=>$row_second,
                          'row'=>$first_data,
                        ];
                    }

                    $status_data = AppServiceProvider::status_change($type, $status_rows);

                    $first_data['status'] = $status_data[$type];
                    if(!$status_came) {
                        $second_data['status'] = $post_status[$page_type];
                    }

                } else {
                    if(isset($row['status']) and isset($first_data['status'])) {
                        $row['status'] = $first_data['status'];
                    }

                    $status_data = AppServiceProvider::status_change($type, ['confirm'=>$confirm, 'row'=>$row]);
                    if(!$status_came) {
                        $first_data['status'] = $status_data[$type];

                        if(isset($post_status[$type])) {
                            $first_data['status'] = $post_status[$type];
                        }
                    }

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
                        $info_data = [
                            'id'=>$id,
                        ];

                        if($document_secondly_coming and isset($this->data[POST_NAMES['data_second']][DOCUMENT.'_data'])) {
                            $second_info_data = $this->data[POST_NAMES['data_second']][DOCUMENT.'_data'];
                            $info_data = array_merge($info_data, $second_info_data);
                        }
                        $result_document = DB::table(DOCUMENT)->insert($info_data);
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
                            ->where($condition_row)->where('status','>',0)
                            ->update($first_data);
                        DB::getQueryLog();
                    }

                    if($result_row and $type==TECHNICAL and $is_agree) {
                            if(!empty($first_data)) {
                                $ids_columns_three = AppServiceProvider::ids_columns_three(['technical'=>$first_data]);
                                extract($ids_columns_three); 
                            }

                            if(isset($first_data['given_date']) and $type==TECHNICAL) {
                                $today_date = $first_data['given_date'];
                            }

                            $this->data['row'] = $first_data;
                            $this->data['document'] = $info_data;
                            $this->data['today_date'] = $today_date;
                            $this->data['id']=$id;
                            $this->data['trip_id_get']=$trip_id_get;

                            $params_current_flights_data = [
                                'data'=>$this->data,
                                'id'=>$id,
                                'type'=>$type,
                                'trip_id_get'=>$trip_id_get,
                            ];

                            if(isset($ids_columns_three)) {
                                $params_current_flights_data = array_merge($params_current_flights_data, $ids_columns_three);
                            }

                            $params_current_flights_data = array_merge($params_current_flights_data, $this->data);

                            $current_flights_data = $this->current_flights_data($params_current_flights_data);
                            extract($current_flights_data);
                            $this->data = array_merge($this->data, $current_flights_data);
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

    private  function second_post_data($params) {
        extract($params);
//        $all_post = $all_post_data;

            $all_post = [
              $post_name=>$post_data,
            ];

            $result_row = null;
            
            $duplicate_column = [];
            if(isset($all_post_data['data_multiple'])) {

                $check_column = 'numserial';
                $duplicate_column[$check_column] = 0;
                foreach($all_post_data['data_multiple'] as $key => $value) {
                    foreach($all_post_data['data_multiple'] as $key_second => $value_second) {
                        if(isset($value[$check_column]) and $value[$check_column]==$value_second[$check_column]) {
                            if($key != $key_second) {
                                $duplicate_column[$check_column]++;
                            }
                        }
                    }
                }

                if($duplicate_column[$check_column]>1) {
                    $this->data['err_msg'] = __('messages.in_form_only_one_unique_driver');
                }
            }

            $validation_labels = [];
            $stage_arr = [];

            if(isset($change) and isset($stage)) {
                $stage_arr[$post_name]['change'] = $change;
                $stage_arr[$post_name]['stage'] = $type.'; '.$stage;
            } else {
                $stage_arr[$post_name]['stage'] = $type;
                $stage_arr[$post_name]['change'] = 'whole_form';
            }
        $params_combine_data = [
            'info_data'=>$all_post,
            'json_info'=>$this->data['json_info'],
            'post_name'=>$post_name,
            'stage'=>$stage_arr,
        ];

        $combine_data = AppServiceProvider::combine_data($params_combine_data);
        $all_post = $combine_data['info_data'];
        $post_data = $all_post[$post_name];
        $end_data = [

        ];

        if ($post_data) {

            $request_data = $post_data;

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
                $column_name = $value['column_name'];
                $lang_val[$key] = $column_name;
                if(in_array($column_name, ['name_uz'])) {
                    if($type_second==DRIVERS AND $type==TECHNICAL) {
                        $lang_val[$key] = 'driver_fio';
                    }
                } elseif(in_array($column_name, ['table_flight_id'])) {
                        $lang_val[$key] = 'flight_id';
                }


                $validation_labels[$post_name.'.'.$column_name] = __('messages.'.$column_name,['name'=>__('messages.'.$lang_val[$key])]);
            }
            foreach($first_data as $key => $value) {
                $first_data[$key] = AppServiceProvider::filter_input($key, $value);
                if(isset($validation_labels[$post_name.'.'.$key]) and !in_array($key, TYPES[$type]['optional_columns'])) {
                    $validation_rules[$post_name.'.'.$key] = 'required';
                }
                $columns .= $key.',';
                $bindings .= '?,';
                $values .= $value.',';
                $binding_values .= ':'.$key.',';
                $binding_arr[$key] = $value;
            }


            $validator = Validator::make($all_post, $validation_rules);
            $validator->setAttributeNames($validation_labels);
            $validated = $validator->validate();

            if($validated || empty($validation_rules)) {
                if(isset($first_data['driver_id'])) {
                    $condition = [
                        'id'=>$first_data['driver_id'],
                    ];
                    if($type==TECHNICAL and $type_second==DRIVERS and $id==0) {
                        $one_driver_secondly_today = true;
                        $given_date_label = 'given_date';
                        $condition = [
                            'numserial'=>$first_data['numserial'],
                            $given_date_label=>AppServiceProvider::filter_input($given_date_label, $this->data['today']),
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
                        if(!empty($condition['id'])) {
                                $row_additional = (array)DB::table(TYPES[$type_second]['table'])->select(DB::raw($columns_str))->where($condition)->where('status','>',0)->first();
                        }

                    }
                    $end_data['row_additional'] = $row_additional;


                    unset($first_data['driver_id']);

                } else {
                    $row_additional = $first_data;

                }

                unset($first_data['type']);

                if(empty($this->data['err_msg'])) {
                    if(empty($row_additional) and !$is_main) {
                        $first_data['id'] = Data::get_sequence(TYPES[$type_second]['sequence'])[0]->nextval;
                        $driver_id = $first_data['id'];
                        $result_row = DB::table(TYPES[$type_second]['table'])->insert($first_data);
                    } elseif(!$is_main) {
                        if(!$one_driver_secondly_today) {
                                $result_row = DB::table(TYPES[$type_second]['table'])
                                    ->where(['id'=>$row_additional['id']])->where('status','>',0)
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
                }

                $end_data['result_row'] = $result_row;
                $end_data['one_driver_secondly_today'] = $one_driver_secondly_today;
                $end_data['driver_id'] = $driver_id;
                $end_data['data'] = $this->data;
                $end_data[$type_second.'_data'] = $first_data;

                if($result_row) {
                    $saved = true;
                }
                $end_data['saved'] = $saved;
            }
        }
        return $end_data;
    }

    
    private function current_flights_data($params) {
            extract($params);
            $this->data = $params['data'];
            $is_owner = ($type==DISPATCHER or $type==TECHNICAL) ? true : false;

            if(isset($this->data['document']['table_flight_id']) and empty($this->data['trip_id_get'])) {
                $this->data['trip_id_get'] = $this->data['document']['table_flight_id'];
            }

            $end_data = [];
            $end_data['flights_basepath'] = AppServiceProvider::base_api_path().'/flights_from_api/flights_from_api-'.STATUS_ACTIVE.'-'.$today_date.'.txt';
            $end_data['all_flights_basepath'] = AppServiceProvider::base_api_path().'/flights_from_api/flights_from_api.txt';
            $end_data['basepath_boarded_passengers'] = AppServiceProvider::base_api_path().'/boarded_passengers_from_api/boarded_passengers_from_api-'.$this->data['trip_id_get'].'.txt';

            if(
                !empty($document['table_flight_id']) and (
                    ($is_owner and isset($row['status']) and $row['status'] == STATUS_CONFIRMED)
                      or $type==DIRECTOR )
            )  {
                $end_data['basepath_boarded_passengers'] = AppServiceProvider::base_api_path().'/boarded_passengers_from_api/boarded_passengers_from_api-'.$document['table_flight_id'].'.txt';
            }

            $end_data['token'] = AppServiceProvider::get_auth_token_api();

            if($is_owner and isset($row['status']) and $row['status']<STATUS_CONFIRMED) {


                if(file_exists($end_data['flights_basepath']) and file_exists($end_data['all_flights_basepath']) ) {
                    $end_data['flights_from_api'] = json_decode(file_get_contents($end_data['flights_basepath']), true);
                    $end_data['all_flights_from_api'] = json_decode(file_get_contents($end_data['all_flights_basepath']), true);
                } else {

                    $end_data['send_data'] = AUTH;

                    $end_data['params_api_first'] = ['send_data'=>$end_data['send_data']];
                    $end_data['token'] = AppServiceProvider::get_auth_token_api($end_data['params_api_first']);


                    $end_data['today'] = date('Y-m-d', strtotime($this->data['today']));
                    $end_data['status'] = STATUS_ACTIVE;

                    $end_data['params_api_second'] = [
                        'send_data'=>['date'=>$end_data['today'], 'status'=>$end_data['status']],
                        'token'=>$end_data['token'],
                    ];
                    $end_data['flights_from_api'] = AppServiceProvider::flights_from_api($end_data['params_api_second']);
                    $end_data['all_flights_from_api'] = AppServiceProvider::flights_from_api(['token'=>$end_data['token'],'send_data'=>null]);

                }

            } else {
                if(file_exists($end_data['flights_basepath']) and file_exists($end_data['all_flights_basepath']) ) {
                    $end_data['flights_from_api'] = json_decode(file_get_contents($end_data['flights_basepath']), true);
                    $end_data['all_flights_from_api'] = json_decode(file_get_contents($end_data['all_flights_basepath']), true);
                } else {
                    $end_data['send_data'] = AUTH;

                    $end_data['params_api_first'] = ['send_data'=>$end_data['send_data']];
                    $end_data['token'] = AppServiceProvider::get_auth_token_api($end_data['params_api_first']);


                    $end_data['today'] = date('Y-m-d', strtotime($this->data['today']));
                    $end_data['status'] = STATUS_ACTIVE;

                    $end_data['params_api_second'] = [
                        'send_data'=>['date'=>$end_data['today'], 'status'=>$end_data['status']],
                        'token'=>$end_data['token'],
                    ];
                    $end_data['flights_from_api'] = AppServiceProvider::flights_from_api($end_data['params_api_second']);
                    $end_data['all_flights_from_api'] = AppServiceProvider::flights_from_api(['token'=>$end_data['token'],'send_data'=>null]);
                }

            }

            if(isset($end_data['flights_from_api']['array'])) {
                $end_data['flights_from_api'] = $end_data['flights_from_api']['array'];
            }

            if(isset($end_data['flights_from_api']['message']) and $end_data['flights_from_api']['message']=='Unauthenticated.') {
                    $get_token = true;
                    $end_data['params_api_first']['get_token'] = $get_token;
                    $end_data['token'] = AppServiceProvider::get_auth_token_api($end_data['params_api_first']);
                    $end_data['flights_from_api'] = AppServiceProvider::flights_from_api($end_data['params_api_second']);
                    $end_data['all_flights_from_api'] = AppServiceProvider::flights_from_api(['token'=>$end_data['token'],'send_data'=>null]);
            }

                if(isset($end_data['flights_from_api']['data']) and isset($this->data['technical']['vehicle_id'])) {


                    if(isset($bus_id_column) and isset($transporter_id_column)) {
                        $column_types_arr = [];
                        $column_types_arr[$bus_id_column] = array_column($end_data['flights_from_api']['data'], $bus_id_column);
                        $column_types_arr[$transporter_id_column] = array_column($end_data['flights_from_api']['data'], $transporter_id_column);
                    }



                    if(isset($end_data['flights_from_api']['data']) and isset($id)) {
                        $end_data['params_slice_data'] = [
                            'flights_from_api'=>$end_data['flights_from_api'],
                            'id'=>$id,
                        ];

                        if(isset($this->data['trip_id_get'])) {
                            $end_data['params_slice_data']['trip_id'] = $this->data['trip_id_get'];
                            $end_data['slice_current_data'] = AppServiceProvider::slice_current_data($end_data['params_slice_data']);
                        } else {
                            $end_data['params_slice_data']['ids'] = $ids;
                            $end_data['params_slice_data']['columns_param'] = $columns_param;

                            $end_data['slice_current_data'] = AppServiceProvider::slice_current_data($end_data['params_slice_data']);

                        }

                        $end_data['current_flight'] = $end_data['slice_current_data'];
                    }

                    if(isset($end_data['current_flight']['trip_id'])) {
                        $current_flight_trip_id = $end_data['current_flight']['trip_id'];
                    } else {
                        $current_flight_trip_id = $this->data['trip_id_get'];
                    }

                    if(isset($end_data['current_flight']['trip_id']) and $is_owner) {
                            $end_data['params_result_row'] = [
                                'table_flight_id'=>$end_data['current_flight']['trip_id'],
                                'sold_seats_count'=>$end_data['current_flight']['sold_seats_count'],
                                'seats_count'=>$end_data['current_flight']['seats_count'],
                            ];
                            $end_data['result_row'] = Db::table(DOCUMENT)->where(['id'=>$id])->update($end_data['params_result_row']);
                    }

                    if(file_exists($end_data['basepath_boarded_passengers'])) {

                        if($type==DIRECTOR and $this->data['document']['status']<STATUS_CONFIRMED) {
                                    $end_data['params_api_third'] = [
                                        'trip_id'=>$current_flight_trip_id,
                                        'document_id'=>$id,
                                        'token'=>$end_data['token'],
                                    ];
                                $end_data['current_boarded_passengers'] = AppServiceProvider::boarded_passengers_from_api($end_data['params_api_third']);
                        } else {
                            $end_data['current_boarded_passengers'] = file_get_contents($end_data['basepath_boarded_passengers']);
                            $end_data['current_boarded_passengers'] = json_decode($end_data['current_boarded_passengers'], true);
                        }

                    } else {
                        if(isset($current_flight_trip_id) and ($is_owner or $type==DIRECTOR)) {

                            $end_data['params_api_third'] = [
                                'trip_id'=>$current_flight_trip_id,
                                'document_id'=>$id,
                                'token'=>$end_data['token'],
                                'result_row'=>isset($end_data['result_row']) ? $end_data['result_row'] : $this->data['document']['table_flight_id'],
                            ];

                            $end_data['current_boarded_passengers'] = AppServiceProvider::boarded_passengers_from_api($end_data['params_api_third']);

                        }
                    
                }
                
            }

            if(file_exists($end_data['basepath_boarded_passengers'])) {
                    $end_data['current_boarded_passengers'] = file_get_contents($end_data['basepath_boarded_passengers']);
                    $end_data['current_boarded_passengers'] = json_decode($end_data['current_boarded_passengers'], true);
            }

        return $end_data;
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

        if(($id>0 && empty($row)) || $this->data['user']['role_name']!=$type) {
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

}
