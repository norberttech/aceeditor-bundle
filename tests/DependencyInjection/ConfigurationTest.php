<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\DependencyInjection;

use AceEditorBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

/**
 * @internal
 */
final class ConfigurationTest extends TestCase
{
    public function testProcessConfiguration(): void
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, []);

        self::assertArrayHasKey('autoinclude', $config);
        self::assertTrue($config['autoinclude']);

        self::assertArrayHasKey('base_path', $config);
        self::assertSame('vendor/ace', $config['base_path']);

        self::assertArrayHasKey('debug', $config);
        self::assertFalse($config['debug']);

        self::assertArrayHasKey('noconflict', $config);
        self::assertTrue($config['noconflict']);

        self::assertArrayHasKey('use_stimulus', $config);
        self::assertNull($config['use_stimulus']);
    }
}
