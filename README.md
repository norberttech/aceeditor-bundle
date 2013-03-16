# Ace Editor Bundle #

Bundle provides a [ace editor](http://ace.ajax.org) integration into Symfony2 Form component. It automatically register ``aceeditor``
form type.

# Installation #

Add bundle into your ``composer.json`` file.

```
{
    "require": {
        "norzechowicz/aceeditor-bundle": "1.0.*@dev",
    }
}
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

Update project dependencies

```
$ php composer.phar update
```

# Usage #

```php
/* @var $builder \Symfony\Component\Form\FormBuilderInterface */

$builder->add('description', 'aceeditor', array(
    'wrapper_attr' => array(), // aceeditor wrapper html attributes.
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
```

Above code will create textarea element that will be replaced with ace editor instance.
Textarea value is updated on every single change in ace editor.