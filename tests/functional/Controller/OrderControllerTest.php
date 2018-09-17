<?php

namespace Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
        $this->client->request('GET', '/api/orders/new');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);

        $accessor = PropertyAccess::createPropertyAccessor();

        $this->assertEquals('order', $accessor->getValue($data, '[form][vars][id]'));
        $this->assertEquals('POST', $accessor->getValue($data, '[form][vars][method]'));
        $this->assertEquals('/api/orders/', $accessor->getValue($data, '[form][vars][action]'));
        $this->assertCount(0, $accessor->getValue($data, '[form][vars][errors][errors]'));
        $this->assertFalse($accessor->getValue($data, '[form][vars][submitted]'));

        $this->assertTrue($accessor->isReadable($data, '[form][children]'));
        $this->assertNull($accessor->getValue($data, '[form][children][_token]'));

        /**
         * Check "description" element
         */
        $this->assertEquals(
            'order[description]',
            $accessor->getValue($data, '[form][children][description][vars][full_name]')
        );

        /**
         * Check "executionDate" element
         */
        $this->assertEquals(
            'order[executionDate]',
            $accessor->getValue($data, '[form][children][executionDate][vars][full_name]')
        );
        $this->assertEquals(
            'Zeitnah',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][0][label]')
        );
        $this->assertEquals(
            '10',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][0][value]')
        );
        $this->assertEquals(
            'Innerhalb der nächsten 30 Tage',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][1][label]')
        );
        $this->assertEquals(
            '20',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][1][value]')
        );
        $this->assertEquals(
            'In den nächsten 3 Monaten',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][2][label]')
        );
        $this->assertEquals(
            '23',
            $accessor->getValue($data, '[form][children][executionDate][vars][choices][2][value]')
        );
        // @TODO: add the rest choices


        $this->assertEquals(
            'order[service]',
            $accessor->getValue($data, '[form][children][service][vars][full_name]')
        );
        // @TODO: check choices


        $this->assertEquals(
            'order[city]',
            $accessor->getValue($data, '[form][children][city][vars][full_name]')
        );
        // @TODO: check choices
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
