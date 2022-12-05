<?php

use App\Imports\LocationsImport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Excel;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seed-locations', function () {
    $this->comment('Seeding locations from database/catalogs/locations.csv...');
    (new LocationsImport())->import(database_path('catalogs/locations.csv'), null, Excel::CSV);
    $this->comment('Completed.');
})->purpose('Seed locations');
