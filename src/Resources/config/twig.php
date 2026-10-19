<?php

declare(strict_types=1);

use AceEditorBundle\Twig\Extension\AceEditorExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('ace_editor.twig.form_extension', AceEditorExtension::class)
        ->args([
            '%ace_editor.options.autoinclude%',
            '%ace_editor.options.base_path%',
            '%ace_editor.options.mode%',
        ])
        ->tag('twig.extension');
};
