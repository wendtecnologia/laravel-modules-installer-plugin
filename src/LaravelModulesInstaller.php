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
        $module = explode('/',$package);
        if (strstr(array_pop(explode('/',$module)),'-',true) !== 'module') {
            throw new \InvalidArgumentException(
                'Unable to install module, laravel modules '
                .'should always start their package name with '
                .'"<vendor>/module-"'
            );
        }

        return 'app/Modules'.substr($package->getPrettyName(), 23);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'laravel-modules' === $packageType;
    }
}
