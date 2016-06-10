<?php

namespace Wend\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class LaravelModulesInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $name = $package->getName();
        $module = explode('/',$name);
        if (strstr(array_pop($module),'-',true) !== 'module') {
            throw new \InvalidArgumentException(
                'Unable to install module, laravel modules '
                .'should always start their package name with '
                .'"<vendor>/module-"'
            );
        }

        return 'app/Modules/'.$package->getPrettyName();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'laravel-modules' === $packageType;
    }
}
