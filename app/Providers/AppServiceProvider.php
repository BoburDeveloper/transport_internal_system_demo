<?php

namespace App\Providers;

use App\Models\Data;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function __construct($app)
    {
        parent::__construct($app);

    }

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::share('time', time());
        View::share('asset_theme', '/AdminLTE/');
    }

    public static function filter_input($name, $input) {
        if(is_array($input)) {
            $input_as_arr = implode(',', $input);
            $input = $input_as_arr;
        } elseif ($name=='json_info') {
            $input = trim(strip_tags($input));
        } else {
            $input = trim(strip_tags($input));
        }

        if(strpos($name, 'date')!==false or strpos($name, 'time')!==false) {
            $input = date('Y-m-d H:i:s', strtotime($input));
        }
        return $input;
    }

    public static function status_change($step, $params=null) {
        $row_status = isset($params['row']['status']) ? $params['row']['status'] : null;
        $row_second_status = isset($params['row_second']['status']) ? $params['row_second']['status'] : null;
        $confirm = isset($params['confirm']) ? $params['confirm'] : null;
        $new = 1;
        $status = $new;
        $status_second = 1;
        $status_third = 1;
        $step_status = 1;

        $send_true = 10;
        $send_false = 9;
        $cancel_status_second = $send_false;

        $cancelled = 5;
        $first_cancelled = 11;
        $second_cancelled = 12;
        $process_confirmed = 18;
        $preview = 19;
        $confirmed = 20;
        if($step==TECHNICAL) {

            $status_second = isset($row_second_status) ? $row_second_status : $send_true;
            if(isset($row_status)) {
                $status_second = $row_status;
            }
            $step_status = $status_second;
        } elseif ($step==MEDICAL) {
            $status_second = isset($row_second_status) ? $row_second_status : $send_true;
            if(isset($row_status)) {
                $status_second = $row_status;
            }
            $step_status = $status_second;
        } elseif ($step==DISPATCHER) {
            $status_second = $row_second_status;
            $cancel_status_second = $cancelled;
            if (in_array($row_second_status, [$confirmed, $process_confirmed, $send_true]) && $row_status<$process_confirmed) {
                $status_third = $process_confirmed;
            } elseif (in_array($row_second_status, [$confirmed, $process_confirmed, $send_true])
                                && $row_status==$process_confirmed) {
                $status_third = $preview;
            } elseif (in_array($row_second_status, [$cancelled, $send_false]) && $row_status<$first_cancelled) {
                $status_third = $first_cancelled;
            } elseif (in_array($row_second_status, [$cancelled, $send_false]) && $row_status==$first_cancelled) {
                $status_third = $second_cancelled;
            } elseif (empty($row_second_status) && in_array($row_status, [19,20])) {
              $status_third = $row_status;
            }
            $step_status = $status_third;
        } elseif ($step==DIRECTOR) {
            $status = 20;
            $status_second = $row_second_status;
            $status_third = $status;
            if(isset($row_status) && in_array($row_status, [9,20])) {
                $status = $row_status;
            }
            $step_status = $status;
        }

        $colors = [
            $step=>[
                'status'=>$step_status,
                $status_second=>[
                    'color'=>'blueb',
                ],
                $cancel_status_second=>[
                    'color'=>'orangeb',
                ],
                $cancelled=>[
                    'color'=>'redb',
                ],
                $confirmed=>[
                    'color'=>'greenb',
                ],
                $preview=>[
                    'color'=>'greenb',
                ],
                $process_confirmed=>[
                    'color'=>'blueb',
                ],
                $first_cancelled=>[
                    'color'=>'orangeb',
                ],
                $second_cancelled=>[
                    'color'=>'redb',
                ],
                $new=>[
                    'color'=>'blueb'
                ],
        ],

        ];
        return [
            'status_second'=>$status_second,
            'cancel_status_second'=>$cancel_status_second,
            'status'=>$status,
            'status_third'=>$status_third,
            'confirmed'=>$confirmed,
            'cancelled'=>$cancelled,
            'preview'=>$preview,
            $status_second=>[
              'color'=>'blueb',
            ],
            $cancel_status_second=>[
                'color'=>'orangeb',
            ],
            $cancelled=>[
                'color'=>'redb',
            ],
            $confirmed=>[
                'color'=>'greenb',
            ],
            $preview=>[
                'color'=>'greenb',
            ],
            $process_confirmed=>[
                'color'=>'blueb',
            ],
            $first_cancelled=>[
                'color'=>'orangeb',
            ],
            $second_cancelled=>[
                'color'=>'redb',
            ],
            $new=>[
              'color'=>'blueb'
            ],
            $send_true => [
                'color'=>'blueb',
            ],

            $send_false => [
                'color'=>in_array($step, [DIRECTOR, DISPATCHER]) ? 'redb' : 'before-redb',
            ],
            $step=>$step_status,
        ];
    }

    public static function get_title($params) {
        $step = $params['type'];
        $row = $params['row'];
        $view_type = isset($params['view_type']) ? $params['view_type'] : null;
        $title = '';
        if($step==TECHNICAL) {
            if(isset($row['id'])) {
                $title = $row['govnumber'];
                $title .= ' - ';
                $title .= mb_strtolower(__('messages.'.$step), 'UTF-8').' '.__('messages.informations_of');
            } else {
                $title = __('messages.'.$step.'_fill_form');
            }

        } elseif ($step==MEDICAL) {
            if(isset($row['driver_id'])) {
                $driver = Data::drivers(['id'=>$row['driver_id']]);
                $title = !empty($driver['label']) ? $driver['label'] : __('messages.not_filled');
                $title .= ' - ';
                $title .= mb_strtolower(__('messages.'.$step), 'UTF-8').' '.__('messages.informations_of');
            } else {
                $title = __('messages.'.$step.'_fill_form');
            }


        } elseif ($step==DISPATCHER) {
            $title = __('messages.dispatcher_fill_form');
        } elseif ($step==DIRECTOR) {
            $title = __('messages.director_fill_form');
        }

        return $title;
    }

    public static function searchForId($id, $column, $array) {
        foreach ($array as $key => $val) {
            if ($val[$column] == $id) {
                return $array[$key];
            }
        }
        return null;
    }

    public static function searchForIdThree($id, $column, $array) {
        foreach ($array as $key => $val) {
            if ($val[$column[0]] == $id[0] and $val[$column[1]] == $id[1] and $val[$column[2]] == $id[2]) {
                return $array[$key];
            }
        }
        return null;
    }

    public static function generate_guid_id() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x%04x-%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 32 bits for "time_low"
            mt_rand(0, 0xffff), // 16 bits for "time_mid"
            mt_rand(0, 0xffff), // 16 bits for "time_mid"
            mt_rand(0, 0x0fff) | 0x4000, // 16 bits for "time_high_and_version", with version 4
            mt_rand(0, 0x3fff) | 0x8000, // 16 bits for "clk_seq_hi_res", with variant 10
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 64 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 64 bits for "node"
        );

    }

    public static function combine_data($params) {
        $json_info = null;
        if(isset($params['json_info']['stage'])) {
            if(isset($params['stage'][$params['post_name']]['stage'])) {
                $params['json_info']['stage'] = $params['stage'][$params['post_name']]['stage'];
            }
            if(isset($params['stage'][$params['post_name']]['change'])) {
                $params['json_info']['change'] = $params['stage'][$params['post_name']]['change'];
            }

            $json_info = json_encode($params['json_info'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if(isset($params['info_data'][$params['post_name']])) {
                $params['info_data'][$params['post_name']]['json_info'] = $json_info;
                unset($params['info_data'][$params['post_name']]['stage']);
        }

        return $params;
    }


    public static function auth_for_api($params=null) {

        $send_data = json_encode($params['send_data']);
        $ch = curl_init(API_URL.'/login');
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'accept: application/json',
                'Content-Type: application/json',
                ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$send_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $receive = json_decode($result, true);
        return [
          'json'=>$result,
          'array'=>$receive,
        ];
    }


    public static function get_auth_token_api($params=null) {
        $send_data = isset($params['send_data']) ? $params['send_data'] : null;
        $filepath = AppServiceProvider::base_api_path().'/token.txt';

        $get_token = !file_exists($filepath) ? true : false;
        if(isset($params['get_token'])) {
            $get_token = $params['get_token'];
        }
        if($get_token) {
            $params_api = ['send_data'=>$send_data];
            $auth_for_api = AppServiceProvider::auth_for_api($params_api);
            $token = isset($auth_for_api['array']['data']['auth']['user']['api_token']) ? $auth_for_api['array']['data']['auth']['user']['api_token'] : null;
            if(!empty($token)) {
                $writed = file_put_contents($filepath, $token);
            }

        } else {
            $token = file_get_contents($filepath);
        }

        return $token;

    }

    public static function flights_from_api($params=null) {
        $send_data = $params['send_data'];
        unset($send_data['date']);
        $additional_params = '';
        if(isset($send_data['status'])) {
            $additional_params .= '_'.$send_data['status'];
        }
        if(isset($send_data['date'])) {
            $additional_params .= '_'.$send_data['date'];
        }
        if(isset($send_data['status']) or isset($send_data['date']) ) {
            $send_data_json = json_encode($send_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $send_data_json = null;
        }
        
        $basepath = AppServiceProvider::base_api_path();
        $path_params = ['basepath'=>$basepath, 'fullpath' => $basepath.'/'.__FUNCTION__];
        $filepath = $path_params['fullpath'].'/'.__FUNCTION__.$additional_params.'.txt';

        $token = $params['token'];

        $ch = curl_init(API_URL.'/trips');
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'accept: application/json',
                'Content-Type: application/json',
                'Crm-Auth: Token '.$token,
               )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$send_data_json);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $receive = json_decode($result, true);

        if(!empty($receive['data'])) {
            if(isset($path_params['fullpath']) and !is_dir($path_params['fullpath'])) {
                mkdir($path_params['fullpath'], 0775);
            }
            $writed = file_put_contents($filepath, $result);
        }

        return [
            'json'=>$result,
            'array'=>$receive,
            'filepath'=>$filepath,
        ];
    }

    public static function boarded_passengers_from_api($params=null) {
        $send_data_json = null;
        $additional_params = '-'.$params['trip_id'];

        $basepath = AppServiceProvider::base_api_path();
        $path_params = ['basepath'=>$basepath, 'fullpath' => $basepath.'/'.__FUNCTION__];
        $filepath = $path_params['fullpath'].'/'.__FUNCTION__.$additional_params.'.txt';

        $token = $params['token'];
        $ch = curl_init(API_URL.'/trips/boarded-passengers/'.$params['trip_id']);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'accept: application/json',
                'Content-Type: application/json',
                'Crm-Auth: Token '.$token,
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $receive = json_decode($result, true);
        if(!empty($receive['data'])) {
            if(isset($path_params['fullpath']) and !is_dir($path_params['fullpath'])) {
                mkdir($path_params['fullpath'], 0775);
            }
            $writed = file_put_contents($filepath, $result);
        }

        $additional_params = '-'.$params['document_id'];
        $logname_main_log_data = 'main_log_data';
        $filepath = $basepath.'/'.$logname_main_log_data.'/'.$logname_main_log_data.$additional_params.'.txt';
        if(!is_dir($basepath.'/'.$logname_main_log_data)) {
            mkdir($basepath.'/'.$logname_main_log_data, 0775);
        }
        $main_log_data = [
            'trip_id'=>$params['trip_id'],
            'result_row'=>isset($params['result_row']) ? $params['result_row'] : null,
        ];
        $main_log_data = json_encode($main_log_data);

        $writed = file_put_contents($filepath, $main_log_data);
        return [
            'json'=>$result,
            'array'=>$receive,
            'filepath'=>$filepath,
        ];
    }

    public static function base_api_path($params=null) {
        $folder = 'api';
        $filepath = storage_path().'/'.$folder;
        if(!is_dir($filepath)) {
            mkdir($filepath, 0775);
        }


        return $filepath;
    }

    public static function slice_current_data($params=null) {
        extract($params);

        if(isset($params['trip_id'])) {
            $params['current_flight']  = AppServiceProvider::searchForId($params['trip_id'], 'trip_id', $params['flights_from_api']['data']);
            $exist_trip_id = true;
        } else {
            if($params['flights_from_api']['data']) {
                $params['current_flight'] = AppServiceProvider::searchForIdThree($ids, $columns_param, $params['flights_from_api']['data']);
                if(isset($params['current_flight']['trip_id'])) {
                }

            }
            $exist_trip_id = false;
        }

        if(!empty($params['current_flight'])) {
            if(!$exist_trip_id) {
                $params['trip_id'] = $params['current_flight']['trip_id'];
            }
    
            $basepath = AppServiceProvider::base_api_path();
            $subfolder = 'current_flight_data';
            $path_params = ['basepath'=>$basepath, 'fullpath' => $basepath.'/'.$subfolder];
            $filepath = $path_params['fullpath'].'/'.$subfolder.'-'.$params['trip_id'].'-'.$params['id'].'.txt';
            if(!file_exists($filepath)) {
                if(isset($path_params['fullpath']) and !is_dir($path_params['fullpath'])) {
                    mkdir($path_params['fullpath'], 0775);
                }
                file_put_contents($filepath, json_encode($params['current_flight']));
            }

            return $params['current_flight'];
        }

    }

    public static function ids_columns_three($params) {
        $ids = [
            $params['technical']['vehicle_id'],
            STATUS_ACTIVE,
            $params['technical']['carrier_id']
        ];
        $bus_id_column = 'bus_id';
        $transporter_id_column = 'transporter_id';

        $columns_param = [
            $bus_id_column,
            'trip_status',
            $transporter_id_column,
        ];

        return [
          'ids'=>$ids,
          'columns_param'=>$columns_param,
          'bus_id_column'=>$bus_id_column,
          'transporter_id_column'=>$transporter_id_column,
        ];
    }

    public static function cache_get_content($cachefile, $source, $cachetime = 3600, $method=null, $context=null) {
        $cache_file = storage_path().'/cache/'.$cachefile;

        if($cachetime===-1) {
            $cache = file_get_contents($cache_file);
            return $cache;
        }

        if(file_exists($cache_file)) {
            if(time() - filemtime($cache_file) > $cachetime) {
                // too old , re-fetch
                if($method=='post') {
                    $cache = file_get_contents($source, false, $context);
                } elseif($method=='json') {
                    $cache = $source;
                } elseif($method=='db') {
                    $cache = Data::get_select(['name'=>$source]);
                    if(isset($cache)) {
                        $cache = json_encode($cache);
                    }
                } else {
                    $cache = file_get_contents($source, false, $context);
                }
                if(!empty($cache)) {
                    file_put_contents($cache_file, $cache);
                } else {
                    $cache = file_get_contents($cache_file);
                }
            } else {

                $cache = file_get_contents($cache_file);
                if(empty($cache)) {
                    $cache = file_get_contents($source);
                }
            }
        } else {
            // no cache, create one
            if($method=='post') {
                $cache = file_get_contents($source, false, $context);
            } elseif($method=='json') {
                $cache = $source;
            } elseif($method=='db') {
                $cache = Data::get_select(['name'=>$source]);
                if(isset($cache)) {
                    $cache = json_encode($cache);
                }
            } 
            else {
                $cache = file_get_contents($source);
            }
            file_put_contents($cache_file, $cache);
        }
        return $cache;
    }

    public static function check_filter_columns($params) {
        $type = isset($params['type']) ? $params['type'] : null;
        $columns = [
            'govnumber',
        ];

        return [
            'columns'=>$columns
        ];
    }

    public static function readonly_attribute($params) {
         $result = '';
        if(isset($params['row'][0]['status']) and  in_array($params['row'][0]['status'], [20])) {
            $result = 'readonly';
        }

        return $result;
    }

}
