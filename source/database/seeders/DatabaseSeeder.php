<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->command->getOutput()->writeln('기본 유저 등록');
        User::factory()->create([
            'name' => '아이디어스',
            'nickname' => 'idus',
            'email' => 'homework@gmail.com',
        ]);

        $this->command->getOutput()->writeln('임의 유저 등록');
        $this->call(UserSeed::class);
    }
}
