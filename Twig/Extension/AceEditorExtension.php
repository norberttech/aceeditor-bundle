<?php

/**
 * This file is part of the AceEditorBundle.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Norzechowicz\AceEditorBundle\Twig\Extension;

use Symfony\Component\Asset\Exception\InvalidArgumentException;

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class AceEditorExtension extends \Twig_Extension
{
    /**
     * @var boolean
     */
    protected $editorIncluded;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    public function __construct($autoinclude, $basePath, $mode)
    {
        $this->ckeditorIncluded = $autoinclude;
        $this->basePath = rtrim($basePath, '/');
        $this->mode = ltrim($mode, '/');
    }

    /**
     * {@inheritDoc}
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
            'include_ace_editor' => new \Twig_Function_Method($this, 'includeAceEditor', ['is_safe' => ['html']]),
        ];
    }

    public function includeAceEditor()
    {
        $extension = $this->checkExtensionCompatibility();

        if (!$this->editorIncluded) {
            $this->editorIncluded = true;
        }

        if (!$this->ckeditorIncluded) {
            $jsPath = $this->environment
                ->getExtension($extension)
                ->getAssetUrl($this->basePath . '/' . $this->mode);

            echo sprintf('<script src="%s" charset="utf-8"></script>', $jsPath);
            $this->ckeditorIncluded = true;
        }
    }

    /**
     * Check that you have a compatible extension
     *
     * @return string The compatible extension
     * @throw InvalidArgumentException When can not found a compatible extension
     */
    private function checkExtensionCompatibility()
    {
        $extensions = ['assets', 'asset'];
        $has = false;
        $extension = '';
        foreach ($extensions as $ext) {
            if ($this->environment->hasExtension($ext)) {
                $has = true;
                $extension = $ext;
            }
        }

        if (!$has && $extension === '') {
            throw new InvalidArgumentException('Can not found a compatible extension');
        }

        return $extension;
    }
}
