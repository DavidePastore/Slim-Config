<?php

namespace DavidePastore\Slim\Config;

/**
 * Config for Slim.
 */
class Config
{
    /**
     * The \Noodlehaus\Config object.
     *
     * @var \Noodlehaus\Config
     */
    protected $config;

    /**
     * The input for the config object.
     *
     * @var string|array
     */
    protected $configInput;

    /**
     * Create new Config service provider.
     *
     * @param string|array|ArrayAccess $configInput
     */
    public function __construct($configInput)
    {
        $this->configInput = $configInput;
    }

    /**
     * Config middleware invokable class.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $this->config = new \Noodlehaus\Config($this->configInput);

        return $next($request, $response);
    }

    /**
     * Get the config object.
     *
     * @return \Noodlehaus\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config.
     *
     * @param \Noodlehaus\Config $config The validators array.
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * Get config input.
     *
     * @return string|array|ArrayAccess The config input.
     */
    public function getConfigInput()
    {
        return $this->configInput;
    }
}
