# Ace Editor Bundle

![Tests](https://github.com/norberttech/aceeditor-bundle/workflows/Tests/badge.svg)

This bundle provides an [Ace editor](https://ace.c9.io/) integration for the Symfony Form component by
automatically registering the `ace_editor` form type.

## Compatibility

Check the table below to check if your PHP and symfony versions are supported.

| PHP version(s)  | Symfony version(s)   | AceEditorBundle version  |
| --------------- |----------------------| ------------------------------------------------------------------ |
| >= 8.1          | ^5.4 \| ^6.4 \| ^7.1 | [^5.0](https://github.com/norberttech/aceeditor-bundle/tree/5.x)   |

For older unsupported versions check the [releases](https://github.com/norberttech/aceeditor-bundle/releases) page.


## Installation

To use this bundle with the latest Symfony version install it using [Composer](https://getcomposer.org/):

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
];
```


## Usage

```php
use AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

/** @var $builder \Symfony\Component\Form\FormBuilderInterface */
$builder->add('description', AceEditorType::class, [
    'wrapper_attr' => [], // aceeditor wrapper html attributes.
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
    'keyboard_handler' => null,
    'autocomplete_worlds'=>["foo", "bar", "baz"]
]);
```

The above code will create a textarea element that will be replaced with an ace editor instance.
The textarea value is updated on every change done in ace editor.


## Configuration

> This section is optional, you dont need to configure anything and the form type will still work perfectly fine.

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


## Ace editor assets

Unless you do some configuration, this bundle expects Ace editor files to be in `public/vendor/ace`.
You can download any ace editor build version from the [upstream repository](https://github.com/ajaxorg/ace/releases) and drop its contents in
the corresponding folder.

```sh
ACE_VERSION=1.32.3 # replace with whatever ace version you need

cd <YOUR_PROJECT_ROOT>/public
mkdir vendor && cd vendor
wget https://github.com/ajaxorg/ace-builds/archive/v${ACE_VERSION}.tar.gz
tar -xvf v${ACE_VERSION}.tar.gz
mv ace-${ACE_VERSION} ace
rm v${ACE_VERSION}.tar.gz
```

## Use with Stimulus and Asset Mapper

Stimulus version is supported only with Asset mapper dependency

- ```composer require symfony/stimulus-bundle```
- ```composer require symfony/asset-mapper ```
- ```bin/console importmap:require ace-builds/css/ace.css```
- ```bin/console importmap:require ace-builds/src-noconflict/ace.js```
- ```bin/console importmap:require ace-builds/src-noconflict/ext-language_tools.js```

fell free to add more dependencies for your theme and mode

- ```bin/console importmap:require ace-builds/src-noconflict/theme-monokai.js```
- ```bin/console importmap:require ace-builds/src-noconflict/worker-javascript.js```
- ```bin/console importmap:require ace-builds/src-noconflict/mode-javascript.js```