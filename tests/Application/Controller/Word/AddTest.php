<?php

namespace App\Tests\Application\Controller\Word;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class AddTest extends WebTestCase
{
    use InteractsWithMessenger, ResetDatabase;
    public function testAddWord(): void
    {
        $requestBody = [
            "name" => "chip",
            "dialect" => "general",
            "explanation" => "a long thin piece of potato fried in oil or fat",
            "pronunciation" => "/tʃɪp/"
        ];

        $expectedResponse = [
            "name" => "chip",
            "dialect" => "general",
            "explanation" => "a long thin piece of potato fried in oil or fat",
            "pronunciation" => "/tʃɪp/",
            "id" => 1
        ];

        $client = static::createClient();

        $client->request(
            'POST',
            '/word',
            $requestBody,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $this->transport('async')->queue()->assertCount(1);
        $this->transport('async')->process(1);
        $this->transport('async')->queue()->assertCount(0);

        $client->request(
            'GET',
            '/word/1',
            $requestBody,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResponse, json_decode($client->getResponse()->getContent(), true));

    }
}
