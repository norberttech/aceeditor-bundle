<?php

namespace Norzechowicz\AceEditorBundle\Tests\Form\Type;

use Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;

class AceEditorTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var AceEditorType */
    private $formType;

    public function setUp()
    {
        $this->formType = new AceEditorType();
    }

    public function testGetParent()
    {
        $this->assertSame('textarea', $this->formType->getParent());
    }
}
