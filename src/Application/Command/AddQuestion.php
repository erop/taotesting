<?php

namespace App\Application\Command;

use App\Model\Question;
use App\Repository\IRepository;

class AddQuestion
{
    private IRepository $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Question $question)
    {
        $this->repository->save($question);
    }
}