<?php

namespace App\Service;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GoogleTranslator implements ITranslator
{
    private GoogleTranslate $googleTranslate;

    private CacheInterface $cache;

    public function __construct(GoogleTranslate $googleTranslate, CacheInterface $cache)
    {
        $this->googleTranslate = $googleTranslate;
        $this->cache = $cache;
    }

    public function translate(string $string, string $from, string $to): string
    {
        $hash = hash('md5', $string);
        $key = sprintf('%s_%s_%s_%s', 'google', $from, $to, $hash);
        return $this->cache->get($key, function (ItemInterface $item) use ($string, $from, $to) {
            $item->expiresAfter(new \DateInterval('P1Y'));
            $this->googleTranslate->setSource($from);
            $this->googleTranslate->setTarget($to);
            return $this->googleTranslate->translate($string);
        });
    }
}