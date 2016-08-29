<?php

namespace App\Behat\Extension;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Behat\Testwork\Call\ServiceContainer\CallExtension;
use Behat\Testwork\ServiceContainer\Extension;
use PhpSpec\CodeGenerator\Writer\TokenizedCodeWriter;
use PhpSpec\Util\ClassFileAnalyser;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class Emergent implements Extension
{
    public function getConfigKey() {
        return 'emergent';
    }
    public function configure(ArrayNodeDefinition $builder) {
    }
    public function initialize(\Behat\Testwork\ServiceContainer\ExtensionManager $extensionManager) {
    }
    public function process(ContainerBuilder $container) {
    }

    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition(RunPhpSpecForClass::class, []);
        $definition->addTag(CallExtension::EXCEPTION_HANDLER_TAG, ['priority' => 50]);
        $container->setDefinition(CallExtension::EXCEPTION_HANDLER_TAG . '.spec_class', $definition);

        $definition = new Definition(RunPhpSpecForMethod::class, [
            new Reference('cli.input'),
            new Reference('cli.output'),
        ]);
        $definition->addTag(CallExtension::EXCEPTION_HANDLER_TAG, ['priority' => 55]);
        $container->setDefinition(CallExtension::EXCEPTION_HANDLER_TAG . '.spec_method', $definition);
    }
}

class RunPhpSpecForClass extends \Behat\Testwork\Call\Handler\Exception\ClassNotFoundHandler
{
    protected function handleNonExistentClass($class)
    {
        shell_exec(sprintf('phpspec desc %s', escapeshellarg($class)));
        $file = sprintf('spec/%sSpec.php', str_replace('\\', '/', $class));
        shell_exec(sprintf('phpspec run %s', $file));
    }
}

class RunPhpSpecForMethod extends \Behat\Testwork\Call\Handler\Exception\MethodNotFoundHandler
{
    private $ask;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->ask = function($question) use($input, $output) {
            return (new QuestionHelper)->ask($input, $output, new ConfirmationQuestion($question));
        };
    }

    protected function handleNonExistentMethod(array $callable)
    {
        list($class, $method) = $callable;
        $spec = sprintf('spec\\%sSpec', $class);
        $example = "its_${method}_does_stuff";

        if (method_exists($spec, $example)) {
            return ;
        }
        if (!($this->ask)("Create $spec::$example ? [Y/n]")) {
            return;
        }
        $file = sprintf('spec/%sSpec.php', str_replace('\\', '/', $class));

        $editor = new TokenizedCodeWriter(new ClassFileAnalyser());
        $code = file_get_contents($file);
        $code = $editor->insertMethodLastInClass($code, <<<PHP
    function $example() {
        \$this->$method();
    }
PHP
        );
        file_put_contents($file, $code);

        passthru(sprintf('phpspec run %s', $file));
    }
}

