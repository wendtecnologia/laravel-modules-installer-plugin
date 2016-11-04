<?php
/**
 * Created by PhpStorm.
 * User: leonnleite
 * Date: 03/11/16
 * Time: 01:07
 */

namespace Wend\Composer\Test;


use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Wend\Composer\LaravelModulesInstaller;
use Wend\Composer\LaravelModulesInstallerPlugin;

class LaravelModulesInstallerPluginTest extends \PHPUnit_Framework_TestCase
{

    protected $io;
    protected $composer;
    protected $installationManager;

    public function setUp()
    {
        $this->io = $this->createMock('Composer\IO\IOInterface');
        $this->composer = new Composer();
        $this->config = new Config();
        $this->installationManager = new InstallationManager();
        $this->composer->setConfig($this->config);
        $this->composer->setInstallationManager($this->installationManager);
    }


    public function testActivate()
    {
        $laravelModuleInstallerPlugin = new LaravelModulesInstallerPlugin();
        $laravelModuleInstallerPlugin->activate($this->composer, $this->io);
        $this->assertInstanceOf(
            LaravelModulesInstaller::class,
            $this->installationManager->getInstaller('laravel-modules')
        );
    }

}