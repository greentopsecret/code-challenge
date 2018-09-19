<?php

namespace Tests\Functional\Controller;

use App\Entity\City;
use App\Entity\Service;
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
        $this->client = self::createClient();

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

//        @TODO: rewrite that test (assertArraySubset)
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

    public function testPostSuccess()
    {
//        $csrfToken = $this->client->getContainer()->get('security.csrf.token_generator')->generateToken();
        $this->client->request(
            'POST',
            '/api/orders/',
            [
                'order' => [
                    'description' => 'asdasd',
                    'executionDate' => 10,
                    'service' => $this->getService()->getId(),
                    'city' => $this->getCity()->getZip(),
//                    '_token' => $csrfToken,
                ],
            ]
        );
        $response = $this->client->getResponse();

        $this->assertEquals(201, $response->getStatusCode()); // Response::HTTP_CREATED

        $this->assertEmpty($response->getContent());
        $this->assertRegExp('/http:\/\/localhost\/api\/orders\/\d+/', $response->headers->get('Location'));
    }

    public function testPostFail()
    {
        $this->client->request('POST', '/api/orders/');
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);
        $this->assertArraySubset(
            [
                'error' => [
                    'code' => 400,
                    'message' => 'Bad Request',
                ],
            ],
            $data
        );
    }

    /**
     * @return City
     */
    private function getCity()
    {
        $city = $this
            ->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(City::class)
            ->findOneBy([]);

        if (!$city instanceof City) {
            throw new \Exception('Cannot get entity of "City" class. Check whether fixtures were loaded.');
        }

        return $city;
    }

    /**
     * @return Service
     */
    private function getService()
    {
        $service = $this
            ->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Service::class)
            ->findOneBy([]);

        if (!$service instanceof Service) {
            throw new \Exception('Cannot get entity of "Service" class. Check whether fixtures were loaded.');
        }

        return $service;
    }
}
