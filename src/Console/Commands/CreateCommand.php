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
class CreateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'moduler:create
                            {name : module name}
                            {--A|author=John Doe : Author name}
                            {--E|email=johndoe@moduler.com : Author email address.}
                            {--D|description= : Module description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create module, can be nested. ie: parent/child/grandchil.';

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
        $variables = $this->getStubVariables();
        // Log::debug($variables);
        $this->info(__('moduler::command.create.creating', ['package' => $variables['PACKAGE']]));

        // Create directory
        $path = $this->makeDirectory($variables['LOCATION']);
        $location = implode('/', $path);
        $modulePath = $location;

        $bar = $this->output->createProgressBar(6);
        $bar->start();
        $stubPath = $this->getStubPath();

        // Composer
        $content = $this->getStubContents($stubPath . 'composer.stub', $variables);
        $this->writeContent($location . '/composer.json', $content);
        $bar->advance();

        // Phpunit test
        $content = $this->getStubContents($stubPath . 'phpunit.stub', $variables);
        $this->writeContent($location . '/phpunit.xml', $content);
        $bar->advance();

        // Readme
        $content = $this->getStubContents($stubPath . 'README.stub', $variables);
        $this->writeContent($location . '/README.md', $content);
        $bar->advance();

        $this->makeDirectory($location . '/tests', true);
        $this->writeContent($location . '/tests/.gitkeep', '');

        $location = implode('/', $this->makeDirectory($location . '/src', true));

        // Service provider
        $content = $this->getStubContents($stubPath . 'serviceprovider.stub', $variables);
        $this->writeContent($location . '/' . $variables['PROJECTNAME'] . 'ServiceProvider.php', $content);
        $bar->advance();

        // Facade Helper
        $content = $this->getStubContents($stubPath . 'module.stub', $variables);
        $this->writeContent($location . '/' . $variables['PROJECTNAME'] . '.php', $content);
        $bar->advance();
        
        // Config
        $this->makeDirectory($location . '/config', true);
        $content = $this->getStubContents($stubPath . 'config/config.stub', $variables);
        $this->writeContent($location . '/config/config.php', $content);
        $bar->advance();

        // Routes
        $this->makeDirectory($location . '/routes', true);
        $content = $this->getStubContents($stubPath . 'routes/routes.stub', $variables);
        $this->writeContent($location . '/routes/routes.php', $content);
        $bar->advance();

        // Facades
        $this->makeDirectory($location . '/Facades', true);
        $content = $this->getStubContents($stubPath . 'Facades/facade.stub', $variables);
        $this->writeContent($location . '/Facades/' . $variables['PROJECTNAME'] . '.php', $content);
        $bar->advance();

        // Exceptions
        $this->makeDirectory($location . '/Exceptions', true);
        $content = $this->getStubContents($stubPath . 'Exceptions/exception.stub', $variables);
        $this->writeContent($location . '/Exceptions/' . $variables['PROJECTNAME'] . 'Exception.php', $content);
        $bar->advance();

        // Traits
        $this->makeDirectory($location . '/Traits', true);
        $content = $this->getStubContents($stubPath . 'Traits/trait.stub', $variables);
        $this->writeContent($location . '/Traits/' . $variables['PROJECTNAME'] . 'Trait.php', $content);
        $bar->advance();

        // Command
        $this->makeDirectory($location . '/Console/Commands', true);
        $content = $this->getStubContents($stubPath . 'Console/Commands/command.stub', $variables);
        $this->writeContent($location . '/Console/Commands/' . $variables['PROJECTNAME'] . 'Command.php', $content);
        $bar->advance();

        // Controller
        $this->makeDirectory($location . '/Http/Controllers', true);
        $content = $this->getStubContents($stubPath . 'Http/Controllers/controller.stub', $variables);
        $this->writeContent($location . '/Http/Controllers/' . $variables['PROJECTNAME'] . 'Controller.php', $content);
        $bar->advance();

        // Middleware
        $this->makeDirectory($location . '/Http/Middleware', true);
        $content = $this->getStubContents($stubPath . 'Http/Middleware/middleware.stub', $variables);
        $this->writeContent($location . '/Http/Middleware/' . $variables['PROJECTNAME'] . 'Middleware.php', $content);
        $bar->advance();

        // Middleware
        $this->makeDirectory($location . '/Http/Requests', true);
        $content = $this->getStubContents($stubPath . 'Http/Requests/request.stub', $variables);
        $this->writeContent($location . '/Http/Requests/' . $variables['PROJECTNAME'] . 'Req.php', $content);
        $bar->advance();

        // Locale
        $this->makeDirectory($location . '/resources/lang/en', true);
        $content = $this->getStubContents($stubPath . 'resources/lang/en/module.stub', $variables);
        $this->writeContent($location . '/resources/lang/en/module.php', $content);
        $bar->advance();

        // Locale
        $this->makeDirectory($location . '/resources/views', true);
        $content = $this->getStubContents($stubPath . 'resources/views/demo.blade.stub', $variables);
        $this->writeContent($location . '/resources/views/demo.blade.php', $content);
        $bar->advance();

        // Locale
        $this->makeDirectory($location . '/resources/react', true);
        $content = $this->getStubContents($stubPath . 'resources/react/App.stub', $variables);
        $this->writeContent($location . '/resources/react/App.jsx', $content);
        $bar->advance();

        // Register
        $rootComposer = json_decode($this->fs->read('composer.json'), true);
        // Log::debug($rootComposer);
        // Check if module already installed.
        $bar->finish();
        $this->newLine();
        if (isset($rootComposer['require'][$variables['PACKAGE']])) {
            $this->info(__('moduler::command.create.installed', ['package' => $variables['PACKAGE']]));
        } else {
            if (!isset($rootComposer['repositories'][$variables['PACKAGE']])) {
                $rootComposer['repositories'][$variables['PACKAGE']] = [
                    'type' => 'path',
                    'url' => $modulePath
                ];
                $this->fs->write('composer.json', str_replace('\/', '/', json_encode($rootComposer, JSON_PRETTY_PRINT)));
            }
            $this->info(__('moduler::command.create.install', ['package' => $variables['PACKAGE']]));
        }
        $this->info(__('moduler::command.final_message'));
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

    /**
     * [getStubPath description]
     * @return [type] [description]
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../stubs/';
    }

    /**
     * [writeContent description]
     * @param  [type] $path    [description]
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    public function writeContent($path, $content)
    {
        $this->fs->write($path, $content);
    }

    /**
     * [getStubVariables description]
     * @return [type] [description]
     */
    public function getStubVariables()
    {
        $name = $this->argument('name');
        $split = explode('/', $name);

        $namespace = [];
        $lowercases = [];
        foreach ($split as $chunk) {
            array_push($lowercases, Str::lower($chunk));
            array_push($namespace, Str::ucfirst($chunk));
        }
        $locationWithModules = implode('/modules/', $lowercases);
        $locationWithModules = explode('/', $locationWithModules);
        $locationWithModules = array_merge([config('moduler.root')], $locationWithModules, ['src', 'resources', 'react']);
        $locationWithModules = '\'' . implode('\', \'', $locationWithModules) . '\'';

        return [
            'LOCATION' => implode('/', $lowercases),
            'NAMESPACE' => config('moduler.namespace') . '\\' . implode('', $namespace),
            'NAMESPACEDOUBLESLASH' => config('moduler.namespace') . '\\\\' . implode('', $namespace),
            'PACKAGE' => strtolower(config('moduler.namespace')) . '/' . implode('', $lowercases),
            'GROUP' => implode('/', $lowercases),
            'WEBPACK_LOCATION' => $locationWithModules,
            'FASCADE_ALIAS' => implode('', $namespace),
            'PROJECTNAME' => Str::ucfirst($split[count($split) - 1]),
            'PROJECTGROUP' => $name,
            'AUTHOR' => $this->option('author', ''),
            'EMAIL' => $this->option('email', ''),
            'DESCRIPTION' => $this->option('description', '')
        ];
    }

    /**
     * [getStubContents description]
     * @param  [type] $stub      [description]
     * @param  array  $variables [description]
     * @return [type]            [description]
     */
    public function getStubContents($stub, $variables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($variables as $seach => $replace) {
            $contents = str_replace('{{@' . $seach . '@}}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * [makeDirectory description]
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function makeDirectory($path, $skipModule = false)
    {
        $paths = explode('/', $path);
        $dirs = [];
        if($skipModule === false) {
            $dirs = [config('moduler.root')];
        }
        foreach ($paths as $index => $dir) {
            array_push($dirs, $dir);
            $location = implode('/', $dirs);
            if (! $this->fs->has($location)) {
                $this->fs->createDirectory($location);
            }
            if ($index < (count($paths) - 1) && $skipModule === false) {
                array_push($dirs, config('moduler.root'));
            }
        }

        return $dirs;
    }
}
