# Ace Editor Bundle

![Tests](https://github.com/norberttech/aceeditor-bundle/workflows/Tests/badge.svg)

Bundle provides a [Ace editor](http://ace.ajax.org) integration into Symfony Form component.
It automatically register `ace_editor` form type.

# Symfony

This bundle is supporting following Symfony versions:

* [Symfony ^2.8, PHP >= 5.6](https://github.com/norberttech/aceeditor-bundle/tree/2.8)
* [Symfony ^3.0, PHP >= 5.6](https://github.com/norberttech/aceeditor-bundle/tree/3.0)
* [Symfony ^4.0, PHP >= 5.6](https://github.com/norberttech/aceeditor-bundle/tree/4.0)
* [Symfony ^5.0, PHP >= 7.3](https://github.com/norberttech/aceeditor-bundle/tree/5.x)


## Composer

To use this bundle with `Symfony ^4.0`, require it in [Composer](https://getcomposer.org/):

```sh
composer require "norberttech/aceeditor-bundle" ^4.0
```

Register bundle in AppKernel.php

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        new Norzechowicz\AceEditorBundle\NorzechowiczAceEditorBundle(),
        // ...
    );
}
```

### Ace editor

Unles you do some configuration, this bundle expect Ace editor files to be in `web/vendor/ace`:

```sh
cd your_project_root/web
mkdir vendor && cd vendor
wget https://github.com/ajaxorg/ace-builds/archive/v1.2.6.tar.gz
tar -xvf v1.2.6.tar.gz
mv ace-builds-1.2.6 ace
rm v1.2.6.tar.gz
```

## Usage

```php
use Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

/* @var $builder \Symfony\Component\Form\FormBuilderInterface */
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

norzechowicz_ace_editor:
    base_path: "vendor/ace" # notice! this is starting from "your_project_root/web"!
    autoinclude: true
    debug: false # sources not minified, based on kernel.debug but it can force it
    noconflict: true # uses ace.require instead of require
```

You can also include Ace editor directly from a location that follow the same directory layout than
`https://github.com/ajaxorg/ace-builds`, all you need to do is setting `base_path` option:
```
norzechowicz_ace_editor:
    base_path: "http://rawgithub.com/ajaxorg/ace-builds/master"
```
