<?php

declare(strict_types=1);

namespace Norzechowicz\AceEditorBundle\Tests\Form\Extension\AceEditor\Type;

use Norzechowicz\AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AceEditorTypeTest extends TestCase
{
    /** @var AceEditorType */
    private $formType;

    public function setUp() : void
    {
        $this->formType = new AceEditorType();
    }

    public function testGetParent()
    {
        $this->assertSame(TextareaType::class, $this->formType->getParent());
    }
}
