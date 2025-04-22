<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    public static $mainLanguage = 'uz'; //основной язык, который не должен отображаться в URl

    public static $languages = ['uz', 'oz']; // Указываем, какие языки будем использовать в приложении.


    /*
     * Проверяет наличие корректной метки языка в текущем URL
     * Возвращает метку или значеие null, если нет метки
     */
    public static function getLocale()
    {
        $uri = $_SERVER['REQUEST_URI']; //получаем URI
        $segmentsURI = explode('/',$uri); //делим на части по разделителю "/"
        $first_segment = \request()->segment(1);
        //Проверяем метку языка  - есть ли она среди доступных языков
        if (!empty($first_segment) && in_array($first_segment, self::$languages)) {

            return $first_segment;

        }
        elseif(!empty($first_segment && $first_segment==env('APP_SUBFOLDER'))) {
            return $mainLanguage;
        }
        else {
            return  self::$mainLanguage;
        }
    }

    public function handle($request, Closure $next)
    {
        $locale = self::getLocale();
        if($locale) App::setLocale($locale);
        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }

}
