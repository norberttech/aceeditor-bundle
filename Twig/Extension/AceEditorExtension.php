<?php

/**
 * This file is part of the AceEditorBundle.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Azzra\AceEditorBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension;

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class AceEditorExtension extends \Twig_Extension
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
     * @var \Twig_Environment
     */
    private $environment;

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
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
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
            'include_ace_editor' => new \Twig_SimpleFunction('include_ace_editor', [$this, 'includeAceEditor'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Echoes the <script> tag.
     *
     * @throws \LogicException if asset extension is not available and Ace editor must be included
     */
    public function includeAceEditor()
    {
        if ($this->editorIncluded) {
            return;
        }

        if (!$this->environment->hasExtension('asset')) {
            throw new \LogicException('"asset" extension is mandatory if you don\'t include Ace editor by yourself.');
        }

        if (!$this->editorIncluded) {
            foreach (['ace', 'ext-language_tools'] as $file) {
                /** @var AssetExtension $extension */
                $extension = $this->environment->getExtension('asset');
                $jsPath = $extension->getAssetUrl($this->basePath.'/'.$this->mode.'/'.$file.'.js');

                printf('<script src="%s" charset="utf-8" type="text/javascript"></script>', $jsPath);
            }
            $this->editorIncluded = true;
        }
    }
}
