<?php

namespace Azzra\AceEditorBundle\Tests\Form\Type;

use Azzra\AceEditorBundle\Form\Type\AceEditorType;
use PHPUnit\Framework\TestCase;

class AceEditorTypeTest extends TestCase
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
