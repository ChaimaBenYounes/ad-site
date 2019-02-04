<?php

namespace App\Twig;

use App\Tuto\TitleTransformer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TitleToUpperExtension  extends AbstractExtension
{
    /**
     * @var TitleTransformer $titleTransformer
     */
    protected $titleTransformer;

    public function __construct(TitleTransformer $titleTransformer)
    {
        $this->titleTransformer = $titleTransformer;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('title_transformer', [$this, 'titleTransformer']),
        ];
    }

    public function titleTransformer($text)
    {
        return $this->titleTransformer->titleToUpper($text);
    }
}