<?php

namespace App\Tests;

use App\Model\Choice;
use App\Model\Question;
use PHPUnit\Framework\TestCase;

class QuestionsTestCase extends TestCase
{
    protected array $questions;

    protected function setUp(): void
    {
        $this->questions = [
            new Question(
                'What is the capital of Luxembourg ?',
                new \DateTimeImmutable('2019-06-01 00:00:00'),
                [
                    new Choice('Luxembourg'),
                    new Choice('Paris'),
                    new Choice('Berlin')
                ]
            ),
            new Question(
                "What does mean O.A.T. ?",
                new \DateTimeImmutable("2019-06-02 00:00:00"),
                [
                    new Choice('Open Assignment Technologies'),
                    new Choice('Open Assessment Technologies'),
                    new Choice('Open Acknowledgment Technologies')
                ]
            ),
        ];
    }
}