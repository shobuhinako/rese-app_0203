<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'role_id' => '1',
        'name' => '管理者 太郎',
        'email' => 'admin@gmail.com',
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        $param = [
        'role_id' => '2',
        'name' => '代表者 太郎',
        'email' => 'hinako0714disney24@gmail.com',
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        $param = [
        'role_id' => '2',
        'name' => '代表者 次郎',
        'email' => 'jirou@gmail.com',
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        $param = [
        'role_id' => '2',
        'name' => '代表者 三郎',
        'email' => 'sabrou@gmail.com',
        'email_verified_at' => Carbon::now(),
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);
    }
}
