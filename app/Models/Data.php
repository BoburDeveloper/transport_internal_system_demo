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

    public static function flights($params=null) {
        $table = FLIGHTS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        $condition = '';
        if(isset($params['id'])) {
            $result = (array)DB::select("select ".$columns_str." from ".$table." where status>0 and id=?",[$params['id']]);
            if(isset($result[0])) {
                $result = (array)$result[0];
            }
        } else {
            if(isset($params['not_needed'])) {
                $condition .= ' and id not in('.$params['not_needed'].')';
            }
            $result = (array)DB::select("select ".$columns_str." from ".$table." where status>0 ".$condition);
            foreach($result as $key => $value) {
                $result[$key] = (array)$value;
                if($result[$key]['is_international']===true) {
                    $result[$key]['label'] = $result[$key]['name_ru'];
                } else {
                    $result[$key]['label'] = $result[$key]['name_'.app()->getLocale()];
                }
            }
        }


        return $result;
    }

    public static function table_flights($params=null) {
        $table = TABLE_FLIGHTS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        if(isset($params['id'])) {
            $result = (array)DB::select("select ".$columns_str." from ".$table." where status>0 and id=?",[$params['id']]);
            if(isset($result[0])) {
                $result = (array)$result[0];
            }
        } else {
            $result = (array)DB::select("select ".$columns_str." from ".$table." where status>0");
            foreach($result as $key => $value) {
                $result[$key] = (array)$value;
            }
        }


        return $result;
    }
    public static function vmodels($params=null) {
        $table = VMODELS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        if(isset($params['id'])) {
            $id = $params['id'];
            $result = DB::table($table)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
            $result = (array)$result;
        } else {
            $result = DB::table($table)->select(DB::raw($columns_str))->where('status','>',0)->get()->toArray();
            foreach ($result as $key => $value) {
                $result[$key] = (array)$value;
                $result[$key]['label'] = $result[$key]['name'];
            }
        }

        return $result;
    }

    public static function bus_models($params=null) {
        $table = BUS_MODELS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        if(isset($params['id'])) {
            $id = $params['id'];
            $result = DB::table($table)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
            $result = (array)$result;
        } elseif(isset($params['condition'])) {
            $result = DB::table($table)->select(DB::raw($columns_str))->where($params['condition'])->where('status','>',0)->get()->toArray();

            foreach ($result as $key => $value) {
                $result[$key] = (array)$value;
                $result[$key]['label'] = $result[$key]['bus_number'];
            }
        } 
        else {
            $result = DB::table($table)->select(DB::raw($columns_str))->where('status','>',0)->get()->toArray();
            foreach ($result as $key => $value) {
                $result[$key] = (array)$value;
                $result[$key]['label'] = $result[$key]['bus_number'];
            }
        }

        return $result;
    }

    public static function drivers($params=null) {
        $table = DRIVERS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        if(isset($params['id'])) {
            $id = $params['id'];
            $result = DB::table($table)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
            $result = (array)$result;
        } else {
            $result = DB::table($table)->select(DB::raw($columns_str))->where('status','>',0)->get()->toArray();
            foreach ($result as $key => $value) {
                $result[$key] = (array)$value;
            }
        }

        return $result;
    }

    public static function carriers($params=null) {
        $table = CARRIERS;
        $columns = Data::column_names($table);
        $columns_str = $columns['columns_str'];
        if(isset($params['id'])) {
            $id = $params['id'];
            $result = DB::table($table)->select(DB::raw($columns_str))->where(['id'=>$id])->where('status','>',0)->first();
            $result = (array)$result;
        } else {
            $result = DB::table($table)->select(DB::raw($columns_str))->where('status','>',0)->get()->toArray();
            foreach($result as $key => $value) {
                $result[$key] = (array)$value;
                    $result[$key]['label'] = $result[$key]['name'];

            }
        }

        return $result;
    }

    public static function column_names($table, $params=null) {

        $type_id = isset($params['type_id']) ? $params['type_id'] : null;
        $not_needed = isset($params['not_needed']) ? $params['not_needed'] : null;
        $prefix = isset($params['prefix']) ? $params['prefix'].'.' : null;
        $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = '".$table."'");
        $columns_str = '';
        $columns_arr = [];
        $get_columns = [];
        $last_columns_str = '';

        foreach ($columns as $key => $value) {
            $get_columns[$key]['column_name'] = $prefix.$columns[$key]->column_name;
            if($type_id!=1) {
                if(strpos($columns[$key]->column_name, 'time')!==false) {
                    $get_columns[$key]['column_name'] = "to_char(".$prefix.$columns[$key]->column_name.", 'DD.MM.YYYY HH:MI') ".$columns[$key]->column_name;
                }
                if(strpos($columns[$key]->column_name, '_date')!==false) {
                    $get_columns[$key]['column_name'] = "to_char(".$prefix.$columns[$key]->column_name.", 'DD.MM.YYYY') ".$columns[$key]->column_name;
                }
            }

            $columns_str .= $get_columns[$key]['column_name'].', ';
            $columns_arr[] = $get_columns[$key]['column_name'];
            

            if(isset($not_needed)) {
                if(in_array($get_columns[$key]['column_name'], $not_needed)) {
                    unset($get_columns[$key]);
                } else {
                    $last_columns_str .= $get_columns[$key]['column_name'].', ';
                }
            }

        }

        $columns_str = mb_substr($columns_str, 0, -2, 'UTF-8');
        if(!empty($last_columns_str)) {
            $last_columns_str = mb_substr($last_columns_str, 0, -2, 'UTF-8');
        }
        return [
            'columns'=>$get_columns,
            'columns_str'=>$columns_str,
            'columns_arr'=>$columns_arr,
            'last_columns_str'=>$last_columns_str,
        ];
    }



    public static function get_join_row($params=null) {
        $id = isset($params['id']) ? $params['id'] : null;
        $status_type = isset($params['status_type']) ? $params['status_type'] : null;
        $filter = isset($params['filter']) ? $params['filter'] : null;
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

        $binding = [];

        $select = "t.id, t.id document_id, t.guid_id, ".$main_status." ".$status_prefix.".status second_status, s.govnumber, s.flight_id,  s.status tech_status, n.time_med_exam, s.driver_id, n.diagnostic, n.status med_status, m.name_uz driver_fio, m.numserial, k.given_date last_given_date";
    
        $select = isset($params['select']) ? $params['select'] : $select;

        if(isset($id)) {
            $condition .= ' and coalesce(m.id,0)>0';
            $sql = "select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0
                        right join db.drivers m on m.id::VARCHAR = ANY(string_to_array(s.driver_id, ',') ) and m.status>0
                        left join db.medical n on n.document_id=t.id and n.status>0 and n.driver_id=m.id
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        where t.status>0 ".$condition." and t.id=?";
            $result = DB::select($sql,[$id]);
            if(isset($result)) {
                $result = (array)$result;
                foreach ($result as $key => $value) {
                    $result[$key] = (array)$value;
                }
            }

        } elseif(isset($status_type)) {
            $condition1 = '';
            $condition2 = '';
            
            $check_filter_columns = AppServiceProvider::check_filter_columns(['type'=>$status_type])['columns'];
            if(isset($filter)) {
                foreach($filter as $key => $value) {
                    if(in_array($key, $check_filter_columns)) {
                        $condition .= " and ".$key."=?";
                        $binding[] = $value;
                    }
                }
            }
         
            $select = "t.id, t.id document_id, t.guid_id, t.table_flight_id, ".$main_status." ".$status_prefix.".status second_status, s.govnumber, s.flight_id,  s.status tech_status, n.time_med_exam, s.driver_id, n.diagnostic, n.status med_status, STRING_AGG(m.name_uz, '; ') driver_fio, string_agg(m.numserial, '; ') numserial, k.given_date last_given_date ";
        
            $group_by_items = "t.id, t.guid_id, t.table_flight_id, ".$main_status." ".$status_prefix.".status, s.govnumber, s.flight_id,  s.status, n.time_med_exam, s.driver_id, n.diagnostic, n.status, k.given_date";
        
            if($status_type==DISPATCHER) {
                $condition1 = ' and s.status in(10,20)';
                $condition2 = ' and n.status in(10,20)';
                $condition .= ' and COALESCE(s.id,0)>0 and COALESCE(n.id,0)>0 ';
            }

            $result = DB::select("select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0 ".$condition1."
                        left join db.medical n on n.document_id=t.id and n.status>0 ".$condition2."
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        left join db.drivers m on m.id::VARCHAR = ANY(string_to_array(s.driver_id, ',') ) and m.status>0
                        where t.status>0 ".$condition."  group by ".$group_by_items."
                        order by id desc
            ", $binding);
            $result = (array)$result;
        } else {
            $result = DB::select("select ".$select." from db.document t
                        left join db.technical s on s.document_id=t.id and s.status>0
                        left join db.medical n on n.document_id=t.id and n.status>0
                        left join db.dispatcher z on z.document_id=t.id and z.status>0
                        left join db.director k on k.document_id=t.id and k.status>0
                        left join db.drivers m on m.id::VARCHAR = ANY(string_to_array(s.driver_id, ',') ) and m.status>0
                        where t.status>0 ".$condition." order by id desc

            ", $binding);
            $result = (array)$result;
        }

        return $result;
    }

    public static function check_one_driver_secondly_today($params) {
        $result = DB::select("select m.id driver_id, m.numserial from db.drivers m
                                    left join db.technical t on m.id::VARCHAR = ANY(string_to_array(t.driver_id, ',') ) and t.status>0
                                    where m.status>0 and m.numserial=? and t.given_date=?",
            [$params['numserial'], $params['given_date']]);
        return (array)$result;
    }

    public static function get_detail_all($id) {
        $column_names = [];
        $info = [];
        $status_data = [];

        $page_type = TECHNICAL;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1, 'not_needed'=>['flight_from', 'flight_to', 'id', 'json_info', 'comment', 'org_id', 'staff_id']]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];


        $page_type = MEDICAL;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1, 'not_needed'=>['flight_from', 'flight_to', 'id', 'json_info', 'comment',]]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];

        $page_type = DISPATCHER;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>1, 'not_needed'=>['json_info']]);
        $columns_str = $column_names[$page_type]['columns_str'];
        $info[$page_type] = DB::table($page_type)->select(DB::raw($columns_str))->where(['document_id'=>$id])->where('status','>',0)->first();
        $info[$page_type] = (array)$info[$page_type];

        $page_type = DIRECTOR;
        $status_data[$page_type] = AppServiceProvider::status_change($page_type);
        $column_names[$page_type] = Data::column_names(TYPES[$page_type]['table'], ['type_id'=>2, 'not_needed'=>['json_info']]);
        $columns_str = $column_names[$page_type]['last_columns_str'];

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

    public static function get_select($params) {
        $name = isset($params['name']) ? $params['name'] : null;
        if(isset($name)) {
            $select = "id, name_uz, name_oz, name";
            $result = DB::select("select ".$select." from db.roles where status>0");
            if(!empty($result)) {
                $result = (array)$result;
                foreach($result as $key => $value) {
                    $result[$key] = (array)$result[$key];
                }
            }
        }
        return $result;
    }

    public static function get_org_users($params) {
        $table = USERS;
        $columns = Data::column_names($table, ['type_id'=>2, 'not_needed'=>['password']]);
        $columns_str = $columns['last_columns_str'];
        $result = DB::table($table)->select(DB::raw($columns_str))->where('status', '>', 0)->where($params['condition'])->get()->toArray();
        foreach($result as $key => $value) {
            $result[$key] = (array)$result[$key];
        }
        return $result;        
    }

}
