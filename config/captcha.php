<?php
/**
 * Created by PhpStorm.
 * User: B.Ziyodullayev
 * Date: 13-Jul-21
 * Time: 18:42
 */
return [
    'default'   => [
        'length'    => 9,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'math'      => true,  //Enable Math Captcha
        'expire'    => 60,    //Stateless/API captcha expiration
        'fontColors'=>['#2F3D79'],
        'lines' => false,
        'encrypt' => false,
    ],
    // ...
];
