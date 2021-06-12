<?php

namespace Yangliuan\Generator\Makes;

use Illuminate\Filesystem\Filesystem;
use Yangliuan\Generator\Commands\ScaffoldMakeCommand;
use Yangliuan\Generator\Validators\SchemaParser as ValidatorParser;
use Yangliuan\Generator\Validators\SyntaxBuilder as ValidatorSyntax;

class MakeApiRequest
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
    private function start($prefix = '')
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');

        $this->makeRequest('ApiRequest', 'request_api');

        if ($prefix == 'admin')
        {
            $name = 'Admin/' . $name;
            $stubname = 'request_admin_model';
        }
        else
        {
            $name = 'Api/' . $name;
            $stubname = 'request_api_model';
        }

        $this->makeRequest($name . 'Request', $stubname);
    }

    protected function makeRequest($name, $stubname)
    {
        $path = $this->getPath($name, 'request');

        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x $path" . ' (Skipped)');
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub($stubname));

        $this->scaffoldCommandObj->info('+ ' . $path);
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
