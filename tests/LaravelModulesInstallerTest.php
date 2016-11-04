<?php
/**
 * Created by PhpStorm.
 * User: leonnleite
 * Date: 03/11/16
 * Time: 00:30
 */

namespace Wend\Composer\Test;


use Composer\Composer;
use Composer\Config;
use Composer\Util\Silencer;
use Wend\Composer\LaravelModulesInstaller;

class LaravelModulesInstallerTest extends \PHPUnit_Framework_TestCase
{

    protected $io;
    protected $composer;
    protected $config;
    protected $rootDir;
    protected $vendorDir;


    protected static function getUniqueTmpDirectory()
    {
        $attempts = 5;
        $root = sys_get_temp_dir();

        do {
            $unique = $root . DIRECTORY_SEPARATOR . uniqid('composer-test-' . rand(1000, 9000));

            if (!file_exists($unique) && Silencer::call('mkdir', $unique, 0777)) {
                return realpath($unique);
            }
        } while (--$attempts);

        throw new \RuntimeException('Failed to create a unique temporary directory.');
    }

    protected function createPackageMock()
    {
        return $this->getMockBuilder('Composer\Package\Package')
            ->setConstructorArgs(array(md5(mt_rand()), '1.0.0.0', '1.0.0'))
            ->getMock();
    }

    public function setUp()
    {
        $this->io = $this->createMock('Composer\IO\IOInterface');
        $this->composer = new Composer();
        $this->config = new Config();
        $this->composer->setConfig($this->config);

        $this->rootDir = $this->getUniqueTmpDirectory();
        $this->vendorDir = $this->rootDir . DIRECTORY_SEPARATOR . 'vendor';
    }

    public function testSupport()
    {
        $laravelModule = new LaravelModulesInstaller($this->io, $this->composer);
        $this->assertTrue($laravelModule->supports('laravel-modules'));
    }

    public function testGetInstallPath()
    {
        $library = new LaravelModulesInstaller($this->io, $this->composer);
        $package = $this->createPackageMock();

        $package
            ->expects($this->any())
            ->method('getPrettyName')
            ->will($this->returnValue('foo/module-bar'));

        $this->assertEquals('app/Modules/Bar', $library->getInstallPath($package));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInstallWillThrowExceptionNameWithNoModule()
    {
        $library = new LaravelModulesInstaller($this->io, $this->composer);
        $package = $this->createPackageMock();

        $package
            ->expects($this->any())
            ->method('getPrettyName')
            ->will($this->returnValue('foo/bar'));

        $library->getInstallPath($package);
    }

}