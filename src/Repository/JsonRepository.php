<?php

namespace App\Repository;

use App\Model\Question;
use Symfony\Component\Serializer\SerializerInterface;

class JsonRepository implements IRepository
{
    private string $jsonPath;
    private SerializerInterface $serializer;

    public function __construct(string $jsonPath, SerializerInterface $serializer)
    {
        $this->jsonPath = $jsonPath;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->decode();
    }

    /**
     * @return Question[]
     */
    public function decode(): array
    {
        $contents = file_get_contents($this->jsonPath);
        return $this->serializer->deserialize($contents, '\App\Model\Question[]', 'json');
    }

    /**
     * @inheritDoc
     */
    public function save(Question $question): Question
    {
        $questions = $this->decode();
        $questions[] = $question;
        file_put_contents($this->jsonPath, $this->serializer->serialize($questions, 'json'));
        return $question;
    }

    public function supportsFormat(string $format): bool
    {
        return 'json' === $format;
    }
}
