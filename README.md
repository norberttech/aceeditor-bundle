# Ace Editor Bundle

![Tests](https://github.com/norberttech/aceeditor-bundle/workflows/Tests/badge.svg)

Bundle provides a [Ace editor](http://ace.ajax.org) integration into Symfony Form component.
It automatically register `ace_editor` form type.

## Compatibility

This bundle provides support for different PHP and symfony version combinations, check
the compatibility matrix below to pick the right version for your application.
| PHP version(s)  | Symfony version(s)  | AceEditorBundle version  |
| --------------- | ------------------- | ------------------------------------------------------------------ |
| >= 8.1          | ^5.4 \| ^6.4        | [^5.0](https://github.com/norberttech/aceeditor-bundle/tree/5.x)   |
| ^5.6 \| ^7      | ^4.0                | [^4.0](https://github.com/norberttech/aceeditor-bundle/tree/4.0.2) |
| ^5.6            | ^3.0                | [^3.0](https://github.com/norberttech/aceeditor-bundle/tree/3.0.0) |
| ^5.6            | ^2.8                | [^3.0](https://github.com/norberttech/aceeditor-bundle/tree/2.8.0) |


## Composer

To use this bundle with the latest Symfony version, require it with [Composer](https://getcomposer.org/):

```sh
composer require norberttech/aceeditor-bundle ^5.0
```

If you're using [symfony/flex](https://symfony.com/doc/current/setup/flex.html) then the
bundle will be automatically registered for you, otherwise you need to register the
bundle yourself:

```php
// app/config/bundles.php

return [
    // ...
    AceEditorBundle\AceEditorBundle::class => ['all' => true],
    // ...
}
```

### Ace editor

Unless you do some configuration, this bundle expects Ace editor files to be in `public/vendor/ace`:

```sh
cd <your_project_root>/public
mkdir vendor && cd vendor
wget https://github.com/ajaxorg/ace-builds/archive/v1.2.6.tar.gz
tar -xvf v1.2.6.tar.gz
mv ace-builds-1.2.6 ace
rm v1.2.6.tar.gz
```

## Usage

```php
use AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

/** @var $builder \Symfony\Component\Form\FormBuilderInterface */
$builder->add('description', AceEditorType::class, array(
    'wrapper_attr' => array(), // aceeditor wrapper html attributes.
    'width' => '100%',
    'height' => 250,
    'font_size' => 12,
    'mode' => 'ace/mode/html', // every single default mode must have ace/mode/* prefix
    'theme' => 'ace/theme/monokai', // every single default theme must have ace/theme/* prefix
    'tab_size' => null,
    'read_only' => null,
    'use_soft_tabs' => null,
    'use_wrap_mode' => null,
    'show_print_margin' => null,
    'show_invisibles' => null,
    'highlight_active_line' => null,
    'options_enable_basic_autocompletion' => true,
    'options_enable_live_autocompletion' => true,
    'options_enable_snippets' => false
    'keyboard_handler' => null
));
```

Above code will create textarea element that will be replaced with ace editor instance.
Textarea value is updated on every single change in ace editor.

## Configuration

> This section is optional, you dont need to configure anything and the form type will still work perfectly fine

Default configuration:

```
# app/config/config.yml

ace_editor:
    base_path: "vendor/ace" # notice! this is starting from your project's public web root, typically: `%kernel.project_dir%/public`!
    autoinclude: true
    debug: false # sources not minified, based on kernel.debug but it can force it
    noconflict: true # uses ace.require instead of require
```

You can also include Ace editor directly from a location that follow the same directory layout than
`https://github.com/ajaxorg/ace-builds`, all you need to do is setting `base_path` option:
```
ace_editor:
    base_path: "http://rawgithub.com/ajaxorg/ace-builds/master"
```
