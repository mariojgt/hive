<?php

namespace Mariojgt\Hive\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use ZipArchive;

class HiveContoller extends Controller
{
    public function composerUpdate()
    {
        shell_exec("cd ../ && composer update");
        return 'Site Updated';
    }

    // This is just a example
    public function downloadPackage()
    {
        $owner   = 'mariojgt';
        $package = 'larabit';
        // Ref normaly is master|main|TAG NUMBER
        $ref = 'main';

        // Create the folder
        shell_exec("cd ../ && mkdir packages");

        // Do a github request and download the package
        $url = "https://api.github.com/repos/$owner/$package/zipball/$ref";

        $response = Http::get($url, [
            'access_token' => config('githubToken.token'),
        ]);

        // Path where to save the file
        $path        = base_path('packages/my.zip');
        $extractPath = base_path('packages');

        // Get the file
        $file = $response->body();

        // Create the file
        file_put_contents($path, $file);

        // Unzip the file
        $zip = new ZipArchive;
        if ($zip->open($path) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->renameIndex(2, 'larabit');
            $zip->close();
            echo 'ok';
        } else {
            echo 'failed';
        }

        // Delete the original zip file
        unlink($path);

        // Return True
        return 'Packages updated with success';
    }
}
