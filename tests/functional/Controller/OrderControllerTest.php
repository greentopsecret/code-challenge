<?php

namespace Tests\Functional\Controller;

use App\Entity\City;
use App\Entity\Order;
use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * !important: if you wander why that test throws a notice "Doctrine\Common\ClassLoader is deprecated." check https://github.com/symfony/symfony/issues/28119 .
 *
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

        $this->assertArraySubset(
            [
                'form' => [
                    'vars' => [
                        'name' => 'order',
                        'errors' => [
                            'form' => [
                                'children' => [
                                    'description' => [],
                                    'title' => [],
                                    'executionDate' => [],
                                    'service' => [],
                                    'city' => [],
                                ],
                            ],
                        ],
                        'method' => 'POST',
                        'action' => '/api/orders/',
                    ],
                    'children' => [
                        'description' => [
                            'vars' => [
                                'value' => '',
                                'name' => 'description',
                            ],
                        ],
                        'title' => [
                            'vars' => [
                                'value' => '',
                                'name' => 'title',
                            ],
                        ],
                        'executionDate' => [
                            'vars' => [
                                'value' => '',
                                'name' => 'executionDate',
                                'choices' => [
                                    0 => [
                                        'label' => 'Zeitnah',
                                        'value' => '10',
                                    ],
                                    1 => [
                                        'label' => 'Innerhalb der nächsten 30 Tage',
                                        'value' => '20',
                                    ],
                                    2 => [
                                        'label' => 'In den nächsten 3 Monaten',
                                        'value' => '23',
                                    ],
                                    3 => [
                                        'label' => 'In 3 bis 6 Monaten',
                                        'value' => '25',
                                    ],
                                    4 => [
                                        'label' => 'In mehr als 6 Monaten',
                                        'value' => '27',
                                    ],
                                    5 => [
                                        'label' => 'Wunschtermin: Bitte Datum wählen',
                                        'value' => '30',
                                    ],
                                ],
                            ],
                        ],
                        'service' => [
                            'vars' => [
                                'value' => '',
                                'name' => 'service',
                                'choices' => [
                                    108140 => [
                                        'label' => 'Kellersanierung',
                                        'value' => '108140',
                                    ],
                                    402020 => [
                                        'label' => 'Holzdielen schleifen',
                                        'value' => '402020',
                                    ],
                                    411070 => [
                                        'label' => 'Fensterreinigung',
                                        'value' => '411070',
                                    ],
                                    802030 => [
                                        'label' => 'Abtransport, Entsorgung und Entrümpelung',
                                        'value' => '802030',
                                    ],
                                    804040 => [
                                        'label' => 'Sonstige Umzugsleistungen',
                                        'value' => '804040',
                                    ],
                                ],
                            ],
                        ],
                        'city' => [
                            'vars' => [
                                'value' => '',
                                'name' => 'city',
                                'choices' => [
                                    10115 => [
                                        'label' => 'Berlin',
                                        'value' => '10115',
                                    ],
                                    21521 => [
                                        'label' => 'Hamburg',
                                        'value' => '21521',
                                    ],
                                    32457 => [
                                        'label' => 'Porta Westfalica',
                                        'value' => '32457',
                                    ],
                                    '01623' => [
                                        'label' => 'Lommatzsch',
                                        'value' => '01623',
                                    ],
                                    '06895' => [
                                        'label' => 'Bülzig',
                                        'value' => '06895',
                                    ],
                                    '01612' => [
                                        'label' => 'Diesbar-Seußlitz',
                                        'value' => '01612',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            $data
        );
    }

    public function testPostSuccess()
    {
        $this->client->request(
            'POST',
            '/api/orders/',
            [
                'order' => [
                    'title' => 'title',
                    'description' => 'description',
                    'executionDate' => 10,
                    'service' => $this->getService()->getId(),
                    'city' => $this->getCity()->getZip(),
                ],
            ]
        );
        $response = $this->client->getResponse();

        $this->assertEquals(201, $response->getStatusCode(), $response->getContent()); // Response::HTTP_CREATED

        $this->assertEmpty($response->getContent());
        $this->assertRegExp('/http:\/\/[^\/]+\/api\/orders\/\d+/', $response->headers->get('Location'));
    }

    /**
     * No form was submitted
     */
    public function testPostFailNotSubmitted()
    {
        $this->client->request('POST', '/api/orders/', []);
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);
        $this->assertArraySubset(
            [
                'code' => 400,
                'message' => 'Request does not contain form',
            ],
            $data
        );
    }

    /**
     * No form was submitted
     */
    public function testPostFailInvalidData()
    {
        $this->client->request(
            'POST',
            '/api/orders/',
            [
                'order' => [
                    'title' => 'shrt',
                    'description' => 'description',
                ],
            ]
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);
        $this->assertArraySubset(
            [
                'form' => [
                    'vars' => [
                        'errors' => [
                            'form' => [
                                'children' => [
                                    'title' => [
                                        'errors' => [
                                            'This value is too short. It should have 5 characters or more.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'valid' => false,
                        'data' =>
                            [
                                'title' => 'shrt',
                                'description' => 'description',
                            ],
                    ],
                ],
            ],
            $data
        );
    }

    /**
     * Too long|short title was submitted.
     *
     * @dataProvider dataProviderPatchFail
     */
    public function testPatchFail($title, $error)
    {
        $order = $this->getOrder();
        $this->client->request(
            'POST',
            "/api/orders/{$order->getId()}",
            [
                'order' => [
                    'title' => $title,
                ],
            ]
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);
        $this->assertArraySubset(
            [
                'form' => [
                    'vars' => [
                        'errors' => [
                            'form' => [
                                'children' => [
                                    'title' => [
                                        'errors' => [$error],
                                    ],
                                ],
                            ],
                        ],
                        'valid' => false,
                        'data' =>
                            [
                                'title' => $title,
                                'description' => $order->getDescription(),
                            ],
                    ],
                ],
            ],
            $data
        );
    }

    public function dataProviderPatchFail()
    {
        return [
            ['shrt', 'This value is too short. It should have 5 characters or more.'],
            [
                'long long long long long long long long long long long',
                'This value is too long. It should have 50 characters or less.',
            ],
        ];
    }

    public function testPatchSuccess()
    {
        $order = $this->getOrder();
        $newTitle = 'valid title-'.rand(0, 999);
        $this->client->request(
            'POST',
            "/api/orders/{$order->getId()}",
            [
                'order' => [
                    'title' => $newTitle,
                ],
            ]
        );
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json, 1);
        $this->assertArraySubset(
            [
                'data' =>
                    [
                        'id' => 1,
                        'title' => $newTitle, // that field should be new, the rest should remain untouched.
                        'service' =>
                            [
                                'id' => $order->getService()->getId(),
                                'name' => $order->getService()->getName()
                            ],
                        'city' =>
                            [
                                'id' => $order->getCity()->getId(),
                                'name' => $order->getCity()->getName(),
                                'zip' => $order->getCity()->getZip(),
                            ],
                        'description' => $order->getDescription(),
                        'execution_date' => $order->getExecutionDate(),
                    ],
            ],
            $data
        );
    }

    public function testGetSuccess()
    {
        /**
         * Step 1: create new Order entity via doctrine.
         */
        $city = $this->getCity();
        $service = $this->getService();

        $order = new Order();
        $order->setCity($city);
        $order->setService($service);
        $order->setTitle('some-title');
        $order->setDescription('some-description');
        $order->setExecutionDate(10);

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $manager->persist($order);
        $manager->flush();

        $this->assertGreaterThan(0, $order->getId());

        /**
         * Step 2: request created entity via API
         */
        $this->client->request('GET', "/api/orders/{$order->getId()}");
        $response = $this->client->getResponse();

        /**
         * Step 3: check API response
         */
        $json = $response->getContent();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($json);
        $this->assertEquals(
            [
                'data' => [
                    'id' => $order->getId(),
                    'service' => [
                        'id' => $service->getId(),
                        'name' => $service->getName(),
                    ],
                    'city' => [
                        'id' => $city->getId(),
                        'name' => $city->getName(),
                        'zip' => $city->getZip(),
                    ],
                    'description' => $order->getDescription(),
                    'execution_date' => 10,
                    'title' => 'some-title'
                ],
            ],
            json_decode($json, 1)
        );
    }

    public function testGetFailure()
    {
        $id = 100500;
        $this->client->request('GET', "/api/orders/{$id}");
        $response = $this->client->getResponse();

        $json = $response->getContent();
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJson($json);
        $this->assertArraySubset(
            [
                'code' => 404,
                'message' => 'Order#100500 not found',
            ],
            json_decode($json, 1)
        );
    }

    /**
     * @return City
     */
    private function getCity()
    {
        $entity = $this
            ->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(City::class)
            ->findOneBy([]);

        if (!$entity instanceof City) {
            throw new \Exception('Cannot get entity of "City" class.');
        }

        return $entity;
    }

    /**
     * @return Service
     */
    private function getService()
    {
        $entity = $this
            ->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Service::class)
            ->findOneBy([]);

        if (!$entity instanceof Service) {
            throw new \Exception('Cannot get entity of "Service" class.');
        }

        return $entity;
    }

    /**
     * @return Order
     */
    private function getOrder()
    {
        $entity = $this
            ->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Order::class)
            ->findOneBy([]);

        if (!$entity instanceof Order) {
            throw new \Exception('Cannot get entity of "Order" class.');
        }

        return $entity;
    }
}
