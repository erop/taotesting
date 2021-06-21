<?php

namespace App\Model;

class QuestionList
{
    /**
     * @var array|Question[]
     */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Question[]|array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
