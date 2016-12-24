<?php

namespace Fury473\Bundle\AtarashiiBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AbstractService
 * @author Olivier Haag <olivierhaag92@gmail.com>
 */
class AbstractService
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param ClientException $e
     * @throws HttpException
     */
    public function handleClientException(ClientException $e)
    {
        $statusCode = $e->getResponse()->getStatusCode();
        $message = (string)$e->getResponse()->getBody();
        $headers = $e->getResponse()->getHeaders();
        throw new HttpException($statusCode, $message, $e, $headers);
    }

    /**
     * @param Client $client
     * @return AbstractRestService
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param Serializer $serializer
     * @return AbstractRestService
     */
    public function setSerializer($serializer)
    {
        $this->serializer = $serializer;
        return $this;
    }


}