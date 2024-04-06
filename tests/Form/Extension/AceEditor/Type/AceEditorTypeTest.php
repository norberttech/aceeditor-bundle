<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\Form\Extension\AceEditor\Type;

use AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AceEditorTypeTest extends TestCase
{
    /** @var AceEditorType<mixed> */
    private AceEditorType $formType;

    public function setUp(): void
    {
        $this->formType = new AceEditorType(false);
    }

    public function testGetParent(): void
    {
        $this->assertSame(TextareaType::class, $this->formType->getParent());
    }

    public function testOptionsWidthHeightUnitNormalizer(): void
    {
        $opts = new OptionsResolver();
        $this->formType->configureOptions($opts);

        $resolved = $opts->resolve(['width' => null, 'height' => null]);
        $this->assertSame(['value' => null, 'unit' => 'px'], $resolved['width']);
        $this->assertSame(['value' => null, 'unit' => 'px'], $resolved['height']);

        $resolved = $opts->resolve(['width' => 20, 'height' => '20']);
        $this->assertSame(['value' => 20, 'unit' => 'px'], $resolved['width']);
        $this->assertSame(['value' => '20', 'unit' => 'px'], $resolved['height']);

        $resolved = $opts->resolve(['width' => '50%']);
        $this->assertSame(['value' => '50', 'unit' => '%'], $resolved['width']);

        $resolved = $opts->resolve(['width' => '101foo']);
        $this->assertSame(['value' => '101foo', 'unit' => 'px'], $resolved['width']);

    }
}
