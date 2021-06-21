<?php

namespace App\Repository;

class RepositoryFactory
{
    private iterable $repositories;

    public function __construct(iterable $repositories)
    {
        $this->repositories = $repositories;
    }

    public function getRepository(string $format): ?IRepository
    {
        /** @var IRepository $repository */
        foreach ($this->repositories as $repository) {
            if ($repository->supportsFormat($format)) {
                return $repository;
            }
        }
        return null;
    }
}