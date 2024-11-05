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
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        $param = [
        'role_id' => '2',
        'name' => '代表者 太郎',
        'email' => 'tarou@gmail.com',
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);

        $param = [
        'name' => 'テスト 太郎',
        'email' => 'testtarou@gmail.com',
        'password' => bcrypt('password'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);
    }
}
