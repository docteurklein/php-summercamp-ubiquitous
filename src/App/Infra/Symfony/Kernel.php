<?php declare(strict_types=1);

namespace App\Infra\Symfony;

use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Debug;
use Symfony\Bundle\FrameworkBundle\Console\Application;


class Kernel extends HttpKernel\Kernel implements BundleInterface, CompilerPassInterface
{
    public function __construct($env = 'prod', $debug = false)
    {
        if ($debug) {
            Debug::enable();
        }
        AnnotationRegistry::registerLoader('class_exists');
        parent::__construct($env, $debug);
    }

    public function __invoke(Request $request = null)
    {
        $request = $request ?: Request::createFromGlobals();
        $response = $this->handle($request);
        $response->send();
        $this->terminate($request, $response);
    }

    public function console()
    {
        $app = new Application($this);
        $app->setAutoExit(false);
        $exitCode = $app->run();

        if ($this->container->has('profiler')) {
            $profiler = $this->container->get('profiler');
            $request = new Request;
            $response = new Response;
            $profile = $profiler->collect($request, $response);
            $profiler->saveProfile($profile);
            echo 'profile: ', $profile->getToken(), "\n";
        }

        return $exitCode;
    }

    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle,
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle,
            new \JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new \JMS\SerializerBundle\JMSSerializerBundle(),
            new \JMS\AopBundle\JMSAopBundle,
            new \FOS\RestBundle\FOSRestBundle,
            new \Knp\Rad\DomainEvent\Bundle\DomainEventBundle,
            $this,
        );

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new \Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }
        if (in_array($this->getEnvironment(), ['test'])) {
            $bundles[] = new \DocteurKlein\TestDoubleBundle;
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/Resources/config/config_'.$this->getEnvironment().'.yml');
        $local = $this->getRootDir().'/Resources/config/config_'.$this->getEnvironment().'.local.yml';
        if (file_exists($local)) {
            $loader->load($local);
        }

        $envParameters = $this->getEnvParameters();
        $loader->load(function($container) use($envParameters) {
            $container->getParameterBag()->add($envParameters);
        });
    }

    public function getCacheDir()
    {
        return (getenv('SYMFONY_CACHE_DIR') ?: __DIR__.'/../../../cache/').$this->environment;
    }

    public function getLogDir()
    {
        return getenv('SYMFONY_LOGS_DIR') ?: __DIR__.'/../../../logs';
    }

    protected function getKernelParameters()
    {
        return array_merge(parent::getKernelParameters(), [
            'project.root_dir' => realpath(__DIR__.'/../../..'),
        ]);
    }

    public function boot()
    {
        if (true === $this->booted) {
            return;
        }

        $this->initializeBundles();

        $this->initializeContainer();

        foreach ($this->getBundles() as $bundle) {
            $bundle->setContainer($this->container);
            if ($bundle !== $this) {
                $bundle->boot();
            }
        }

        $this->booted = true;
    }

    public function shutdown()
    {
        if (false === $this->booted) {
            return;
        }

        $this->booted = false;

        foreach ($this->getBundles() as $bundle) {
            if ($bundle !== $this) {
                $bundle->shutdown();
            }
            $bundle->setContainer(null);
        }

        $this->container = null;
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass($this, PassConfig::TYPE_BEFORE_REMOVING);
    }

    public function getContainerExtension()
    {
    }

    public function getParent()
    {
    }

    public function getName()
    {
        return 'App';
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getPath()
    {
        return __DIR__;
    }

    public function process(ContainerBuilder $container)
    {
        $doctrine = $container->get('doctrine');
        $factory = $doctrine->getManager()->getMetadataFactory();

        foreach ($factory->getAllMetadata() as $metadata) {
            $def = new Definition('Doctrine\Common\Persistence\ObjectRepository');
            $def->setFactory([new Reference('doctrine'), 'getRepository']);
            $def->setArguments([$metadata->name]);
            $id = 'repo.'.str_replace('\\', '_', $metadata->name);
            $container->setDefinition($id, $def);
        }
        foreach ($container->findTaggedServiceIds('repository') as $id => $configs) {
            $def = $container->getDefinition($id);
            foreach ($configs as $config) {
                $metadata = $factory->getMetadataFor($config['for']);
                $metadata->customRepositoryClassName = $def->getClass();
                $container->setAlias($id, 'repo.'.str_replace('\\', '_', $config['for']));
            }
        }
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
