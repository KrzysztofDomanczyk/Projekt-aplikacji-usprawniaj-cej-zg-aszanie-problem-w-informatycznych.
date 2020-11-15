<?php

use App\User;
use Carbon\Carbon;
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
        // $user  = User::find(Auth::id());
  
        // $user->projects()->attach(1);
        $user  = User::find(1);
        $user->projects()->attach(1);

        DB::table('users')->insert([
            'name' => 'Krzys12312312312iek',
            'email' => 'kylo199721312312120@gmail.com',
            'password' => Hash::make('123456789'),
            'host_imap' => 'imap.gmail.com',
            'username_imap' => 'ithelperdomanczyk@gmail.com',
            'password_imap' => 'Krzysiek123456',
        ]);

        DB::table('tickets')->insert([
            'name' => Str::random(10),
            'description' => Str::random(50),
            'body_mail' => Str::random(2220),
            'status' => 'To do',
            'subject_mail' => Str::random(20),
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today(),
            'project_id' => '1',
            'creator_id' => 1,
        ]);

        $faker = Faker\Factory::create();
        DB::table('ticket_messages')->insert([
            'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            'sender_email' => $faker->freeEmail(),
            'created_at' => Carbon::now()->addMinutes(2)->format('Y-m-d H:i:s'),
            'ticket_id' => 1,
        ]);


        DB::table('ticket_messages')->insert([
            'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            'sender_email' => $faker->freeEmail(),
            'created_at' => Carbon::now()->addMinutes(4)->format('Y-m-d H:i:s'),
            'ticket_id' => 1,
        ]);

        DB::table('ticket_messages')->insert([
            'content' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            'sender_email' => $faker->freeEmail(),
            'created_at' => Carbon::now()->addMinutes(6)->format('Y-m-d H:i:s'),
            'ticket_id' => 1,
        ]);

        DB::table('notifications')->insert([
            'content' => $faker->realText($maxNbChars = 30, $indexSize = 2),
            'target' => $faker->url(),
            'created_at' => Carbon::now()->addMinutes(6)->format('Y-m-d H:i:s'),
            'seen' => true,
            'user_id' => 1,
        ]);

        DB::table('notifications')->insert([
            'content' => $faker->realText($maxNbChars = 30, $indexSize = 2),
            'target' => $faker->url(),
            'created_at' => Carbon::now()->addMinutes(6)->format('Y-m-d H:i:s'),
            'seen' => false,
            'user_id' => 1,
        ]);
    }
}
