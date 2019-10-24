<?php

use Illuminate\Database\Seeder;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionField;
use App\Domains\Collection\Models\CollectionEntry;
use App\Domains\Collection\Enums\CollectionFieldType;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createArticlesCollection();
        $this->createAuthorsCollection();
    }

    protected function createArticlesCollection()
    {
        $collection = new Collection([
            'name' => 'Articles',
            'slug' => 'articles',
        ]);

        $collection->project()->associate(ProjectsTableSeeder::getWildcatsProject());
        $collection->save();

        $fields = [
            [
                'slug' => 'post-body',
                'display_name' => 'Post Body',
                'type' => CollectionFieldType::PlainText,
            ],
            [
                'slug' => 'post-summary',
                'display_name' => 'Post Summary',
                'type' => CollectionFieldType::PlainText,
            ],
            [
                'slug' => 'main-image',
                'display_name' => 'Main Image',
                'type' => CollectionFieldType::Image,
            ],
            [
                'slug' => 'thumbnail-image',
                'display_name' => 'Thumbail Image',
                'type' => CollectionFieldType::Image,
            ],
            [
                'slug' => 'featured',
                'display_name' => 'Featured?',
                'type' => CollectionFieldType::Switch,
            ],
        ];

        foreach ($fields as $field) {
            $collectionField = new CollectionField($field);

            $collectionField->project()->associate(ProjectsTableSeeder::getWildcatsProject());
            $collectionField->collection()->associate($collection);

            $collectionField->save();
        }

        $entries = [];

        for ($i = 0; $i < 50; $i++) {
            $entries[] = [
                'name' => 'Hello World '.$i,
                'slug' => 'hello-world-'.$i,
                'entry_data' => [
                    'post-body' => faker()->text,
                    'post-summary' => faker()->text(50),
                    'featured' => faker()->boolean,
                ],
            ];
        }

        foreach ($entries as $entry) {
            $collectionEntry = new CollectionEntry($entry);

            $collectionEntry->project()->associate(ProjectsTableSeeder::getWildcatsProject());
            $collectionEntry->collection()->associate($collection);

            $collectionEntry->save();
        }
    }

    protected function createAuthorsCollection()
    {
        $collection = new Collection([
            'name' => 'Authors',
            'slug' => 'authors',
        ]);

        $collection->project()->associate(ProjectsTableSeeder::getWildcatsProject());
        $collection->save();

        $fields = [
            [
                'slug' => 'bio',
                'display_name' => 'Bio',
                'type' => CollectionFieldType::PlainText,
            ],
            [
                'slug' => 'bio-summary',
                'display_name' => 'Bio Summary',
                'type' => CollectionFieldType::PlainText,
            ],
            [
                'slug' => 'picture',
                'display_name' => 'Picture',
                'type' => CollectionFieldType::Image,
            ],
            [
                'slug' => 'email',
                'display_name' => 'Email',
                'type' => CollectionFieldType::PlainText,
            ],
        ];

        foreach ($fields as $field) {
            $collectionField = new CollectionField($field);

            $collectionField->project()->associate(ProjectsTableSeeder::getWildcatsProject());
            $collectionField->collection()->associate($collection);

            $collectionField->save();
        }

        $entries = [];

        for ($i = 0; $i < 50; $i++) {
            $entries[] = [
                'name' => 'Author '.$i,
                'slug' => 'author-'.$i,
                'entry_data' => [
                    'bio' => faker()->text,
                    'bio-summary' => faker()->text(50),
                    'email' => faker()->email,
                ],
            ];
        }

        foreach ($entries as $entry) {
            $collectionEntry = new CollectionEntry($entry);

            $collectionEntry->project()->associate(ProjectsTableSeeder::getWildcatsProject());
            $collectionEntry->collection()->associate($collection);

            $collectionEntry->save();
        }
    }
}
