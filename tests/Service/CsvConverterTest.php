<?php

namespace App\Tests\Service;

use App\Exception\EmptyChoicesException;
use App\Exception\WrongDateFormatException;
use App\Model\Choice;
use App\Model\Question;
use App\Service\CsvConverter;
use PHPUnit\Framework\TestCase;

class CsvConverterTest extends TestCase
{
    public function testFromCsv(): void
    {
        $row = ['What is the capital of Luxembourg ?', '2019-06-01 00:00:00', 'Luxembourg', 'Paris', 'Berlin'];
        $expected = new Question($row[0], new \DateTimeImmutable($row[1]), [new Choice('Luxembourg'), new Choice('Paris'), new Choice('Berlin'),]);
        $converter = new CsvConverter();
        self::assertEquals($expected, $question = $converter->fromCsv($row));
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
        $converter = new CsvConverter();
        $converter->fromCsv($row);
    }

    public function testFromQuestion(): void
    {
        $converter = new CsvConverter();
        $question = new Question('What is the capital of Luxembourg ?',
            new \DateTimeImmutable('2019-06-01 00:00:00'),
            [
                new Choice('Luxembourg'),
                new Choice('Paris'),
                new Choice('Berlin')
            ]
        );
        $expected = ['What is the capital of Luxembourg ?', '2019-06-01 00:00:00', 'Luxembourg', 'Paris', 'Berlin'];
        self::assertEquals($expected, $converter->fromQuestion($question));
    }
}
