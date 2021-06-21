<?php


namespace App\Service;


use App\Model\Choice;
use App\Model\Question;

class CsvRowConverter
{

    public function convertRow(array $row): Question
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
}