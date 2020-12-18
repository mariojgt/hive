<?php

namespace Mariojgt\Hive\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstalledPackages extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'name',
        'version',
        'github_author',
        'github_repo',
        'update_note',
    ];
}
