<?php

namespace App\FunctionHelper;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class JsonDecode
 */
class JsonDecode extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('jsonDecode', [$this, 'jsonDecode']),
        ];
    }

    public function jsonDecode($string)
    {
        return json_decode($string);
    }
}