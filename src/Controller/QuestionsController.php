<?php

namespace App\Controller;

use App\Application\Command\AddQuestion;
use App\Application\Query\GetTranslatedQuestionList;
use App\Model\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionsController extends AbstractController
{
    /**
     * @Route("/questions", name="question_list", methods={"GET"})
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

    /**
     * @Route("/questions", name="question_add", methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, AddQuestion $command): JsonResponse
    {
        $allowedFormats = ['application/json', 'json'];
        $contentType = $request->getContentType();
        if (!\in_array($contentType, $allowedFormats)) {
            throw new \InvalidArgumentException(sprintf('Only "%s" is allowed, "%s" provided', $allowedFormats, $contentType));
        }
        $content = $request->getContent();
        $question = $serializer->deserialize($content, Question::class, 'json');
        $errors = $validator->validate($question);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
        }
        $command($question);
        return new JsonResponse($content, Response::HTTP_OK, [], true);
    }
}
