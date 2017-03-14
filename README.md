# Ace Editor Bundle #

Bundle provides a [ace editor](http://ace.ajax.org) integration into Symfony2 Form component. It automatically register ``aceeditor``
form type.

# Important #

Check your composer.json file and if you have "1.0.*@dev" dependency of this bundle change it into "0.1.*".

```
   - "azzra/aceeditor-bundle": "1.0.*@dev",
   + "azzra/aceeditor-bundle": "0.1.*",
```

Do it before calling composer.phar update to be sure that your code will not be broken.

# Installation #

Add bundle into your ``composer.json`` file.

```
{
    "require": {
        "azzra/aceeditor-bundle": "0.1.*",
    }
}
```

Register bundle in AppKernel.php

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        new Azzra\AceEditorBundle\AzzraAceEditorBundle(),
        // ...
    );
}
```

Update project dependencies

```
$ php composer.phar update
```

# Usage #

```php
/* @var $builder \Symfony\Component\Form\FormBuilderInterface */

$builder->add('description', 'ace_editor', array(
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
));
```

Above code will create textarea element that will be replaced with ace editor instance.
Textarea value is updated on every single change in ace editor.

# Configuration #

> This section is optional, you dont need to configure anything and your ace_editor form type will still work perfectly fine

There are also few options that alows you to manipulate including ace editor javascript sdk. 

```
# app/config/config.yml

azzra_ace_editor:
    base_path: "bundles/azzraaceeditor/ace"
    autoinclude: true
    debug: false # sources not minified with uglify.js, based on kernel.debug but it can force it
    noconflict: true # uses ace.require instead of require
```

You can also include ace editor directly from github, all you need to do is setting ``base_path`` option 

```
azzra_ace_editor:
    base_path: "http://rawgithub.com/ajaxorg/ace-builds/master"
```

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/azzra/aceeditor-bundle/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

