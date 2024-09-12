<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Word;
use App\Enum\DialectEnum;
use PHPUnit\Framework\TestCase;


class WordTest extends TestCase
{
    public function testCanGetAndSetData(): void
    {
        $word = new Word();
        $word->setName('Chip');
        $word->setDialect(DialectEnum::UK);
        $word->setExplanation('a long thin piece of potato fried in oil or fat');
        $word->setPronunciation('/tʃɪp/');

        self::assertSame('Chip', $word->getName());
        self::assertSame(DialectEnum::UK, $word->getDialect());
        self::assertSame('a long thin piece of potato fried in oil or fat', $word->getExplanation());
        self::assertSame('/tʃɪp/', $word->getPronunciation());
    }
}
