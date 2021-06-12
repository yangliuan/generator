<?php

namespace Yangliuan\Generator\Makes;

use Illuminate\Filesystem\Filesystem;
use Yangliuan\Generator\Commands\ScaffoldMakeCommand;
use Yangliuan\Generator\Validators\SchemaParser as ValidatorParser;
use Yangliuan\Generator\Validators\SyntaxBuilder as ValidatorSyntax;


class MakeController
{
    use MakerTrait;

    /**
     * Store name from Model
     *
     * @var ScaffoldMakeCommand
     */
    protected $scaffoldCommandObj;

    /**
     * Create a new instance.
     *
     * @param ScaffoldMakeCommand $scaffoldCommand
     * @param Filesystem $files
     * @return void
     */
    public function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files, string $prefix)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start($prefix);
    }

    /**
     * Start make controller.
     *
     * @return void
     */
    private function start(string $prefix)
    {
        $name = $this->scaffoldCommandObj->getObjName('Name') . 'Controller';

        $stub = '';

        if (in_array($prefix, ['api', 'admin']))
        {
            $name = ucfirst($prefix) . '/' . $name;

            if ($prefix == 'api')
            {
                $stub = '_api';
            }
            elseif ($prefix == 'admin')
            {
                $stub = '_admin';
            }
        }

        $path = $this->getPath($name, 'controller');

        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x " . $path);
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileControllerStub($stub));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    /**
     * Compile the controller stub.
     *
     * @return string
     */
    protected function compileControllerStub($stub)
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Stubs/controller' . $stub . '.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);
        // $this->replaceValidator($stub);

        return $stub;
    }


    // /**
    //  * Replace validator in the controller stub.
    //  *
    //  * @return $this
    //  */
    // private function replaceValidator(&$stub)
    // {
    //     if($schema = $this->scaffoldCommandObj->option('validator')){
    //         $schema = (new ValidatorParser)->parse($schema);
    //     }

    //     $schema = (new ValidatorSyntax)->create($schema, $this->scaffoldCommandObj->getMeta(), 'validation');
    //     $stub = str_replace('{{validation_fields}}', $schema, $stub);

    //     return $this;
    // }


}
