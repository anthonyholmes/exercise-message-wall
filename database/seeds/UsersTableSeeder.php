<?php

use App\Message;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($u) {
            $u->messages()->save(factory(Message::class)->make());
            $u->messages()->save(factory(Message::class)->make());
        });
    }
}
