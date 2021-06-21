<?php

namespace App\Model;

use App\Exception\EmptyChoicesException;

class Question
{
    private string $text;

    /**
     * Creation date of the question
     */
    private \DateTimeImmutable $createdAt;

    /**
     * Choices associated to the question
     * @var array|Choice[]
     */
    private array $choices;

    /**
     * @throws EmptyChoicesException
     */
    public function __construct(string $text, \DateTimeImmutable $createdAt, array $choices)
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        if (0 === count($choices)) {
            throw new EmptyChoicesException();
        }
        $this->choices = $choices;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return array|Choice[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }
}
