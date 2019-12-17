<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use App\Domains\Asset\Models\Asset;
use App\Domains\Project\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Domains\Asset\Models\AssetFolder;

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
        'asset_folder_id' => factory(AssetFolder::class)->create()->local_id,
        'filename' => $filename,
        'extension' => $extension,
        'mime_type' => $faker->mimeType,
        'file_size' => $faker->randomNumber(),
        'path' => $path,
    ];
});
