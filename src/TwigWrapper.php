<?php

namespace TwigWrapper;


use Twig_Environment;

class TwigWrapper
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * TwigWrapper constructor.
     *
     * @param Twig_Environment $twig
     * @param PostProcessorInterface[] $postProcessors
     */
    public function __construct(Twig_Environment $twig, array $postProcessors = [])
    {
        $this->twig = $twig;
        $this->postProcessors = $postProcessors;
    }

    /**
     * @param string $name
     * @param array $context
     *
     * @return string
     */
    public function render($name, array $context = [])
    {
        $renderedHtml = $this->twig->render($name, $context);

        foreach ($this->postProcessors as $postProcessor) {
            if ($postProcessor instanceof PostProcessorInterface)
                $renderedHtml = $postProcessor->process($renderedHtml, $name, $context, $this->twig);
        }

        return $renderedHtml;
    }
}