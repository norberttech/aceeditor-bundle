<?php

/**
 * This file is part of the AceEditorBundle.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Azzra\AceEditorBundle\Form\Extension\AceEditor\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AceEditorType
 *
 * @author Norbert Orzechowicz <norbert@orzechowicz.pl>
 */
class AceEditorType extends AbstractType
{
    private $defaultUnit = 'px';
    private $units = array('%', 'in', 'cm', 'mm', 'em', 'ex', 'pt', 'pc', 'px');

    /**
     * Add the image_path option
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // Remove id from ace editor wrapper attributes. Id must be generated.
        $wrapperAttrNormalizer = function (Options $options, $aceAttr) {
            if (is_array($aceAttr)) {
                if (array_key_exists('id', $aceAttr)) {
                    unset($aceAttr['id']);
                }
            } else {
                $aceAttr = array();
            }

            return $aceAttr;
        };

        $defaultUnit = $this->defaultUnit;
        $allowedUnits = $this->units;
        $unitNormalizer = function(Options $options, $value) use ($defaultUnit, $allowedUnits) {
            if(is_array($value)) {
                return $value;
            }
            if(preg_match('/([0-9\.]+)\s*(' . join('|', $allowedUnits) . ')/', $value, $matchedValue)) {
                $value = $matchedValue[1];
                $unit = $matchedValue[2];
            } else {
                $unit = $defaultUnit;
            }
            return array('value' => $value, 'unit' => $unit);
        };

        $resolver->setDefaults(array(
            'required' => false,
            'wrapper_attr' => array(),
            'width' => '100%',
            'height' => 250,
            'font_size' => 12,
            'mode' => 'ace/mode/html',
            'theme' => 'ace/theme/monokai',
            'tab_size' => null,
            'read_only' => null,
            'use_soft_tabs' => null,
            'use_wrap_mode' => null,
            'show_print_margin' => null,
            'show_invisibles' => null,
            'highlight_active_line' => null,
            'options_enable_basic_autocompletion' => true,
            'options_enable_live_autocompletion' => true,
            'options_enable_snippets' => false,
        ));

        $resolver->setAllowedTypes(array(
            'width' => array('integer', 'string', 'array'),
            'height' => array('integer', 'string', 'array'),
            'mode' => 'string',
            'font_size' => 'integer',
            'tab_size' => array('integer', 'null'),
            'read_only' => array('bool', 'null'),
            'use_soft_tabs' => array('bool', 'null'),
            'use_wrap_mode' => array('bool', 'null'),
            'show_print_margin' => array('bool', 'null'),
            'show_invisibles' => array('bool', 'null'),
            'highlight_active_line' => array('bool', 'null'),
            'options_enable_basic_autocompletion' => array('bool', 'null'),
            'options_enable_live_autocompletion' => array('bool', 'null'),
            'options_enable_snippets' => array('bool', 'null'),
        ));

        $resolver->setNormalizers(array(
            'wrapper_attr' => $wrapperAttrNormalizer,
            'width'        => $unitNormalizer,
            'height'       => $unitNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge(
            $view->vars,
            array(
                'wrapper_attr' => $options['wrapper_attr'],
                'width' => $options['width'],
                'height' => $options['height'],
                'font_size' => $options['font_size'],
                'mode' => $options['mode'],
                'theme' => $options['theme'],
                'tab_size' => $options['tab_size'],
                'read_only' => $options['read_only'],
                'use_soft_tabs' => $options['use_soft_tabs'],
                'use_wrap_mode' => $options['use_wrap_mode'],
                'show_print_margin' => $options['show_print_margin'],
                'show_invisibles' => $options['show_invisibles'],
                'highlight_active_line' => $options['highlight_active_line'],
                'options_enable_basic_autocompletion' => $options['options_enable_basic_autocompletion'],
                'options_enable_live_autocompletion' => $options['options_enable_live_autocompletion'],
                'options_enable_snippets' => $options['options_enable_snippets'],
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ace_editor';
    }
}
