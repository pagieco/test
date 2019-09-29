<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * The fixed user uuid.
     *
     * @var string
     */
    public static $id = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => static::$id,
            'name' => 'Jelle Spekken',
            'email' => 'jspekken@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);

        $user->fetchGravatar();
    }

    /**
     * Get an instance to the demo user.
     *
     * @return \App\Models\User
     */
    public static function getDemoUser(): User
    {
        return User::findOrFail(static::$id);
    }
}
