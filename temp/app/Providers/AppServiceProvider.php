<?php

namespace App\Providers;

use App\Models\Data;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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
        }
        else {
            $input = trim(htmlentities(strip_tags($input), ENT_QUOTES));
        }
        if(strpos($name, 'date')!==false or strpos($name, 'time')!==false) {
            $input = date('Y-m-d H:i:s', strtotime($input));
        }
        return $input;
    }

    public static function status_change($step, $params=null) {
        $row_status = isset($params['row']['status']) ? $params['row']['status'] : null;
        $row_second_status = isset($params['row_second']['status']) ? $params['row_second']['status'] : null;
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
            if(!isset($row_second_status) and isset($row_status)) {
                $row_second_status = $row_status;
            }
            $status_second = isset($row_second_status) ? $row_second_status : $send_true;
            $step_status = $status_second;
        } elseif ($step==MEDICAL) {
            if(!isset($row_second_status) and isset($row_status)) {
                $row_second_status = $row_status;
            }
            $status_second = isset($row_second_status) ? $row_second_status : $send_true;
            $step_status = $status_second;
        } elseif ($step==DISPATCHER) {
            $status_second = $row_second_status;
            $cancel_status_second = $cancelled;
            if ($row_second_status==$confirmed && $row_status<$process_confirmed) {
                $status_third = $process_confirmed;
            } elseif ($row_second_status==$confirmed && $row_status==$process_confirmed) {
                $status_third = $preview;
            } elseif ($row_second_status==$cancelled && $row_status<$first_cancelled) {
                $status_third = $first_cancelled;
            } elseif ($row_second_status==$cancelled && $row_status==$first_cancelled) {
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
                'color'=>$step==DIRECTOR ? 'redb' : 'blueb',
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

}
