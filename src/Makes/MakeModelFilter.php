<?php

namespace Yangliuan\Generator\Makes;

use Illuminate\Filesystem\Filesystem;
use Yangliuan\Generator\Commands\ScaffoldMakeCommand;

class MakeModelFilter
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
        //检测是否安装tucker-eric/eloquentfilter 扩展包
        if (strpos(\file_get_contents('./composer.json'), 'tucker-eric/eloquentfilter') === false)
        {
            return;
        }

        $name = $this->scaffoldCommandObj->getObjName('Name');

        if ($prefix == 'admin')
        {
            $name = 'Admin\\' . $name;
        }
        elseif ($prefix == 'api')
        {
            $name = 'Api\\' . $name;
        }

        // $info = $this->scaffoldCommandObj->callSilent('model:filter', [
        //     'name' => $name,
        // ]);

        //shell 调用不终止当前进程
        $info = system('php artisan model:filter ' . $name);

        if (strpos($info, 'Successfully') !== false)
        {
            $this->scaffoldCommandObj->info('+ ' . config('eloquentfilter.namespace', 'App\\ModelFilters\\') . $name);
        }
        else
        {
            $this->scaffoldCommandObj->info('x ' . config('eloquentfilter.namespace', 'App\\ModelFilters\\') . $name . ' (Skipped)');
        }
    }
}
