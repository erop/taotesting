<?php

namespace App\Service;

use App\Exception\WrongDateFormatException;
use App\Model\Choice;
use App\Model\Question;

class CsvConverter
{
    public function fromCsv(array $row): Question
    {
        $text = $row[0];
        $createdAtString = $row[1];
        try {
            $createdAt = new \DateTimeImmutable($createdAtString);
        } catch (\Exception $e) {
            throw new WrongDateFormatException(sprintf('Could not instantiate DateTime instance from string "%s"', $createdAtString));
        }
        $choices = $this->convertChoices(array_slice($row, 2));
        return new Question($text, $createdAt, $choices);
    }

    /**
     * @return array|Choice[]
     */
    private function convertChoices(array $strings): array
    {
        $choices = [];
        foreach ($strings as $text) {
            $choices[] = new Choice($text);
        }
        return $choices;
    }

    public function fromQuestion(Question $question): array
    {
        $text = $question->getText();
        $createdAt = $question->getCreatedAt()->format('Y-m-d H:i:s');
        $choices = array_map(static function (Choice $choice) {
            return $choice->getText();
        }, $question->getChoices());
        return [$text, $createdAt, ...$choices];
    }
}
