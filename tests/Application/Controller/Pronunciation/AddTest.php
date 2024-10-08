<?php

namespace App\Tests\Application\Controller\Pronunciation;

use App\Entity\Word;
use App\Enum\DialectEnum;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class AddTest extends WebTestCase
{
    use InteractsWithMessenger, ResetDatabase;
    public function testAddPronunciation(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $fileServiceMock = $this->createMock(FileService::class);
        $fileServiceMock->method('addFile')
            ->willReturn('fileintest.mp3');

        $client->getContainer()->set(FileService::class, $fileServiceMock);
        $requestBody = [
            "voice" => "",
            "dialect" => "UK",
            "source" => "dictionary",
            "path" => "chip.mp3",
            "phonetically" => "/fraɪ/",
            "wordId" => 1
        ];

        $expectedResponse = [
            "name" => "fry",
            "dialect" => "general",
            "explanation" => "to cook something in hot fat or oil; to be cooked in hot fat or oil",
            "pronunciation" => "/fraɪ/",
            "id" => 1,
            "pronunciations" => [
                [
                    "id" => 1,
                    "dialect" => "UK",
                    "source" => "dictionary",
                    "path" => "fileintest.mp3",
                    "phonetically" => "/fraɪ/",
                    "word" => 1
                ]
            ],
        ];

        $word = new Word();
        $word->setName('fry');
        $word->setDialect(DialectEnum::general);
        $word->setExplanation('to cook something in hot fat or oil; to be cooked in hot fat or oil');
        $word->setPronunciation('/fraɪ/');
        $entityManager->persist($word);

        $uploadedFile = new UploadedFile(
            __DIR__ . '/../../../fixtures/voice/chip.mp3',
            'chip.mp3'
        );

        $client->request(
            'POST',
            '/pronunciation',
            $requestBody,
            ['voice' => $uploadedFile],
            array('CONTENT_TYPE' => 'application/json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

//        $this->transport('async')->queue()->assertCount(1);
//        $this->transport('async')->process(1);
//        $this->transport('async')->queue()->assertCount(0);

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
