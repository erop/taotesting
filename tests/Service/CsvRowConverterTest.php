<?php

namespace App\Tests\Service;

use App\Model\Choice;
use App\Model\Exception\EmptyChoicesException;
use App\Model\Question;
use App\Service\CsvRowConverter;
use App\Service\WrongDateFormatException;
use PHPUnit\Framework\TestCase;

class CsvRowConverterTest extends TestCase
{
    public function testConversionOk(): void
    {
        $row = ['What is the capital of Luxembourg ?', '2019-06-01 00:00:00', 'Luxembourg', 'Paris', 'Berlin'];
        $expected = new Question($row[0], new \DateTimeImmutable($row[1]), [new Choice('Luxembourg'), new Choice('Paris'), new Choice('Berlin'),]);
        $converter = new CsvRowConverter();
        self::assertEquals($expected, $question = $converter->convertRow($row));
        self::assertCount(3, $question->getChoices());
    }

    public function testEmptyChoices(): void
    {
        $row = ['What is the capital of Luxembourg ?', '2019-06-01 00:00:00'];
        self::expectException(EmptyChoicesException::class);
        new Question($row[0], new \DateTimeImmutable($row[1]), []);
    }

    public function testWrongDateTime(): void
    {
        $row = ['What is the capital of Luxembourg ?', '2019-06-01 24:60:60', 'Luxembourg', 'Paris', 'Berlin'];
        self::expectException(WrongDateFormatException::class);
        self::expectExceptionMessage('Could not instantiate DateTime instance from string "2019-06-01 24:60:60"');
        $converter = new CsvRowConverter();
        $converter->convertRow($row);
    }
}
