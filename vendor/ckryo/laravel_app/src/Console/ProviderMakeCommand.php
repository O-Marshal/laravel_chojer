<?php

namespace Ckryo\Laravel\App\Console;

use Illuminate\Console\GeneratorCommand;

class ProviderMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个新的服务提供者';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * 获取控制器模板
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/provider.stub';
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $rootNamespace = $this->rootNamespace();

        return $rootNamespace . $name;
    }
}
