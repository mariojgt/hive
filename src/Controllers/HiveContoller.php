<?php

namespace Mariojgt\Hive\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HiveContoller extends Controller
{
    public function composerUpdate()
    {
        shell_exec("cd ../ && composer update");
        return 'Site Updated';
    }
    // This is jsut a example
    public function downloadPackage()
    {
        // Create the folder
        shell_exec("cd ../ && mkdir packages");
        // Do a github request and download the package
        $url = 'https://api.github.com/repos/mariojgt/larabit/zipball/main';
        $response = Http::get($url, [
            'access_token' => '13874754f64a08a033e4deed8f7c39fc2f7d0b95',
        ]);
        // Path where to save the file
        $path = base_path('packages');
        // Get the file
        $file = $response->body();
        // Create the file
        file_put_contents($path . '/my.zip', $file);
        dd('here');
        return redirect()->back()->withMessage([
            'type'    => 'success',
            'message' => 'Packages updated with success'
        ]);
    }
}
