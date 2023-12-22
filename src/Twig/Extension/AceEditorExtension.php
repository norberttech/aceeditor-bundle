<?php

declare(strict_types=1);

namespace Norzechowicz\AceEditorBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AceEditorExtension extends AbstractExtension
{
    /**
     * Should we include the ace.js?
     * If false, user should include it its own way.
     */
    private bool $editorIncluded;

    private string $basePath;

    private string $mode;

    public function __construct(bool $autoInclude, string $basePath, string $mode)
    {
        $this->editorIncluded = !$autoInclude;
        $this->basePath = rtrim($basePath, '/');
        $this->mode = ltrim($mode, '/');
    }

    public function getName(): string
    {
        return 'ace_editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            'include_ace_editor' => new TwigFunction(
                'include_ace_editor',
                [$this, 'includeAceEditor'],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }

    /**
     * Echoes the <script> tag.
     *
     * @throws \LogicException if asset extension is not available and Ace editor must be included
     */
    public function includeAceEditor(Environment $environment): void
    {
        if ($this->editorIncluded) {
            return;
        }

        if (!$environment->hasExtension(AssetExtension::class)) {
            throw new \LogicException('"asset" extension is mandatory if you do not include Ace editor by yourself.');
        }

        foreach (['ace', 'ext-language_tools'] as $file) {
            $extension = $environment->getExtension(AssetExtension::class);
            $jsPath = $extension->getAssetUrl($this->basePath.'/'.$this->mode.'/'.$file.'.js');

            printf('<script src="%s" charset="utf-8" type="text/javascript"></script>', $jsPath);
        }
        $this->editorIncluded = true;
    }
}
