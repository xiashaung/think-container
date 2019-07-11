<?php


use PHPUnit\Framework\TestCase;
use think\Container;

class Bind
{

}

class AliasTest   extends TestCase
{


    public function testBind()
    {
        $container = new Container();
        $container->bind('bind',Bind::class);
        $container->bind('bind1','bind');
        self::expectExceptionMessage($container->make('bind1'), new Bind());
    }

    public function testAlias()
    {
        $container = new Container();
        $container->bind('bind', Bind::class);
        $container->alias('bind1', 'bind');
        self::assertEquals($container->make('bind1'), new Bind());
    }
}