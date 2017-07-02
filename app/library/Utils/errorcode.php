<?php
namespace App\Library\Utils;
/**
 * 错误码
 */
class Errorcode
{
    public static $codes = [
        '401' => [
            'code' => 401,
            'label' => '未授权的操作'
        ],
        '404' => [
            'code' => 404,
            'label' => '未能找到您要访问的页面',
        ],
    ];
}
