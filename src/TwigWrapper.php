<?php

namespace TwigWrapper;

use Silex\Application;
use Twig_Environment;
use TwigWrapper\PostProcessorInterface;

class TwigWrapper
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * TwigWrapper constructor.
     *
     * @param Application $app
     * @param string $twigIdentifier
     * @param PostProcessorInterface[] $postProcessors
     */
    public function __construct(Application $app, $twigIdentifier = 'twig', array $postProcessors = [])
    {
        $this->twig = $app[$twigIdentifier];
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