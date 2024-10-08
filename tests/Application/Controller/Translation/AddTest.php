<?php

namespace App\Tests\Application\Controller\Translation;

use App\Entity\Word;
use App\Enum\DialectEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class AddTest extends WebTestCase
{
    use InteractsWithMessenger, ResetDatabase;
    public function testAddTranslation(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $word = new Word();
        $word->setName('Chip');
        $word->setDialect(DialectEnum::UK);
        $word->setExplanation('a long thin piece of potato fried in oil or fat');
        $word->setPronunciation('/tʃɪp/');
        $entityManager->persist($word);

        $requestBody = [
            "name" => "frytki",
            "wordId" => 1,
            "explanation" => "tak, to frytki"
        ];

        $client->request(
            'POST',
            '/translation',
            $requestBody,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}
