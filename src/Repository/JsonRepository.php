<?php

namespace App\Repository;

use App\Model\Question;

class JsonRepository implements IRepository
{
    private string $jsonPath;

    public function __construct(string $jsonPath)
    {
        $this->jsonPath = $jsonPath;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @inheritDoc
     */
    public function save(Question $question): Question
    {
        // TODO: Implement save() method.
    }
}