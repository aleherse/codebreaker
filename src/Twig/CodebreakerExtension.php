<?php

namespace App\Twig;

use App\Entity\AttemptedGuess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CodebreakerExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('codebreaker_matches', [$this, 'matches']),
        ];
    }

    public function matches($attempt)
    {
        if ($attempt instanceof AttemptedGuess) {
            return sprintf(
                "%s%s",
                str_repeat('+', $attempt->exact()),
                str_repeat('-', $attempt->partial())
            );
        }

        return '';
    }
}
