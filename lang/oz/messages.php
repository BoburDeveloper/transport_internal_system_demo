<?php
$technical = 'Texnik ko\'rik';
$medical = ' Tibbiy ko\'rik';
$dispatcher = 'Dispetcher';
$director = 'Direktor';
$status1 = 'Yangi';
$status5 = 'Ortga qaytarish';
$status9 = 'Bekor qilish';
$status11 = 'Jarayonda';
$status12 ='Ortga qaytarildi';
$status18 = 'Jarayonda';
$status19 = 'Tasdiqlandi';
$status20 = 'Tasdiqlandi';
$send_status5 = 'Ortga qaytarildi';
$send_status10 = 'Yuborildi';
$send_status20 = 'Tasdiqlash';
$permission_status5 = 'Ortga qaytarildi';
$permission_status10 = 'Ruxsat etiladi';
$permission_status9 = 'Ruxsat etilmaydi';
$permission_status20 = 'Qabul qilindi';
$end_status9 = 'Bekor qilindi';
$cabinet_of = 'kabineti';
$time_flight = 'Jo\'nagan vaqti';
$table_time_flight = 'Jadval bo\'yicha jo\'nash vaqti';
$depend_on_flight = 'Reysga ko\'ra';
$numserial = 'Haydovchilik guvohnomasi seriyasi va raqami';
$carrier = 'Tashuvchi';
$flight_id ='yo\'nalish';

$get_roles = [
    1 =>['label'=>$technical],
    2=>['label'=>$medical],
    3=>['label'=>$director],
    4=>['label'=>$dispatcher],
];

