<?php

declare(strict_types=1);

use AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->parameters()
        ->set('ace_editor.form.resource', '@AceEditor/Form/div_layout.html.twig');

    $container->services()
        ->set('ace_editor.form.type.ace_editor', AceEditorType::class)
        ->args(['%ace_editor.options.use_stimulus%'])
        ->tag('form.type', ['alias' => 'ace_editor']);
};
