<?php

namespace App\Application\Query;

use App\Repository\IRepository;

class GetQuestions
{
    private IRepository $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): array
    {
        return $this->repository->findAll();
    }
}