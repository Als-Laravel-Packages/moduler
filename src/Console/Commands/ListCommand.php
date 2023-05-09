<?php

namespace Aldev\Moduler\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
// use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter as Local;
use Log;

/**
 * The DemoCommand class.
 *
 * @package aldev/moduler
 * @author  Al Lestaire Acasio <allestaire.acasio@gmail.com>
 */
class ListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'moduler:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of registered and installed modules.';

    /**
     * [$files description]
     * @var [type]
     */
    protected $fs;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $path = preg_replace('/\/public$/', '', public_path());
        $adapter = new Local($path);
        $this->fs = new Filesystem($adapter);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $composer = $this->fs->read('composer.json');
        $composer = json_decode($composer, true);
        $require = $composer['require'];
        $repositories = $composer['repositories'];

        $modules = [];

        foreach (array_keys($require) as $index => $module) {
            if (Str::startsWith($module, 'module')) {
                if (!isset($modules[$module])) {
                    $modules[$module] = [
                        'installed' => true,
                        'registered' => false
                    ];
                }
            }
        }

        foreach (array_keys($repositories) as $index => $module) {
            if (Str::startsWith($module, 'module')) {
                if (!isset($modules[$module])) {
                    $modules[$module] = [
                        'installed' => false,
                        'registered' => true
                    ];
                } else {
                    $modules[$module]['registered'] = true;
                }
            }
        }
        $headers = [
            'Module', 'Registered', 'Installed'
        ];
        $data = [];
        foreach ($modules as $module => $value) {
            array_push($data, [
                'module' => $module,
                'registered' => $value['registered'] ? 'true' : 'false',
                'installed' => $value['installed'] ? 'true' : 'false',
            ]);
        }
        $this->table($headers, $data);
    }

    /**
     * Th alias of the fire() method.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fire();
    }
}
