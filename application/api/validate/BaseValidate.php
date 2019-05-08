<?php
/**
 * Created by PhpStorm.
 * User: show
 * Date: 2019/5/7
 * Time: 11:56
 */

namespace app\api\validate;
use think\Validate;
use think\Request;
//验证器都得有引入自定义异常并抛出
//中间继承类，给其他validate继承。为其他继承他的添加公用 function
class BaseValidate extends Validate
{
    public function goCheck(){
        //获取http传入值
        $request = Request::instance();
        $params = $request->param(); //一次校验全部参数并报错
        //对参数做校验
        $result =$this->batch()->check($params);
        if(!$result){
            //按照默认参数抛出
            // throw new ParamemeterException();
            //修改参数抛出错误
            return json_encode([
                'msg' => $this->error
            ]);
        }
        else{
            return true;
        }
    }


//常用共用function放在Base里面
    protected function isPosInt($value,$rule = '',$data = '', $field = '')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0)>0) {
            return true;
        }
        else{
            return false;
        }
    }


//非空字符串
    protected function isNotEmpty($value,$rule = '',$data = '', $field = ''){
        if(empty($value))  return false;
        return true;
    }
//必须是modeli
    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if($result) return true;
        return false;
    }


//过滤出只要的参数
    public function getDataByRule($arrays){
        $newArray = array();
        foreach ($this->rule as $key => $value) {
//          如果是数组格式的
            if(strpos($key,".")) {
                $keyArr = explode(".",$key);
                array_key_exists($keyArr[0],$newArray) ? "" :  $newArray[$keyArr[0]] = array();//如果没有就创建数组
                array_key_exists($keyArr[1],$arrays[$keyArr[0]]) ? $newArray[$keyArr[0]][$keyArr[1]] =$arrays[$keyArr[0]][$keyArr[1]] : "";
            }
            else{
                array_key_exists($key,$arrays) ? $newArray[$key] = $arrays[$key] : "";
            }
        }
        return $newArray;
    }
}
?>