<?php

namespace Norzechowicz\AceEditorBundle\Tests\DependencyInjection;

use Norzechowicz\AceEditorBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author azzra <azzra@users.noreply.github.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testProcessConfiguration()
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
    }
}
