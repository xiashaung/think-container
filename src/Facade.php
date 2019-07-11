<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace think;

/**
 * Facade管理类
 */
abstract class Facade
{
    /**
     * 始终创建新的对象实例
     * @var bool
     */
    protected static $alwaysNewInstance;

    /**
     * 创建Facade实例
     * @static
     * @access protected
     * @param  string $className       类名或标识
     * @param  array  $args        变量
     * @param  bool $new 是否每次创建新的实例
     * @return object
     */
    protected static function createFacade(string $className = '', array $args = [], bool $new = false)
    {
        $class = $className ?: static::class;

        $facadeClass = static::getFacadeClass();

        if ($facadeClass) {
            $class = $facadeClass;
        }

        if (static::$alwaysNewInstance) {
            $new = true;
        }

        return Container::getInstance()->make($class, $args, $new);
    }

    /**
     * 获取当前Facade对应类名
     * @access protected
     * @return string|mixed
     */
    abstract protected static function getFacadeClass();

    /**
     * 带参数实例化当前Facade类
     * @access public
     * @param $args array
     * @return object
     */
    public static function instance(...$args)
    {
        return self::createFacade('', $args);
    }

    /**
     * 调用类的实例
     * @access public
     * @param  string     $class       类名或者标识
     * @param  array|true $args        变量
     * @param  bool       $newInstance 是否每次创建新的实例
     * @return object
     */
    public static function make(string $class, $args = [], $newInstance = false)
    {
        if (__CLASS__ != static::class) {
            return self::__callStatic('make', func_get_args());
        }

        if (true === $args) {
            // 总是创建新的实例化对象
            $newInstance = true;
            $args        = [];
        }

        return self::createFacade($class, $args, $newInstance);
    }

    // 调用实际类的方法
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([static::createFacade(), $method], $params);
    }
}
