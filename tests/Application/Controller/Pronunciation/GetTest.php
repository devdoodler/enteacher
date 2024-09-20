<?php

namespace App\Tests\Application\Controller\Pronunciation;

use App\Entity\Pronunciation;
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
            "id" => 1,
            "pronunciations" => [
                [
                    "id" => 1,
                    "dialect" => "UK",
                    "source" => "dictionary",
                    "path" => "path",
                    "phonetically" => "/tʃɪp/",
                    "word" => 1
                ]
            ],
        ];

        $word = new Word();
        $word->setName('Chip');
        $word->setDialect(DialectEnum::UK);
        $word->setExplanation('a long thin piece of potato fried in oil or fat');
        $word->setPronunciation('/tʃɪp/');
        $entityManager->persist($word);

        $pronunciation = new Pronunciation();
        $pronunciation->setWord($word);
        $pronunciation->setDialect(DialectEnum::UK);
        $pronunciation->setPath('path');
        $pronunciation->setSource('dictionary');
        $pronunciation->setPhonetically('/tʃɪp/');
        $word->addPronunciation($pronunciation);
        $entityManager->persist($pronunciation);
        $entityManager->flush();


        $client->request('GET','/word/1');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($expectedResponse, json_decode($client->getResponse()->getContent(), true));
    }
}
