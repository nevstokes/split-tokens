<?php

namespace App;

use League\Tactician\Bundle\TacticianBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @var string
     */
    private $configDir;

    public function __construct(
        ?string $environment = null,
        ?bool $debug = null,
        string $configDir = 'config'
    ) {
        $environment = $environment ?? Environment::DEV;
        $debug = $debug ?? Environment::DEV === $environment;
        parent::__construct($environment, $debug);

        $this->configDir = $configDir;
    }

    public function getConfigDir(): string
    {
        return $this->configDir;
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        $bundles = [
            new FrameworkBundle(),
            new SensioFrameworkExtraBundle(),
            new TacticianBundle(),
            new TwigBundle(),
        ];

        if (Environment::DEV === $this->getEnvironment()) {
            $bundles[] = new WebProfilerBundle();
        }

        return $bundles;
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader): void
    {
        $resourcePath = $this->locateEnvSpecificResource('config.yaml');
        $loader->load($resourcePath);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $resourcePath = $this->locateEnvSpecificResource('routing.yaml');
        $routes->import($resourcePath);
    }

    private function locateEnvSpecificResource(string $filename): string
    {
        $pathinfo = pathinfo($filename);

        return sprintf(
            '%s/../%s/%s_%s.%s',
            __DIR__,
            $this->getConfigDir(),
            $pathinfo['filename'],
            $this->getEnvironment(),
            $pathinfo['extension']
        );
    }
}
