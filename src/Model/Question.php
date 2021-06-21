<?php

namespace App\Model;

use App\Exception\EmptyChoicesException;
use Symfony\Component\Validator\Constraints as Assert;

class Question
{
    /**
     * @Assert\NotBlank()
     */
    private string $text;

    /**
     * Creation date of the question
     */
    private \DateTimeImmutable $createdAt;

    /**
     * Choices associated to the question
     * @var Choice[]
     * @Assert\Count(min=3, max=3, exactMessage="This collection should contain exactly {{ limit }} elements but has {{ count }}")
     */
    private array $choices;

    /**
     *
     * @param string $text
     * @param \DateTimeImmutable $createdAt
     * @param Choice[] $choices
     * @throws EmptyChoicesException
     */
    public function __construct(string $text, \DateTimeImmutable $createdAt, $choices)
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
     * @return Choice[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }
}
