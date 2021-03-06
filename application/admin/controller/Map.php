<?php
namespace app\admin\controller;
use \think\Controller;
class Map extends Controller
{
    /*
     * @刘柯
     * 2018/04/27 11:20
     * 经度
     */
    public function lng($newdata)
    {
        $url = "http://api.map.baidu.com/geocoder/v2/?address=".$newdata."&output=json&ak=7GQ2o7u5lwmiOYVhhRlvAQT4IYcG3qYQ";
        $address_data = file_get_contents($url);
        $json_data = json_decode($address_data);
        $lng = $json_data->result->location->lng;
        return $lng;
    }
    /*
     * @刘柯
     * 2018/04/27 11:10
     * 经度
     */
    public function lat($newdata)
    {
        $url = "http://api.map.baidu.com/geocoder/v2/?address=".$newdata."&output=json&ak=7GQ2o7u5lwmiOYVhhRlvAQT4IYcG3qYQ";
        $address_data = file_get_contents($url);
        $json_data = json_decode($address_data);
        $lat = $json_data->result->location->lat;
        return $lat;
    }
    /*
     * @刘柯
     * 2018/04/27 11:9
     *城市
     */
    public function getCity(){
        $ch = curl_init();
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $arrData = curl_exec($ch);
        $arr = json_decode($arrData,true);
        return $arr['city'];
    }
    /*
     * @刘柯
     * 2018/04/27 11：23
     * 数据
     */
    public function lic ()
    {
        $city = $this->getCity();
        $lng  = $this->lng($city);//经度
        $lat  = $this->lat($city);//纬度
    }
}