<?php

namespace App\Repository;

use App\Exception\FileNotAccessibleException;
use App\Exception\FileNotFoundException;
use App\Model\Question;
use App\Service\CsvConverter;

class CsvRepository implements IRepository
{
    private string $csvPath;

    private CsvConverter $converter;

    /**
     * @throws FileNotFoundException
     */
    public function __construct(string $csvPath, CsvConverter $converter)
    {
        if (!file_exists($csvPath)) {
            throw new FileNotFoundException(sprintf('Could not find file "%s"', $csvPath));
        }
        $this->csvPath = $csvPath;
        $this->converter = $converter;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $questions = [];
        $handle = \fopen($this->csvPath, 'r');
        try {
            if (false === $handle) {
                throw new FileNotAccessibleException(sprintf('Could not open file "%s" for reading', $this->csvPath));
            }
            $rowsToSkip = [0];
            $counter = 0;
            while (false !== $row = \fgetcsv($handle, 0, ',')) {
                if (\in_array($counter++, $rowsToSkip)) {
                    continue;
                }
                $questions[] = $this->converter->fromCsv($row);
            }
        } finally {
            fclose($handle);
        }
        return $questions;
    }

    /**
     * @inheritDoc
     */
    public function save(Question $question): Question
    {
        $handle = \fopen($this->csvPath, 'a');
        try {
            if (false === $handle) {
                throw new FileNotAccessibleException(sprintf('Could not open file "%s" for reading', $this->csvPath));
            }
            if (false === fputcsv($handle, $this->converter->fromQuestion($question))) {
                throw new FileNotAccessibleException(sprintf('Could not write to file "%s"', $this->csvPath));
            }
        } finally {
            fclose($handle);
        }
        return $question;
    }
}