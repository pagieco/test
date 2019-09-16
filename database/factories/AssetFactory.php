<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Asset;
use App\Models\Project;
use Illuminate\Support\Str;
use App\Models\AssetFolder;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$factory->define(Asset::class, function (Faker $faker) {
    Storage::fake();

    $project = factory(Project::class)->create();

    $extension = $faker->fileExtension;
    $filename = sprintf('%s.%s', $faker->word, $extension);

    $path = UploadedFile::fake()
        ->image($filename)
        ->storePubliclyAs($project->hash, $filename);

    return [
        'hash' => Str::random(),
        'project_id' => $project->id,
        'asset_folder_id' => factory(AssetFolder::class)->create(),
        'filename' => $filename,
        'extension' => $extension,
        'mimetype' => $faker->mimeType,
        'filesize' => $faker->randomNumber(),
        'path' => $path,
    ];
});
