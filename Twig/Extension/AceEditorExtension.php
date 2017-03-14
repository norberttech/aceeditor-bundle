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

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class AceEditorExtension extends \Twig_Extension
{
    /**
     * Should we include the ace.js?
     * If false, user should include it it's own way.
     *
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

    /**
     * @param boolean $autoinclude means if the bundle should inclue the JS
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
        return array(
            'include_ace_editor' => new \Twig_Function_Method($this, 'includeAceEditor', array('is_safe' => array('html'))),
        );
    }

    /**
     * Echoes the <script> tag.
     *
     */
    public function includeAceEditor()
    {
        if (!$this->environment->hasExtension('asset') || $this->editorIncluded) {
            return;
        }

        if (!$this->editorIncluded) {

            foreach (array('ace', 'ext-language_tools') as $file) {
                $jsPath = $this->environment
                    ->getExtension('asset')
                    ->getAssetUrl($this->basePath . '/' . $this->mode . '/' . $file . '.js');

                echo sprintf('<script src="%s" charset="utf-8" type="text/javascript"></script>', $jsPath);
            }
            $this->editorIncluded = true;
        }

    }
}
