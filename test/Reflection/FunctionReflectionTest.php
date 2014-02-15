<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Code\Reflection;

use Zend\Code\Reflection\FunctionReflection;

/**
 * @group      Zend_Reflection
 * @group      Zend_Reflection_Function
 */
class FunctionReflectionTest extends \PHPUnit_Framework_TestCase
{
    public function testParemeterReturn()
    {
        $function = new FunctionReflection('array_splice');
        $parameters = $function->getParameters();
        $this->assertEquals(count($parameters), 4);
        $this->assertInstanceOf('Zend\Code\Reflection\ParameterReflection', array_shift($parameters));
    }

    public function testFunctionDocBlockReturn()
    {
        require_once __DIR__ . '/TestAsset/functions.php';
        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function6');
        $this->assertInstanceOf('Zend\Code\Reflection\DocBlockReflection', $function->getDocBlock());
    }

    public function testGetContentsReturnsEmptyContentsOnEvaldCode()
    {
        $functionName = uniqid('generatedFunction');

        eval('name' . 'space ' . __NAMESPACE__ . '; ' . 'fun' . 'ction ' . $functionName . '()' . '{}');

        $reflectionFunction = new FunctionReflection(__NAMESPACE__ . '\\' . $functionName);

        $this->assertSame('', $reflectionFunction->getContents());
    }

    public function testGetContentsReturnsEmptyContentsOnInternalCode()
    {
        $reflectionFunction = new FunctionReflection('max');

        $this->assertSame('', $reflectionFunction->getContents());
    }
}