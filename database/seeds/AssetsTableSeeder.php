<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use App\Domains\Asset\Models\Asset;
use Symfony\Component\Finder\Finder;

class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Throwable
     */
    public function run()
    {
        $project = ProjectsTableSeeder::getWildcatsProject();

        foreach ($this->getSeedFiles() as $fileInfo) {
            $base = new UploadedFile($fileInfo->getPathName(), $fileInfo->getBaseName());

            $file = UploadedFile::createFromBase($base);

            $asset = tap(Asset::upload($file, $project))->save();

            $asset->update(['mime_type' => 'image/jpeg']);

            $asset->createThumbnail();
        }
    }

    protected function getSeedFiles()
    {
        $finder = new Finder;

        $finder->files()->in(database_path('seeds/seed-resources/assets'));

        if (! $finder->hasResults()) {
            throw new Exception('No seed-resources found.');
        }

        $files = [];

        foreach ($finder as $file) {
            $files[] = $file;
        }

        return $files;
    }
}
