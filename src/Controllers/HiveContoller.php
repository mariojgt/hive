<?php

namespace Mariojgt\Hive\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Mariojgt\Hive\Models\InstalledPackages;

class HiveContoller extends Controller
{
    protected $gitEndPoint;

    public function __construct()
    {
        $this->gitEndPoint = 'https://api.github.com';
    }

    public function composerUpdate()
    {
        shell_exec("cd ../ && composer update");
        return 'Site Updated';
    }

    public function syncPackages()
    {
        // Run compoer update
        $this->composerUpdate();
        // Delte the install packages model and create again
        InstalledPackages::truncate();
        // Find the composer file
        $file = json_decode(file_get_contents(base_path('composer.json')), true);

        // Loop true the composer required
        foreach ($file['require'] as $key => $package) {
            $packagePath = explode('/', $key);
            if (!empty($packagePath[1])) {
                $packageVendor = $packagePath[0];
                $packageName   = $packagePath[1];
                // Request the info
                $packageInfo   = $this->packageInfo($packageVendor, $packageName);
                // Request the versions
                $packageTag    = $this->packageVersion($packageVendor, $packageName);

                // Request the last commit info
                if (empty($packageTag[0]->commit->url)) {
                    $lastCommit = 'No Info';
                } else {
                    $lastCommit = $this->commitInfo($packageTag[0]->commit->url);
                }

                // Create in the database
                InstalledPackages::updateOrCreate([
                    'package_name' => $key,
                    'version'      => $packageTag[0]->name ?? $package,
                ], [
                    'package_name'  => $key,
                    'name'          => $packageInfo->name ?? $key . ' Private',
                    'version'       => $packageTag[0]->name ?? $package,
                    'update_note'   => $lastCommit->commit->message ?? '',
                    'github_author' => $packageVendor,
                    'github_repo'   => $packageName,
                ]);
            }
        }
    }

    public function packageInfo($owner, $package)
    {
        // Do a github request and download the package
        $url = "$this->gitEndPoint/repos/$owner/$package";

        // Try the request
        $response = Http::get($url, [
            'access_token' => config('githubToken.token'),
        ]);
        // Check for sucess request
        if ($response->successful()) {
            return json_decode($response->body());
        } else {
            return 'Error';
        }
    }

    public function packageVersion($owner, $package)
    {
        // Do a github request and download the package
        $url = "$this->gitEndPoint/repos/$owner/$package/tags";

        // Try the request
        $response = Http::get($url, [
            'access_token' => config('githubToken.token'),
        ]);
        // Check for sucess request
        if ($response->successful()) {
            return json_decode($response->body());
        } else {
            return 'Error';
        }
    }

    public function commitInfo($url)
    {
        // Note that in here the url alread comes ready
        // Try the request
        $response = Http::get($url, [
            'access_token' => config('githubToken.token'),
        ]);
        // Check for sucess request
        if ($response->successful()) {
            return json_decode($response->body());
        } else {
            return false;
        }
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
            $zip->close();
        } else {
            return 'Zip File missing or corrupted';
        }

        // Delete the original zip file
        unlink($path);

        // Return True
        return 'Packages updated with success';
    }
}
