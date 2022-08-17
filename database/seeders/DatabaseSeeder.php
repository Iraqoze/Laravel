<?php

namespace Database\Seeders;
 use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //\App\Models\User::factory(10)->create();

$user=User::factory()->create([
'name'=>'Dear Boy',
'email'=>'dear@gmail.com'
]);

        \App\Models\Listing::factory(15)->create([
            'user_id'=>$user->id
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
