<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\DependencyInjection;

use AceEditorBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testProcessConfiguration(): void
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, []);

        $this->assertArrayHasKey('autoinclude', $config);
        $this->assertTrue($config['autoinclude']);

        $this->assertArrayHasKey('base_path', $config);
        $this->assertSame('vendor/ace', $config['base_path']);

        $this->assertArrayHasKey('debug', $config);
        $this->assertFalse($config['debug']);

        $this->assertArrayHasKey('noconflict', $config);
        $this->assertTrue($config['noconflict']);

        $this->assertArrayHasKey('use_stimulus', $config);
        $this->assertNull($config['use_stimulus']);
    }
}
