<?php


namespace Howtec\LbsService\core;

/**
 * 实体化类
 * Class LbsAPP
 * @package howtec\LbsService
 */
class LbsApi
{
    static function createQQLbs($key){
        return new LbsQQ($key);
    }
}