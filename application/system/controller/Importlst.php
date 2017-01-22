<?php
namespace app\system\controller;
use app\system\model\AddForm;
use app\system\model\UsersTemp;
use app\system\model\UsersTemp2;
// use think\Db;
use \PHPExcel;
use \PHPExcel_IOFactory;
class Importlst extends Base
{
    // 导入基本客户资料 医汇通到诊
    public function import(){
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="a1.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数


        //从第二行开始读取数据{
        for($j=3;$j<=$highestRow;$j++){
            $str="";
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            {
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|*|';//读取单元格
            }
            $str=mb_convert_encoding($str,'utf-8','auto');//根据自己编码修改
            $strs = explode("|*|",$str);
            //echo $str . "<br />";
            //exit;
            // $sql = "insert into test (title,content,sn,num) values ('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}')";


            // exit;

            switch ($strs[1]) {
                case '男':
                    $strs[1]=1;
                    break;
                case '女':
                    $strs[1]=2;
                    break;
                default:
                    $strs[1]=0;
                    break;
            }

            // $strs[10]=strtotime($strs[10]);
            // echo $strs[2];
            // echo strtotime($strs[10]);
            // $shared = new \PHPExcel_Shared_Date();

            $user=new UsersTemp2;
            $user->data([

                'xm'=>$strs[0],
                'xb'=>$strs[1],
                'age'=>$strs[2],
                'dh'=>$strs[3],
                'kfqd'=>$strs[4],
                'xxly'=>$strs[5],
                'zxys'=>$strs[6],
                'dzsj'=>strtotime($strs[7]),
                'zxgj'=>$strs[8],
                'fzlb'=>$strs[12],
                'jzys'=>$strs[13],
            ]);
            $result=$user->save();
            // $result=$user->fetchSql()->save();
            // return $user::getLastSql();
            /*if($result){
                return '导入成功';
            }*/
            //echo $sql;
            //exit
        }
    }

    public function lst(){
        // $data= UsersTemp2::all()->paginate(10);
        $data= UsersTemp2::paginate(30);
        // $data= UsersTemp2::select()->paginate(10);
        // $data= UsersTemp2::select();
        // dump($data);die;
        $this->assign('data',$data);
        return $this->fetch('index');
    }

    // 导入客户消费（宏脉 客户消费明细表.xls）
    public function daoru(){
        $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use Excel5 for 2003 format
        $excelpath="b.xls";
        $objPHPExcel = $objReader->load(ROOT_PATH.$excelpath);
        $sheet = $objPHPExcel->getSheet(0);//// 读取第一個工作表
        $highestRow = $sheet->getHighestRow();           //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列数

        /*echo $highestRow."<br>";
        echo $highestColumn."<br>";
        exit;*/


        //从第四行开始读取数据{
        for($j=4;$j<=$highestRow;$j++){
            $str="";
            for($k='A';$k<=$highestColumn;$k++)            //从A列读取数据
            {
                $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|*|';//读取单元格
            }
            $str=mb_convert_encoding($str,'utf-8','auto');//根据自己编码修改
            $strs = explode("|*|",$str);
            // echo $str . "<br />";
            // dump($strs);
            // exit;
            // $sql = "insert into test (title,content,sn,num) values ('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}')";


            // exit;

            /*switch ($strs[2]) {
                case '男':
                    $strs[2]=1;
                    break;
                case '女':
                    $strs[2]=2;
                    break;
                default:
                    $strs[2]=0;
                    break;
            }*/

            // $strs[10]=strtotime($strs[10]);
            // echo $strs[2];
            // echo strtotime($strs[10]);
            // $shared = new \PHPExcel_Shared_Date();

            $user=new UsersTemp;
            $user->data([
                'xm'=>$strs[2],
                'khkh'=>$strs[1],
                'xfje'=>$strs[7],
                'bz'=>$strs[9],
            ]);
            $result=$user->save();
            // $result=$user->fetchSql()->save();
            // return $user::getLastSql();
            /*if($result){
                return '导入成功';
            }*/
            //echo $sql;
            //exit
        }
    }


}