return [
    'technical'=>$technical,
    'technical_cabinet'=>$technical.' '.$cabinet_of,
    'technical_fill_form'=>$technical.'  ma\'lumotlarini kiriting',
    'medical'=>' '.$medical,
    'medical_medical'=>$medical.'  '.$cabinet_of,
    'medical_fill_form'=>$medical.'  ma\'lumotlarini kiriting',
    'home'=>'Asosiy',
    'fill_form'=>'Ma\'lumotlarni kiritish',
    'list'=>'Ro\'yxat',
    'details_of'=>'ma\'lumotlari',
    'govnumber'=>'Avtobusning davlat raqami',
    'vmodel_id'=>'Avtobusning modeli',
    'latin'=>'lotinda',
    'cyrillic'=>'kirillda',
    'flight_id'=>$flight_id,
    'time_flight'=>$time_flight,
    'table_time_flight'=>$table_time_flight,
    'save'=>'Saqlash',
    'given_date'=>'Berilgan sana',
    'select'=>'-Tanlash-',
    'successfully_sent'=>'Muvaffaqiyatli saqlandi',
    'time_med_exam'=>'Ko\'rik sanasi',
    'time_begin'=>'Boshlangan vaqti',
    'time_end'=>'Yakunlangan vaqti',
    'temperature'=>'Tana harorati',
    'pulse'=>'Puls',
    'bpressure_begin'=>'Qon bosimi (pastki ko\'rsatkich)',
    'bpressure_end'=>'Qon bosimi (yuqori ko\'rsatkich)',
    'diagnostic'=>'Tashxis',
    'status'=>'Holati',
    'status20'=>$send_status20,
    'end_status1'=>$status1,
    'end_status9'=>$end_status9,
    'end_status11'=>$status11,
    'end_status12'=>$status12,
    'end_status18'=>$status18,
    'end_status19'=>$status19,
    'end_status20'=>$status20,
    'status1'=>$status1,
    'status5'=>$status5,
    'status9'=>$status9,
    'status11'=>$status11,
    'status12'=>$status12,
    'status18'=>$status18,
    'status19'=>$status19,
    'permission_status1'=>$status1,
    'permission_status10'=>$permission_status10,
    'permission_status9'=>$permission_status9,
    'permission_status5'=>$permission_status5,
    'permission_status20'=>$permission_status20,
    'send_status1'=>$status1,
    'send_status10'=>$send_status10,
    'send_status5'=>$send_status5,
    'send_status20'=>$permission_status20,
    'permission_work'=>$permission_status10,
    'no_permission_work'=>$permission_status9,
    'driver_id'=>'Haydovchi',
    'bus'=>'Avtobus',
    'bus_and_flight'=>'Avtobus davlat raqami va yo\'nalishi',
    'dispatcher'=>$dispatcher,
    'dispatcher_cabinet'=>$dispatcher.' '.$cabinet_of,
    'dispatcher_fill_form'=>$dispatcher.' '.$cabinet_of,
    'director'=>$director,
    'director_fill_form'=>$director.' '.$cabinet_of,
    'comment'=>'Izoh',
    'informations_of'=>'ma\'lumotlari',
    'org_id'=>'Tashkilot',
    'staff_id'=>'Ijrochi',
    'staffs'=>'Ijrochilar',
    'created_time'=>'Yaratilgan vaqti',
    'updated_time'=>'Yangilangan vaqti',
    'document_id'=>'Hujjat ID',
    'and'=>'va',
    'common'=>'Umumiy',
    'result_technical'=>$technical.' natijasi',
    'result_medical'=>$medical.' natijasi',
    'result_dispatcher'=>$dispatcher.' xulosasi',
    'result_director'=>$director,
    'director_cabinet'=>$director.' '.$cabinet_of,
    'input_comment'=>'Izoh kiritish',
    'result'=>'Natija',
    'fio'=>'F.I.SH.',
    'profile'=>'Profil',
    'exit'=>'Chiqish',
    'sign_in'=>'Kirish',
    'home_page'=>'Bosh sahifa',
    'not_filled'=>'Kiritilmagan',
    'create'=>'Yangi kiritish',
    'driver_bus_and_flight'=>'Haydovchi, avtobus davlat raqami va yo\'nalishi',
    'driver_fio'=>'Haydovchi F.I.SH',
    'driver_not_found'=>'Haydovchi ma\'lumotlari topilmadi',
    'user_not_found'=>'Foydalanuvchi topilmadi',
    'data_not_found'=>'Ma\'lumotlar topilmadi',
    'fill_the_time_table_flight'=>$table_time_flight.' va '. $time_flight.'ni kiritish zarur!',
    'input'=>'Kiritish',
    'numserial'=>$numserial,
    'this_driver_second_time_today'=>'Ushbu haydovchini bugungi sana bo\'yicha ikkinchi marta kirityapsiz!',
    'name_uz'=>':name',
    'provided'=>'O\'tkazgan',
    'view_conclusion'=>'Xulosani ko\'rish',
    'provided_date'=>'O\'tkazilgan sana',
    'num_passengers'=>'Пассажирлар сони',
    'last_document'=>'Ma\'lumotnoma',
    'view'=>'Ko\'rish',
    'system_title'=>'SYSTEM',
    'system_description'=>'Система мониторинга и выдачи путевой ведомости',
    'contacts_for_questions'=>'При возникновении вопросов',
    'depend_on_flight'=>$depend_on_flight,
    'table_time_depend_on_flight'=>$depend_on_flight.' '.mb_strtolower($table_time_flight, 'UTF-8'),
    'do_you_confirm_to_cancel_document'=>'Ushbu xujjatni bekor qilishni tasdiqlaysizmi?',
    'i_will_confirm'=>'Tasdiqlayman',
    'no'=>'Yo\'q',
    'current_time'=>'Joriy vaqt',
    'you_should_enter_ancii_uppercase_symbols'=>$numserial.' lotin tilida va katta harflar bilan kiritilishi lozim.',
    'close'=>'Yopish',
    'table_flight_id'=>':name',
    'routes'=>'Yo\'nalishlar',
    'route_id'=>'Yo\'nalish',
    'carrier_id'=>$carrier,
    'vmodel_name'=>'Avtobusning modeli',
    'or_write'=>'Yoki kiriting',
    'write_of'=>'ni kiriting',
    'select_of'=>'ni tanlang',
    'or'=>'Yoki',
    'boarder_passengers'=>'Yo\'lovchilar ro\'yxati',
    'sold_seats_count'=>'Yo\'lovchilar soni',
    'price'=>'Narxi',
    'carrier_name'=>$carrier,
    'flight_name_uz'=>$flight_id,
    'you_should_enter_ancii_symbols'=>':name lotin tilida kiritilishi lozim.',
    'role_label1'=>$get_roles[1]['label'],
    'role_label2'=>$get_roles[2]['label'],
    'role_label3'=>$get_roles[3]['label'],
    'role_label4'=>$get_roles[4]['label'],
    'in_form_only_one_unique_driver'=>'Formada bir haydovchining ma\'lumotlari qaytalanmasligi lozim.',
    'doc_number'=>'Hujjat raqami',
    'transport_govnumber'=>'Transport davlat raqami',
    'last_given_date'=>'Ma\'lumotnoma sanasi',    
    'username'=>'Login',
    'password'=>'Password',
    'captcha'=>' Verification code',
    'drivers'=>'Haydovchilar',
    'buses'=>'Avtobuslar',
    'list_buses'=>'Avtobuslar ro\'yxati',
    'num_drivers'=>'Haydovchilar soni',
    'column_name_uz'=>'Nomi(kirillda)',
    'column_name_oz'=>'Nomi(lotinda)',
    'column_name_en'=>'Nomi(inglizchada)',
    'column_name_ru'=>'Nomi(ruschada)',
    'is_international'=>'Xalqaro reys',
    'seat_number'=>'Joyi',
    'phone_number'=>'Telefon raqami',
    'date_birth'=>'Tug\'ilgan sanasi',
    'passport_num'=>'Passport raqami',
    'price_ticket'=>'Bilet narxi',
    'number_ticket'=>'Bilet raqami',
    'citizenship'=>'Fuqaroligi',
    'list_passengers'=>'Yo\'lovchilar ro\'yxati',
    'date'=>'Sana',
];
