<?php

declare(strict_types=1);

namespace AceEditorBundle\Form\Extension\AceEditor\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template T of mixed
 * @template-extends AbstractType<T>
 */
final class AceEditorType extends AbstractType
{
    private const DEFAULT_UNIT = 'px';

    private const UNITS = ['%', 'in', 'cm', 'mm', 'em', 'ex', 'pt', 'pc', 'px'];

    private bool $useStimulus;

    public function __construct(bool $useStimulus)
    {
        $this->useStimulus = $useStimulus;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Remove id from ace editor wrapper attributes. Id must be generated.
        $wrapperAttrNormalizer = function (Options $options, mixed $aceAttr): array {
            if (is_array($aceAttr)) {
                if (array_key_exists('id', $aceAttr)) {
                    unset($aceAttr['id']);
                }
            } else {
                $aceAttr = [];
            }

            return $aceAttr;
        };

        $unitNormalizer = function (Options $options, array|string|float|int|null $value): array {
            if (is_array($value)) {
                if (!array_key_exists('value', $value) || !array_key_exists('unit', $value)) {
                    throw new InvalidArgumentException('Expected an array with the keys "value" and "unit"');
                }

                return $value;
            }
            if (preg_match('/([0-9\.]+)\s*(' . implode('|', self::UNITS) . ')/', (string)$value, $matchedValue)) {
                $value = $matchedValue[1];
                $unit  = $matchedValue[2];
            } else {
                $unit = self::DEFAULT_UNIT;
            }

            return ['value' => $value, 'unit' => $unit];
        };

        $resolver->setDefaults([
            'required'                            => false,
            'wrapper_attr'                        => [],
            'width'                               => '100%',
            'height'                              => 250,
            'font_size'                           => 12,
            'mode'                                => 'ace/mode/html',
            'theme'                               => 'ace/theme/monokai',
            'tab_size'                            => null,
            'read_only'                           => null,
            'use_soft_tabs'                       => null,
            'use_wrap_mode'                       => null,
            'show_print_margin'                   => null,
            'show_invisibles'                     => null,
            'highlight_active_line'               => null,
            'options_enable_basic_autocompletion' => true,
            'options_enable_live_autocompletion'  => true,
            'options_enable_snippets'             => false,
            'keyboard_handler'                    => null,
            'autocomplete_worlds'                 => [],
        ]);

        $optionAllowedTypes = [
            'width'                               => ['null', 'integer', 'string', 'array'],
            'height'                              => ['null', 'integer', 'string', 'array'],
            'mode'                                => 'string',
            'font_size'                           => 'integer',
            'tab_size'                            => ['integer', 'null'],
            'read_only'                           => ['bool', 'null'],
            'use_soft_tabs'                       => ['bool', 'null'],
            'use_wrap_mode'                       => ['bool', 'null'],
            'show_print_margin'                   => ['bool', 'null'],
            'show_invisibles'                     => ['bool', 'null'],
            'highlight_active_line'               => ['bool', 'null'],
            'options_enable_basic_autocompletion' => ['bool', 'null'],
            'options_enable_live_autocompletion'  => ['bool', 'null'],
            'options_enable_snippets'             => ['bool', 'null'],
            'keyboard_handler'                    => ['null', 'string'],
            'autocomplete_worlds'                 => ['array'],
        ];
        foreach ($optionAllowedTypes as $option => $allowedTypes) {
            $resolver->setAllowedTypes($option, $allowedTypes);
        }

        $optionNormalizer = [
            'wrapper_attr' => $wrapperAttrNormalizer,
            'width'        => $unitNormalizer,
            'height'       => $unitNormalizer,
        ];
        foreach ($optionNormalizer as $option => $normalizer) {
            $resolver->setNormalizer($option, $normalizer);
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge(
            $view->vars,
            [
                'wrapper_attr'                        => $options['wrapper_attr'],
                'width'                               => $options['width'],
                'height'                              => $options['height'],
                'font_size'                           => $options['font_size'],
                'mode'                                => $options['mode'],
                'theme'                               => $options['theme'],
                'tab_size'                            => $options['tab_size'],
                'read_only'                           => $options['read_only'],
                'use_soft_tabs'                       => $options['use_soft_tabs'],
                'use_wrap_mode'                       => $options['use_wrap_mode'],
                'show_print_margin'                   => $options['show_print_margin'],
                'show_invisibles'                     => $options['show_invisibles'],
                'highlight_active_line'               => $options['highlight_active_line'],
                'options_enable_basic_autocompletion' => $options['options_enable_basic_autocompletion'],
                'options_enable_live_autocompletion'  => $options['options_enable_live_autocompletion'],
                'options_enable_snippets'             => $options['options_enable_snippets'],
                'keyboard_handler'                    => $options['keyboard_handler'],
                'use_stimulus'                        => $this->useStimulus,
                'autocomplete_worlds'                 => $options['autocomplete_worlds'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return TextAreaType::class;
    }
}
