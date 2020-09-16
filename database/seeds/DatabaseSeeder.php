<?php

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
        DB::table('projects')->insert([
            'name' => Str::random(10),
            'description' => Str::random(22),
            'creator_id' => 1,
           
        ]);

        DB::table('users')->insert([
            'name' => 'Krzysiek',
            'email' => 'kylo1997120@gmail.com',
            'password' => Hash::make('123456789'),
            'host_imap' => 'imap.gmail.com',
            'username_imap' => 'ithelperdomanczyk@gmail.com',
            'password_imap' => 'Krzysiek123456',
        ]);
        DB::table('users')->insert([
            'name' => 'Krzys12312312312iek',
            'email' => 'kylo199721312312120@gmail.com',
            'password' => Hash::make('123456789'),
            'host_imap' => 'imap.gmail.com',
            'username_imap' => 'ithelperdomanczyk@gmail.com',
            'password_imap' => 'Krzysiek123456',
        ]);
    }
}
