<?php

namespace TwigWrapper;


use Twig_Environment;

class TwigWrapper extends Twig_Environment
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /** @var PostProcessorInterface[] */
    private $postProcessors = [];

    /**
     * TwigWrapper constructor.
     *
     * @param Twig_Environment $twig
     * @param PostProcessorInterface[] $postProcessors
     */
    public function __construct(Twig_Environment $twig, array $postProcessors = [])
    {
        parent::__construct($twig->getLoader());
        $this->twig = $twig;
        $this->postProcessors = $postProcessors;
    }

    /**
     * @param string $name
     * @param array $context
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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

    /**
     * Any unhandled twig environment methods will be passed to the wrapper twig environment
     *
     *
     * @param string $methodName
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($methodName, $arguments)
    {
        return call_user_func_array([$this->twig, $methodName], $arguments);
    }
}