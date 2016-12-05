<?php

class DeCaptchaAbstractTest extends PHPUnit_Framework_TestCase
{
    public function testGetBaseUrl()
    {
        $abstract = $this->getMockForAbstractClass(\jumper423\decaptcha\core\DeCaptchaAbstract::class);
//        $foo->expects($this->any())
//            ->method("baz")
//            ->will($this->returnValue("You called baz!"));
        $getBaseUrlCaller = function () {
            return $this->getBaseUrl();
        };
        $abstract->domain = 'domain';
        $bound = $getBaseUrlCaller->bindTo($abstract, $abstract);
        $this->assertEquals('http://domain/', $bound());
    }

    public function testSetApiKey()
    {
        $abstract = $this->getMockForAbstractClass(\jumper423\decaptcha\core\DeCaptchaAbstract::class);
        $abstract->setApiKey('123456val');
        $apiKeyValCaller = function () {
            return $this->apiKey;
        };
        $bound = $apiKeyValCaller->bindTo($abstract, $abstract);
        $this->assertEquals('123456val', $bound());

        $abstract->setApiKey(function () {
            return '123456' . 'fun';
        });
        $apiKeyFunCaller = function () {
            return $this->apiKey;
        };
        $bound = $apiKeyFunCaller->bindTo($abstract, $abstract);
        $this->assertEquals('123456fun', $bound());
    }

    public function testGetActionUrl()
    {
        $abstract = $this->getMockForAbstractClass(\jumper423\decaptcha\core\DeCaptchaAbstract::class);
        $getBaseUrlGetCodeCaller = function () {
            $this->captchaId = 123;
            return $this->getActionUrl('get_code');
        };
        $getBaseUrlGetBalanceCaller = function () {
            $this->captchaId = 234;
            return $this->getActionUrl('get_balance');
        };
        $abstract->domain = 'domain';
        $abstract->setApiKey('123456');
        $bound = $getBaseUrlGetCodeCaller->bindTo($abstract, $abstract);
        $this->assertEquals('http://domain/res.php?key=123456&action=get_code&id=123', $bound());
        $bound = $getBaseUrlGetBalanceCaller->bindTo($abstract, $abstract);
        $this->assertEquals('http://domain/res.php?key=123456&action=get_balance&id=234', $bound());
    }
}