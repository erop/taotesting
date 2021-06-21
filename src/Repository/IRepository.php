<?php

namespace App\Repository;

use App\Model\Question;

interface IRepository
{
    public function supportsFormat(string $format): bool;
    /**
     * Returns a list of Question
     * @return Question[]
     */
    public function findAll(): array;

    /**
     * Creates a new question and associated choices (the number of associated choices must be exactly equal to 3)
     */
    public function save(Question $question): Question;
}
