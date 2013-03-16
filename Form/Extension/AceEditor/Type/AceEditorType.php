<?php

/**
 * This file is part of the AceEditorBundle.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type;

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

        $resolver->setDefaults(array(
            'wrapper_attr' => array(),
            'width' => 200,
            'height' => 200,
            'font_size' => 12,
            'mode' => 'ace/mode/html',
            'theme' => 'ace/theme/monokai',
            'tab_size' => null,
            'read_only' => null,
            'use_soft_tabs' => null,
            'use_wrap_mode' => null,
            'show_print_margin' => null,
            'highlight_active_line' => null
        ));

        $resolver->setAllowedTypes(array(
            'width' => 'integer',
            'height' => 'integer',
            'mode' => 'string',
            'font_size' => 'integer',
            'tab_size' => array('integer', 'null'),
            'read_only' => array('bool', 'null'),
            'use_soft_tabs' => array('bool', 'null'),
            'use_wrap_mode' => array('bool', 'null'),
            'show_print_margin' => array('bool', 'null'),
            'highlight_active_line' => array('bool', 'null'),
        ));

        $resolver->setNormalizers(array(
            'wrapper_attr' => $wrapperAttrNormalizer,
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
                'highlight_active_line' => $options['highlight_active_line'],
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
        return 'aceeditor';
    }
}
