<?php

namespace JTDSoft\EssentialsSdk;

use GuzzleHttp\Client as Guzzle;
use JTDSoft\EssentialsSdk\Service\DefaultRequestData;
use JTDSoft\EssentialsSdk\Service\SupportsHeaders;

/**
 * Class Service
 *
 * @package JTDSoft\EssentialsSdk\Services
 */
class Service extends Config
{
    use SupportsHeaders,
        DefaultRequestData;

    /**
     * @param            $method
     * @param array|null $request
     *
     * @return mixed
     */
    final public function get($method, array $request = null)
    {
        return $this->call('get', $method, $request);
    }

    /**
     * @param       $verb
     * @param       $method
     * @param array $request
     *
     * @return mixed
     * @throws \JTDSoft\EssentialsSdk\Exceptions\ErrorException
     * @throws \JTDSoft\EssentialsSdk\Exceptions\ResponseException
     * @throws \JTDSoft\EssentialsSdk\Exceptions\ServerException
     * @throws \JTDSoft\EssentialsSdk\Exceptions\UnauthorizedException
     */
    final protected function call($verb, $method, array $request = null)
    {
        if (is_null($request)) {
            $request = [];
        }

        $this->prepareHeaders();

        $request = $this->prepareRequest($request);

        $client = new GuzzleClient(new Guzzle([
            'proxy'  => static::getProxy(),
            'verify' => static::verify(),
        ]));

        return $client->request(
            $verb,
            $this->getUrl($method),
            $request,
            $this->getHeaders()
        );
    }

    /**
     * @param string $method
     *
     * @return string
     */
    protected function getUrl($method)
    {
        $endpoint = sprintf(
            '%s://%s/',
            static::getProtocol(),
            static::getEndpoint(),
            $method
        );

        return $endpoint;
    }

    /**
     * @param            $method
     * @param array|null $request
     *
     * @return mixed
     */
    final public function post($method, array $request = null)
    {
        return $this->call('post', $method, $request);
    }

    /**
     * @param            $method
     * @param array|null $request
     *
     * @return mixed
     */
    final public function put($method, array $request = null)
    {
        return $this->call('put', $method, $request);
    }

    /**
     * @param            $method
     * @param array|null $request
     *
     * @return mixed
     */
    final public function patch($method, array $request = null)
    {
        return $this->call('patch', $method, $request);
    }

    /**
     * @param            $method
     * @param array|null $request
     *
     * @return mixed
     */
    final public function delete($method, array $request = null)
    {
        return $this->call('delete', $method, $request);
    }
}
