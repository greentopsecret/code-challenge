<?php

namespace Tests\Functional\Controller;

use FOS\RestBundle\Tests\Functional\WebTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * @TODO: add fail-scenario tests
 */
class OrderControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = self::createClient(
//            array(
//            'test_case' => 'Basic',
//            'root_config' => 'config.yml',
//            'debug' => false,
//        ), array(
//            'PHP_AUTH_USER' => 'user',
//            'PHP_AUTH_PW' => 'user',
//        )
        );

        parent::setUp();
    }

    public function testNewAction()
    {
        $this->client->get();
    }

//    private function getClient()
//    {
//        return new Client([
//            'base_url' => 'http://localhost:8000', // get from .env
//            'defaults' => [
//                'exceptions' => false
//            ]
//        ]);
//    }
}
