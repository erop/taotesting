<?php

namespace App\Controller;

use App\Application\Query\GetTranslatedQuestionList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    /**
     * @Route("/questions", name="questions", methods={"GET"})
     */
    public function list(Request $request, GetTranslatedQuestionList $query): JsonResponse
    {
        $lang = $request->query->get('lang');
        if (!Languages::exists($lang)) {
            throw new \InvalidArgumentException(sprintf('Could not determine the language for given query param "%s"', $lang));
        }
        $questionList = $query->getQuestionList($lang);
        return $this->json($questionList);
    }
}