<?php

namespace App\Tests\Application\Controller\Translation;

use App\Entity\Translation;
use App\Entity\Word;
use App\Entity\WordTranslation;
use App\Enum\DialectEnum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class DeleteTest extends WebTestCase
{
    use InteractsWithMessenger, ResetDatabase;
    public function testDeleteTranslation(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $word = new Word();
        $word->setName('Chip');
        $word->setDialect(DialectEnum::UK);
        $word->setExplanation('a long thin piece of potato fried in oil or fat');
        $word->setPronunciation('/tʃɪp/');
        $entityManager->persist($word);

        $translation = new Translation();
        $translation->setName('Frytki');
        $entityManager->persist($translation);

        $wordTranslation = new WordTranslation();
        $wordTranslation->setWord($word);
        $wordTranslation->setTranslation($translation);
        $wordTranslation->setPriority(0);
        $entityManager->persist($wordTranslation);
        $entityManager->flush();

        $client->request(
            'DELETE',
            '/translation/1'
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(202);
//
//        $this->transport('async')->queue()->assertCount(1);
//        $this->transport('async')->process(1);
//        $this->transport('async')->queue()->assertCount(0);


    }
}

