<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Symfony;

use App\Application\Service\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslatorImpl implements Translator
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate(string $text): string
    {
        return $this->translator->trans($text);
    }

    public function translateValues(array $array): array
    {
        $temp = [];

        foreach ($array as $key => $value) {
            $temp[$key] = $this->translator->trans($value);
        }

        return $temp;
    }
}
