<?php

namespace App\Application\Query;

use App\Model\Choice;
use App\Model\Question;
use App\Model\QuestionList;
use App\Service\ITranslator;

class GetTranslatedQuestionList
{
    private GetQuestions $query;
    private ITranslator $translator;

    public function __construct(GetQuestions $query, ITranslator $translator)
    {
        $this->query = $query;
        $this->translator = $translator;
    }

    public function getQuestionList(string $lang): QuestionList
    {
        $originals = ($this->query)();
        $translated = [];
        foreach ($originals as $original) {
            $translated[] = $this->translate($original, $lang);
        }
        return new QuestionList($translated);
    }

    private function translate(Question $original, string $to): Question
    {
        $from = 'en';
        $text = $this->translator->translate($original->getText(), $from, $to);
        $choices = array_map(function (Choice $choice) use ($from, $to) {
            return new Choice($this->translator->translate($choice->getText(), $from, $to));
        }, $original->getChoices());
        return new Question($text, $original->getCreatedAt(), $choices);
    }
}