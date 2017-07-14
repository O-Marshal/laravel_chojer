<?php

namespace Ckryo\Laravel\App\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个新的控制器';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * 获取控制器模板
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('base')) {
            return __DIR__.'/stubs/controller.plain.stub';
        }

        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * 命名空间
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Controllers';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['base', 'b', InputOption::VALUE_OPTIONAL, '是否创建一个空的控制器']
        ];
    }
}
