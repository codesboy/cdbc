<?php
namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    // 初始化控制器
    public function _initialize()
    {
        if(!session('user_name')){            
            exit('非法操作');
        }
    }
}