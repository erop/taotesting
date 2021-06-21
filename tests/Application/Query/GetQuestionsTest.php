<?php

namespace App\Tests\Application\Query;

use App\Application\Query\GetQuestions;
use App\Repository\IRepository;
use App\Tests\QuestionsTestCase;

class GetQuestionsTest extends QuestionsTestCase
{
    public function testQuestionList(): void
    {
        $repository = self::createMock(IRepository::class);
        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($this->questions);
        $query = new GetQuestions($repository);
        self::assertEquals($this->questions, $query());
    }
}
