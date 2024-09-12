<?php

namespace App\Tests\Application\Controller\Word;

use App\Entity\Word;
use App\Enum\DialectEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetTest extends WebTestCase
{
    use ResetDatabase;
    public function testGetWord(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $expectedResponse = [
            "name" => "Chip",
            "dialect" => "UK",
            "explanation" => "a long thin piece of potato fried in oil or fat",
            "pronunciation" => "/tʃɪp/",
            "id" => 1
        ];

        $word = new Word();
        $word->setName('Chip');
        $word->setDialect(DialectEnum::UK);
        $word->setExplanation('a long thin piece of potato fried in oil or fat');
        $word->setPronunciation('/tʃɪp/');

        $entityManager->persist($word);
        $entityManager->flush($word);

        $client->request('GET','/word/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResponse, json_decode($client->getResponse()->getContent(), true));
    }
}
