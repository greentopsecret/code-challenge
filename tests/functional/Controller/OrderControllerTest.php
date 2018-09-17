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

        $this->assertEquals(
            'order[description]',
            $accessor->getValue($data, '[form][children][description][vars][full_name]')
        );

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

        $this->assertTrue($accessor->isReadable($data, '[form][children][service]'));
        $this->assertTrue($accessor->isReadable($data, '[form][children][city]'));


        [
            'form' =>
                [
                    'vars' =>
                        [
                            'attr' =>
                                [],
                            'id' => 'order',
                            'name' => 'order',
                            'full_name' => 'order',
                            'disabled' => false,
                            'multipart' => false,
                            'block_prefixes' =>
                                [
                                    0 => 'form',
                                    1 => 'order',
                                    2 => '_order',
                                ],
                            'unique_block_prefix' => '_order',
                            'cache_key' => '_order_order',
                            'errors' =>
                                [
                                    'form' =>
                                        [
                                            'children' =>
                                                [
                                                    'description' =>
                                                        [],
                                                    'executionDate' =>
                                                        [
                                                            'children' =>
                                                                [
                                                                    'year' =>
                                                                        [],
                                                                    'month' =>
                                                                        [],
                                                                    'day' =>
                                                                        [],
                                                                ],
                                                        ],
                                                    'service' =>
                                                        [],
                                                    'city' =>
                                                        [],
                                                ],
                                        ],
                                    'errors' =>
                                        [],
                                ],
                            'valid' => true,
                            'required' => true,
                            'label_attr' =>
                                [],
                            'compound' => true,
                            'method' => 'POST',
                            'action' => '',
                            'submitted' => false,
                        ],
                    'children' =>
                        [
                            'description' =>
                                [
                                    'vars' =>
                                        [
                                            'value' => '',
                                            'attr' =>
                                                [],
                                            'id' => 'order_description',
                                            'name' => 'description',
                                            'full_name' => 'order[description]',
                                            'disabled' => false,
                                            'multipart' => false,
                                            'block_prefixes' =>
                                                [
                                                    0 => 'form',
                                                    1 => 'text',
                                                    2 => 'textarea',
                                                    3 => '_order_description',
                                                ],
                                            'unique_block_prefix' => '_order_description',
                                            'cache_key' => '_order_description_textarea',
                                            'errors' =>
                                                [
                                                    'form' =>
                                                        [],
                                                    'errors' =>
                                                        [],
                                                ],
                                            'valid' => true,
                                            'required' => true,
                                            'label_attr' =>
                                                [],
                                            'compound' => false,
                                            'method' => 'POST',
                                            'action' => '',
                                            'submitted' => false,
                                        ],
                                    'children' =>
                                        [],
                                    'rendered' => false,
                                    'method_rendered' => false,
                                ],
                            'executionDate' =>
                                [
                                    'vars' =>
                                        [
                                            'value' =>
                                                [
                                                    'year' => '',
                                                    'month' => '',
                                                    'day' => '',
                                                ],
                                            'attr' =>
                                                [],
                                            'id' => 'order_executionDate',
                                            'name' => 'executionDate',
                                            'full_name' => 'order[executionDate]',
                                            'disabled' => false,
                                            'multipart' => false,
                                            'block_prefixes' =>
                                                [
                                                    0 => 'form',
                                                    1 => 'date',
                                                    2 => '_order_executionDate',
                                                ],
                                            'unique_block_prefix' => '_order_executionDate',
                                            'cache_key' => '_order_executionDate_date',
                                            'errors' =>
                                                [
                                                    'form' =>
                                                        [
                                                            'children' =>
                                                                [
                                                                    'year' =>
                                                                        [],
                                                                    'month' =>
                                                                        [],
                                                                    'day' =>
                                                                        [],
                                                                ],
                                                        ],
                                                    'errors' =>
                                                        [],
                                                ],
                                            'valid' => true,
                                            'required' => true,
                                            'label_attr' =>
                                                [],
                                            'compound' => true,
                                            'method' => 'POST',
                                            'action' => '',
                                            'submitted' => false,
                                            'widget' => 'choice',
                                            'date_pattern' => '{{ month }}{{ day }}{{ year }}',
                                        ],
                                    'children' =>
                                        [
                                            'year' =>
                                                [
                                                    'vars' =>
                                                        [
                                                            'value' => '',
                                                            'attr' =>
                                                                [],
                                                            'id' => 'order_executionDate_year',
                                                            'name' => 'year',
                                                            'full_name' => 'order[executionDate][year]',
                                                            'disabled' => false,
                                                            'multipart' => false,
                                                            'block_prefixes' =>
                                                                [
                                                                    0 => 'form',
                                                                    1 => 'choice',
                                                                    2 => '_order_executionDate_year',
                                                                ],
                                                            'unique_block_prefix' => '_order_executionDate_year',
                                                            'cache_key' => '_order_executionDate_year_choice',
                                                            'errors' =>
                                                                [
                                                                    'form' =>
                                                                        [],
                                                                    'errors' =>
                                                                        [],
                                                                ],
                                                            'valid' => true,
                                                            'data' => '',
                                                            'required' => true,
                                                            'label_attr' =>
                                                                [],
                                                            'compound' => false,
                                                            'method' => 'POST',
                                                            'action' => '',
                                                            'submitted' => false,
                                                            'multiple' => false,
                                                            'expanded' => false,
                                                            'preferred_choices' =>
                                                                [],
                                                            'choices' =>
                                                                [
                                                                    0 =>
                                                                        [
                                                                            'label' => '2013',
                                                                            'value' => '2013',
                                                                            'data' => 2013,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    1 =>
                                                                        [
                                                                            'label' => '2014',
                                                                            'value' => '2014',
                                                                            'data' => 2014,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    2 =>
                                                                        [
                                                                            'label' => '2015',
                                                                            'value' => '2015',
                                                                            'data' => 2015,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    3 =>
                                                                        [
                                                                            'label' => '2016',
                                                                            'value' => '2016',
                                                                            'data' => 2016,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    4 =>
                                                                        [
                                                                            'label' => '2017',
                                                                            'value' => '2017',
                                                                            'data' => 2017,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    5 =>
                                                                        [
                                                                            'label' => '2018',
                                                                            'value' => '2018',
                                                                            'data' => 2018,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    6 =>
                                                                        [
                                                                            'label' => '2019',
                                                                            'value' => '2019',
                                                                            'data' => 2019,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    7 =>
                                                                        [
                                                                            'label' => '2020',
                                                                            'value' => '2020',
                                                                            'data' => 2020,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    8 =>
                                                                        [
                                                                            'label' => '2021',
                                                                            'value' => '2021',
                                                                            'data' => 2021,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    9 =>
                                                                        [
                                                                            'label' => '2022',
                                                                            'value' => '2022',
                                                                            'data' => 2022,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    10 =>
                                                                        [
                                                                            'label' => '2023',
                                                                            'value' => '2023',
                                                                            'data' => 2023,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                ],
                                                            'separator' => '-------------------',
                                                            'choice_translation_domain' => false,
                                                            'is_selected' =>
                                                                [],
                                                            'placeholder_in_choices' => false,
                                                        ],
                                                    'children' =>
                                                        [],
                                                    'rendered' => false,
                                                    'method_rendered' => false,
                                                ],
                                            'month' =>
                                                [
                                                    'vars' =>
                                                        [
                                                            'value' => '',
                                                            'attr' =>
                                                                [],
                                                            'id' => 'order_executionDate_month',
                                                            'name' => 'month',
                                                            'full_name' => 'order[executionDate][month]',
                                                            'disabled' => false,
                                                            'multipart' => false,
                                                            'block_prefixes' =>
                                                                [
                                                                    0 => 'form',
                                                                    1 => 'choice',
                                                                    2 => '_order_executionDate_month',
                                                                ],
                                                            'unique_block_prefix' => '_order_executionDate_month',
                                                            'cache_key' => '_order_executionDate_month_choice',
                                                            'errors' =>
                                                                [
                                                                    'form' =>
                                                                        [],
                                                                    'errors' =>
                                                                        [],
                                                                ],
                                                            'valid' => true,
                                                            'data' => '',
                                                            'required' => true,
                                                            'label_attr' =>
                                                                [],
                                                            'compound' => false,
                                                            'method' => 'POST',
                                                            'action' => '',
                                                            'submitted' => false,
                                                            'multiple' => false,
                                                            'expanded' => false,
                                                            'preferred_choices' =>
                                                                [],
                                                            'choices' =>
                                                                [
                                                                    0 =>
                                                                        [
                                                                            'label' => 'Jan',
                                                                            'value' => '1',
                                                                            'data' => 1,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    1 =>
                                                                        [
                                                                            'label' => 'Feb',
                                                                            'value' => '2',
                                                                            'data' => 2,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    2 =>
                                                                        [
                                                                            'label' => 'Mar',
                                                                            'value' => '3',
                                                                            'data' => 3,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    3 =>
                                                                        [
                                                                            'label' => 'Apr',
                                                                            'value' => '4',
                                                                            'data' => 4,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    4 =>
                                                                        [
                                                                            'label' => 'May',
                                                                            'value' => '5',
                                                                            'data' => 5,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    5 =>
                                                                        [
                                                                            'label' => 'Jun',
                                                                            'value' => '6',
                                                                            'data' => 6,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    6 =>
                                                                        [
                                                                            'label' => 'Jul',
                                                                            'value' => '7',
                                                                            'data' => 7,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    7 =>
                                                                        [
                                                                            'label' => 'Aug',
                                                                            'value' => '8',
                                                                            'data' => 8,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    8 =>
                                                                        [
                                                                            'label' => 'Sep',
                                                                            'value' => '9',
                                                                            'data' => 9,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    9 =>
                                                                        [
                                                                            'label' => 'Oct',
                                                                            'value' => '10',
                                                                            'data' => 10,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    10 =>
                                                                        [
                                                                            'label' => 'Nov',
                                                                            'value' => '11',
                                                                            'data' => 11,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    11 =>
                                                                        [
                                                                            'label' => 'Dec',
                                                                            'value' => '12',
                                                                            'data' => 12,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                ],
                                                            'separator' => '-------------------',
                                                            'choice_translation_domain' => false,
                                                            'is_selected' =>
                                                                [],
                                                            'placeholder_in_choices' => false,
                                                        ],
                                                    'children' =>
                                                        [],
                                                    'rendered' => false,
                                                    'method_rendered' => false,
                                                ],
                                            'day' =>
                                                [
                                                    'vars' =>
                                                        [
                                                            'value' => '',
                                                            'attr' =>
                                                                [],
                                                            'id' => 'order_executionDate_day',
                                                            'name' => 'day',
                                                            'full_name' => 'order[executionDate][day]',
                                                            'disabled' => false,
                                                            'multipart' => false,
                                                            'block_prefixes' =>
                                                                [
                                                                    0 => 'form',
                                                                    1 => 'choice',
                                                                    2 => '_order_executionDate_day',
                                                                ],
                                                            'unique_block_prefix' => '_order_executionDate_day',
                                                            'cache_key' => '_order_executionDate_day_choice',
                                                            'errors' =>
                                                                [
                                                                    'form' =>
                                                                        [],
                                                                    'errors' =>
                                                                        [],
                                                                ],
                                                            'valid' => true,
                                                            'data' => '',
                                                            'required' => true,
                                                            'label_attr' =>
                                                                [],
                                                            'compound' => false,
                                                            'method' => 'POST',
                                                            'action' => '',
                                                            'submitted' => false,
                                                            'multiple' => false,
                                                            'expanded' => false,
                                                            'preferred_choices' =>
                                                                [],
                                                            'choices' =>
                                                                [
                                                                    0 =>
                                                                        [
                                                                            'label' => '1',
                                                                            'value' => '1',
                                                                            'data' => 1,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    1 =>
                                                                        [
                                                                            'label' => '2',
                                                                            'value' => '2',
                                                                            'data' => 2,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    2 =>
                                                                        [
                                                                            'label' => '3',
                                                                            'value' => '3',
                                                                            'data' => 3,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    3 =>
                                                                        [
                                                                            'label' => '4',
                                                                            'value' => '4',
                                                                            'data' => 4,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    4 =>
                                                                        [
                                                                            'label' => '5',
                                                                            'value' => '5',
                                                                            'data' => 5,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    5 =>
                                                                        [
                                                                            'label' => '6',
                                                                            'value' => '6',
                                                                            'data' => 6,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    6 =>
                                                                        [
                                                                            'label' => '7',
                                                                            'value' => '7',
                                                                            'data' => 7,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    7 =>
                                                                        [
                                                                            'label' => '8',
                                                                            'value' => '8',
                                                                            'data' => 8,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    8 =>
                                                                        [
                                                                            'label' => '9',
                                                                            'value' => '9',
                                                                            'data' => 9,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    9 =>
                                                                        [
                                                                            'label' => '10',
                                                                            'value' => '10',
                                                                            'data' => 10,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    10 =>
                                                                        [
                                                                            'label' => '11',
                                                                            'value' => '11',
                                                                            'data' => 11,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    11 =>
                                                                        [
                                                                            'label' => '12',
                                                                            'value' => '12',
                                                                            'data' => 12,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    12 =>
                                                                        [
                                                                            'label' => '13',
                                                                            'value' => '13',
                                                                            'data' => 13,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    13 =>
                                                                        [
                                                                            'label' => '14',
                                                                            'value' => '14',
                                                                            'data' => 14,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    14 =>
                                                                        [
                                                                            'label' => '15',
                                                                            'value' => '15',
                                                                            'data' => 15,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    15 =>
                                                                        [
                                                                            'label' => '16',
                                                                            'value' => '16',
                                                                            'data' => 16,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    16 =>
                                                                        [
                                                                            'label' => '17',
                                                                            'value' => '17',
                                                                            'data' => 17,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    17 =>
                                                                        [
                                                                            'label' => '18',
                                                                            'value' => '18',
                                                                            'data' => 18,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    18 =>
                                                                        [
                                                                            'label' => '19',
                                                                            'value' => '19',
                                                                            'data' => 19,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    19 =>
                                                                        [
                                                                            'label' => '20',
                                                                            'value' => '20',
                                                                            'data' => 20,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    20 =>
                                                                        [
                                                                            'label' => '21',
                                                                            'value' => '21',
                                                                            'data' => 21,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    21 =>
                                                                        [
                                                                            'label' => '22',
                                                                            'value' => '22',
                                                                            'data' => 22,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    22 =>
                                                                        [
                                                                            'label' => '23',
                                                                            'value' => '23',
                                                                            'data' => 23,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    23 =>
                                                                        [
                                                                            'label' => '24',
                                                                            'value' => '24',
                                                                            'data' => 24,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    24 =>
                                                                        [
                                                                            'label' => '25',
                                                                            'value' => '25',
                                                                            'data' => 25,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    25 =>
                                                                        [
                                                                            'label' => '26',
                                                                            'value' => '26',
                                                                            'data' => 26,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    26 =>
                                                                        [
                                                                            'label' => '27',
                                                                            'value' => '27',
                                                                            'data' => 27,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    27 =>
                                                                        [
                                                                            'label' => '28',
                                                                            'value' => '28',
                                                                            'data' => 28,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    28 =>
                                                                        [
                                                                            'label' => '29',
                                                                            'value' => '29',
                                                                            'data' => 29,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    29 =>
                                                                        [
                                                                            'label' => '30',
                                                                            'value' => '30',
                                                                            'data' => 30,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                    30 =>
                                                                        [
                                                                            'label' => '31',
                                                                            'value' => '31',
                                                                            'data' => 31,
                                                                            'attr' =>
                                                                                [],
                                                                        ],
                                                                ],
                                                            'separator' => '-------------------',
                                                            'choice_translation_domain' => false,
                                                            'is_selected' =>
                                                                [],
                                                            'placeholder_in_choices' => false,
                                                        ],
                                                    'children' =>
                                                        [],
                                                    'rendered' => false,
                                                    'method_rendered' => false,
                                                ],
                                        ],
                                    'rendered' => false,
                                    'method_rendered' => false,
                                ],
                            'service' =>
                                [
                                    'vars' =>
                                        [
                                            'value' => '',
                                            'attr' =>
                                                [],
                                            'id' => 'order_service',
                                            'name' => 'service',
                                            'full_name' => 'order[service]',
                                            'disabled' => false,
                                            'multipart' => false,
                                            'block_prefixes' =>
                                                [
                                                    0 => 'form',
                                                    1 => 'choice',
                                                    2 => 'entity',
                                                    3 => '_order_service',
                                                ],
                                            'unique_block_prefix' => '_order_service',
                                            'cache_key' => '_order_service_entity',
                                            'errors' =>
                                                [
                                                    'form' =>
                                                        [],
                                                    'errors' =>
                                                        [],
                                                ],
                                            'valid' => true,
                                            'required' => true,
                                            'label_attr' =>
                                                [],
                                            'compound' => false,
                                            'method' => 'POST',
                                            'action' => '',
                                            'submitted' => false,
                                            'multiple' => false,
                                            'expanded' => false,
                                            'preferred_choices' =>
                                                [],
                                            'choices' =>
                                                [],
                                            'separator' => '-------------------',
                                            'choice_translation_domain' => false,
                                            'is_selected' =>
                                                [],
                                            'placeholder_in_choices' => false,
                                        ],
                                    'children' =>
                                        [],
                                    'rendered' => false,
                                    'method_rendered' => false,
                                ],
                            'city' =>
                                [
                                    'vars' =>
                                        [
                                            'value' => '',
                                            'attr' =>
                                                [],
                                            'id' => 'order_city',
                                            'name' => 'city',
                                            'full_name' => 'order[city]',
                                            'disabled' => false,
                                            'multipart' => false,
                                            'block_prefixes' =>
                                                [
                                                    0 => 'form',
                                                    1 => 'choice',
                                                    2 => 'entity',
                                                    3 => '_order_city',
                                                ],
                                            'unique_block_prefix' => '_order_city',
                                            'cache_key' => '_order_city_entity',
                                            'errors' =>
                                                [
                                                    'form' =>
                                                        [],
                                                    'errors' =>
                                                        [],
                                                ],
                                            'valid' => true,
                                            'required' => true,
                                            'label_attr' =>
                                                [],
                                            'compound' => false,
                                            'method' => 'POST',
                                            'action' => '',
                                            'submitted' => false,
                                            'multiple' => false,
                                            'expanded' => false,
                                            'preferred_choices' =>
                                                [],
                                            'choices' =>
                                                [],
                                            'separator' => '-------------------',
                                            'choice_translation_domain' => false,
                                            'is_selected' =>
                                                [],
                                            'placeholder_in_choices' => false,
                                        ],
                                    'children' =>
                                        [],
                                    'rendered' => false,
                                    'method_rendered' => false,
                                ],
                            '_token' =>
                                [
                                    'vars' =>
                                        [
                                            'value' => 'Pb8pqlGL7B6zzR1xzVSPWJRkvYgTDc6WrCsX0z9vOfk',
                                            'attr' =>
                                                [],
                                            'id' => 'order__token',
                                            'name' => '_token',
                                            'full_name' => 'order[_token]',
                                            'disabled' => false,
                                            'multipart' => false,
                                            'block_prefixes' =>
                                                [
                                                    0 => 'form',
                                                    1 => 'hidden',
                                                    2 => '_order__token',
                                                ],
                                            'unique_block_prefix' => '_order__token',
                                            'cache_key' => '_order__token_hidden',
                                            'errors' =>
                                                [
                                                    'form' =>
                                                        [],
                                                    'errors' =>
                                                        [],
                                                ],
                                            'valid' => true,
                                            'data' => 'Pb8pqlGL7B6zzR1xzVSPWJRkvYgTDc6WrCsX0z9vOfk',
                                            'required' => false,
                                            'label_attr' =>
                                                [],
                                            'compound' => false,
                                            'method' => 'POST',
                                            'action' => '',
                                            'submitted' => false,
                                        ],
                                    'children' =>
                                        [],
                                    'rendered' => false,
                                    'method_rendered' => false,
                                ],
                        ],
                    'rendered' => false,
                    'method_rendered' => false,
                ],
        ];
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
