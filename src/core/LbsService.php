<?php

namespace Howtec\LbsService\core;


interface LbsService
{
    /**
     * 获取省市区列表
     * @return mixed
     */
    public function getDistrict();

    /**
     * 获取下级行政区划列表
     * @return mixed
     */
    public function getDistrictChildren($pid);

    /**
     * 搜索行政区划
     * @param $keyword
     * @return mixed
     */
    public function searchDistrict($keyword);

    /**
     * 根据经纬度进行逆地址解析
     * @param $lng  经度
     * @param $lat  纬度
     * @return mixed
     */
    public function getCoderByLocation($lng,$lat);
}