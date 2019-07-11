<?php


use PHPUnit\Framework\TestCase;
use think\Container;

class Bind
{

}

class AliasTest   extends TestCase
{
    
    public function testAlias()
    {
        $container = new Container();
        $container->bind('bind', Bind::class);
        $container->alias('bind1', 'bind');
        self::assertEquals($container->make('bind1'), new Bind());
    }
}
