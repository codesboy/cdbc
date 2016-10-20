<?php
namespace app\index\model;

use think\Model;

// 用户信息模型
class UsersInfo extends Model
{
    protected $type = [
        'yy_time'    =>  'timestamp',
        'addtime'    =>  'timestamp'

    ];

    public function zixun()
    {
        return $this->hasMany('users_zixun','uid');
        // return $this->belongsTo('users_zixun','uid');
    }

    public function yuyue()
    {
        return $this->hasMany('users_yuyue','uid');
        // return $this->belongsTo('users_zixun','uid');
    }
}