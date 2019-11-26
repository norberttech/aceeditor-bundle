<?php

namespace Norzechowicz\AceEditorBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Twig\Extension\AbstractExtension;
use Twig\Extension\InitRuntimeInterface;
use Twig\Environment;
use Twig\TwigFunction;

class AceEditorExtension extends AbstractExtension
{
    /**
     * Should we include the ace.js?
     * If false, user should include it it's own way.
     *
     * @var bool
     */
    private $editorIncluded;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $mode;

    /**
     * @param bool   $autoinclude means if the bundle should inclue the JS
     * @param string $basePath
     * @param string $mode
     */
    public function __construct($autoinclude, $basePath, $mode)
    {
        $this->editorIncluded = !$autoinclude;
        $this->basePath = rtrim($basePath, '/');
        $this->mode = ltrim($mode, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ace_editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            'include_ace_editor' => new TwigFunction('include_ace_editor', [$this, 'includeAceEditor'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    /**
     * Echoes the <script> tag.
     *
     * @throws \LogicException if asset extension is not available and Ace editor must be included
     */
    public function includeAceEditor(Environment $environment)
    {
        if ($this->editorIncluded) {
            return;
        }

        if (!$environment->hasExtension(AssetExtension::class)) {
            throw new \LogicException('"asset" extension is mandatory if you don\'t include Ace editor by yourself.');
        }

        if (!$this->editorIncluded) {
            foreach (['ace', 'ext-language_tools'] as $file) {
                /** @var AssetExtension $extension */
                $extension = $environment->getExtension(AssetExtension::class);
                $jsPath = $extension->getAssetUrl($this->basePath.'/'.$this->mode.'/'.$file.'.js');

                printf('<script src="%s" charset="utf-8" type="text/javascript"></script>', $jsPath);
            }
            $this->editorIncluded = true;
        }
    }
}
