<?php

namespace Wend\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class LaravelModulesInstallerPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new LaravelModulesInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
