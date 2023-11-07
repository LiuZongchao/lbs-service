<?php


namespace Howtec\LbsService\core;


/**
 * 腾讯位置服务
 * Class LbsQQ
 * @package howtec\LbsService
 */
class LbsQQ implements LbsService
{
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }
    public function getDistrict()
    {
        // TODO: Implement getDistrict() method.
        $url = 'https://apis.map.qq.com/ws/district/v1/list?key='.$this->key;
        try{
            $response = file_get_contents($url);
            $resObj =  json_decode($response,true);
            if(isset($resObj['status']) && $resObj['status'] == 0){
                return ['code'=>200,'data'=>$resObj['result']];
            }else{
                return ['code'=>500,'msg'=>isset($resObj['msg'])?$resObj['msg']:'unknow error'];
            }
        }catch (\Exception $e){
            return ['code'=>500,'msg'=>$e->getMessage()];
        }
    }


    public function getDistrictChildren($pid = "0")
    {
        // TODO: Implement getDistrictChildren() method.
        if(empty($pid)){
            $url = 'https://apis.map.qq.com/ws/district/v1/list?key='.$this->key;
        }else{
            $url = 'https://apis.map.qq.com/ws/district/v1/getchildren?key='.$this->key.'&id='.$pid;
        }
        try{
            $response = file_get_contents($url);
            $resObj =  json_decode($response,true);
            if(isset($resObj['status']) && $resObj['status'] == 0){
                return ['code'=>200,'data'=>$resObj['result'][0]];
            }else{
                return ['code'=>500,'msg'=>isset($resObj['msg'])?$resObj['msg']:'unknow error'];
            }
        }catch (\Exception $e){
            return ['code'=>500,'msg'=>$e->getMessage()];
        }
    }


    public function searchDistrict($keyword)
    {
        // TODO: Implement searchDistrict() method.
        $url = 'https://apis.map.qq.com/ws/district/v1/search?key='.$this->key.'&keyword='.urlencode($keyword);
        $response = file_get_contents($url);
        return $response;
    }

    /**
     * 地址解析
     * @param $keyword
     * @return array
     */
    public function searchAddress($keyword)
    {
        // TODO: Implement searchDistrict() method.
        $url = 'https://apis.map.qq.com/ws/geocoder/v1/?key='.$this->key.'&address='.urlencode($keyword);
        try{
            $response = file_get_contents($url);
            $resObj =  json_decode($response,true);
            if(isset($resObj['status']) && $resObj['status'] == 0){
                $result = [
                    'adcode'=>$resObj['result']['ad_info']['adcode'],
                    'province'=>$resObj['result']['address_components']['province'],
                    'city'=>$resObj['result']['address_components']['city'],
                    'district'=>$resObj['result']['address_components']['district'],
                    'lat' => $resObj['result']['location']['lat'],
                    'lng' => $resObj['result']['location']['lng'],
                ];
                return ['code'=>200,'msg'=>'success','data'=>$result];
            }else{
                return ['code'=>500,'msg'=>isset($resObj['msg'])?$resObj['msg']:'unknow error'.",请输入详细地址后再试"];
            }
        }catch (\Exception $e){
            return ['code'=>500,'msg'=>$e->getMessage().",请输入详细地址后再试"];
        }
    }
    /**
     * 根据经纬度进行逆地址解析
     */
    public function getCoderByLocation($lng,$lat){
        $url = 'https://apis.map.qq.com/ws/geocoder/v1/?key='.$this->key.'&location='.$lat.','.$lng;
        try{
            $response = file_get_contents($url);
            $resObj =  json_decode($response,true);
            if(isset($resObj['status']) && $resObj['status'] == 0){
                $result = [
                    'adcode'=>$resObj['result']['ad_info']['adcode'],
                    'province'=>$resObj['result']['address_component']['province'],
                    'city'=>$resObj['result']['address_component']['city'],
                    'district'=>$resObj['result']['address_component']['district'],
                    'address' => $resObj['result']['address'],
                ];
                return ['code'=>200,'msg'=>'success','data'=>$result];
            }else{
                return ['code'=>500,'msg'=>isset($resObj['msg'])?$resObj['msg']:'unknow error'];
            }
        }catch (\Exception $e){
            return ['code'=>500,'msg'=>$e->getMessage()];
        }
    }
}