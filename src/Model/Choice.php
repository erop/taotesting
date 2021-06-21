<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Choice
{
    /**
     * @Assert\NotBlank()
     */
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}