<?php

namespace DavidePastore\Slim\Config\Tests;

use Slim\Http\Body;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use DavidePastore\Slim\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PSR7 request object.
     *
     * @var Psr\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * PSR7 response object.
     *
     * @var Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Run before each test.
     */
    public function setUp()
    {
        $uri = Uri::createFromString('https://example.com:443/foo/bar');
        $headers = new Headers();
        $cookies = [];
        $env = Environment::mock();
        $serverParams = $env->all();
        $body = new Body(fopen('php://temp', 'r+'));
        $this->request = new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
        $this->response = new Response();
    }

    public function testConfig()
    {
        $mw = new Config(__DIR__.'/mocks/config.json');

        $next = function ($req, $res) {
            return $res;
        };

        $response = $mw($this->request, $this->response, $next);
        $config = $mw->getConfig();

        $this->assertEquals($config['application.name'], 'configuration');
        $expected = [
          'host1',
          'host2',
          'host3',
        ];
        $this->assertEquals($config['servers'], $expected);
    }

    public function testSetConfig()
    {
        $mw = new Config(__DIR__.'/mocks/config.json');

        $next = function ($req, $res) {
            return $res;
        };

        $response = $mw($this->request, $this->response, $next);
        $mw->setConfig(new \Noodlehaus\Config(__DIR__.'/mocks/set_config.json'));
        $config = $mw->getConfig();

        $this->assertEquals($config['application.name'], 'set_configuration');
    }

    public function testSetConfigInput()
    {
        $expected = __DIR__.'/mocks/config.json';
        $mw = new Config($expected);

        $next = function ($req, $res) {
            return $res;
        };

        $response = $mw($this->request, $this->response, $next);
        $configInput = $mw->getConfigInput();
        $this->assertEquals($configInput, $expected);
    }
}
