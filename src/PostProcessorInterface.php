<?php


namespace TwigWrapper;

use Twig_Environment;

interface PostProcessorInterface
{
    /**
     * @param string $rawHtml
     *
     * @param string $name Template name
     * @param array $context The context used to render the template
     * @param Twig_Environment|null $environment The twig environment used, useful for accessing
     *
     * @return string processedHtml
     */
    public function process($rawHtml, $name = '', $context = [], $environment = null);
}