<?php

namespace Aldev\Moduler\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aldev\Moduler\Facades\Moduler;
use Aldev\Moduler\Models\ModuleModel;

/**
 * The ModulerController class.
 *
 * @package aldev/moduler
 * @author  Al Lestaire Acasio <allestaire.acasio@gmail.com>
 */
class ModulerController extends Controller
{
    public function demo()
    {
        return view('moduler::demo');
    }
}
