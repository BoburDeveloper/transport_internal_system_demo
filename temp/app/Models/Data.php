<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Data extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function get_sequence($sequence) {
        return DB::select("select nextval('db.$sequence')");
    }

    public static function flights() {
        return [
            [
                'id'=>1,
                'label'=>'Ташкент - Алматы',
            ],
        ];
    }

    public static function vmodels() {
        return [
            [
                'id'=>1,
                'label'=>'Yutong 51',
            ]
        ];
    }

    public static function drivers($params=null) {
        $columns_str = 'id, name_uz as label';
        if(isset($params['id'])) {
            $id = $params['id'];
            $result = DB::table('drivers')->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
            $result = (array)$result;
        } else {
            $result = DB::table('drivers')->select(DB::raw($columns_str))->where('status','>',0)->get()->toArray();
            foreach ($result as $key => $value) {
                $result[$key] = (array)$value;
            }
        }

        return $result;
    }

    public static function column_names($table, $params=null) {

        $type_id = isset($params['type_id']) ? $params['type_id'] : null;
        $not_needed = isset($params['not_needed']) ? $params['not_needed'] : null;
        $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = '".$table."'");
        $columns_str = '';
        $columns_arr = [];
        foreach ($columns as $key => $value) {

            if($type_id!=1) {
                if(strpos($columns[$key]->column_name, 'time')!==false) {
                    $columns[$key]->column_name = "to_char(".$columns[$key]->column_name.", 'DD.MM.YYYY HH:MI') ".$columns[$key]->column_name;
                }
                if(strpos($columns[$key]->column_name, '_date')!==false) {
                    $columns[$key]->column_name = "to_char(".$columns[$key]->column_name.", 'DD.MM.YYYY') ".$columns[$key]->column_name;
                }
            }

            $columns[$key] = (array)$value;
            $columns_str .= $value->column_name.', ';
            $columns_arr[] = $value->column_name;
            if(isset($not_needed)) {
                if(in_array($columns[$key]['column_name'], $not_needed)) {
                    unset($columns[$key]);
                }
            }

        }
        $columns_str = mb_substr($columns_str, 0, -2, 'UTF-8');
        return [
            'columns'=>$columns,
            'columns_str'=>$columns_str,
            'columns_arr'=>$columns_arr,
        ];
    }

    public static function get_join_row($params=null) {
        $id = isset($params['id']) ? $params['id'] : null;
        $status_type = isset($params['status_type']) ? $params['status_type'] : null;
        $status_prefix = 't';
        $main_status = 't.status, ';
        $condition = '';
        if($status_type==TECHNICAL) {
            $status_prefix = 's';
        } elseif($status_type==MEDICAL) {
            $status_prefix = 'n';
            $condition = 'and COALESCE (s.id,0)>0';
        } elseif($status_type==DISPATCHER) {
            $status_prefix = 'z';
            $condition = 'and COALESCE (s.id,0)>0';
        }
        $select = "t.id, t.id document_id, t.guid_id, ".$main_status." ".$status_prefix.".status second_status, s.govnumber, s.flight_id,  s.status tech_status, n.time_med_exam, s.driver_id, n.diagnostic, n.status med_status, m.name_uz driver_fio, m.numserial";
        $select = isset($params['select']) ? $params['select'] : $select;

        if(isset($id)) {
            $result = DB::select("select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0
                        left join db.medical n on n.document_id=t.id and n.status>0
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        left join db.drivers m on m.id=s.driver_id and m.status>0
                        where t.status>0 ".$condition." and t.id=?

            ",[$id]);
            if(isset($result[0])) {
                $result = (array)(array)$result[0];
            }

        } elseif(isset($status_type)) {
            $result = DB::select("select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0
                        left join db.medical n on n.document_id=t.id and n.status>0
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        left join db.drivers m on m.id=s.driver_id and m.status>0
                        where t.status>0 ".$condition." order by id desc

            ");
            $result = (array)$result;
        } else {
            $result = DB::select("select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0
                        left join db.medical n on n.document_id=t.id and n.status>0
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        left join db.drivers m on m.id=s.driver_id and m.status>0
                        where t.status>0 ".$condition." order by id desc

            ");
            $result = (array)$result;
        }

        return $result;
    }

    public static function check_one_driver_secondly_today($params) {
        $result = DB::select("select m.id driver_id, m.numserial from db.drivers m
                                    left join db.technical t on t.driver_id=m.id and t.status>0
                                    where m.status>0 and m.numserial=? and t.given_date=? or (m.id = ? or ? = 0)",
            [$params['numserial'], $params['given_date'], $params['driver_id'], $params['driver_id']]);
        return (array)$result;
    }

    public static function get_detail_all($id) {
        $column_names = [];
        $info = [];
        $status_data = [];

        $page_type = TECHNICAL;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1, 'not_needed'=>['flight_from', 'flight_to', 'id']]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];


        $page_type = MEDICAL;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1, 'not_needed'=>['flight_from', 'flight_to', 'id']]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];

        $page_type = DISPATCHER;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];

        $page_type = DIRECTOR;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];

        $status_data[DOCUMENT] = AppServiceProvider::status_change(DOCUMENT);
        $column_names[DOCUMENT] = Data::column_names(TYPES[DOCUMENT]['table'], ['type_id'=>1]);

        return [
            'info'=>$info,
            'column_names'=>$column_names,
            'status_data'=>$status_data,
        ];
    }

}
