<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id'=>'1',
            'name'=>'Md. Admin',
            'username'=>'admin',
            'email'=>'admin@blog.com',
            'password'=>bcrypt('admin123'),
        ]);
        DB::table('users')->insert([
            'role_id'=>'2',
            'name'=>'Md. Author',
            'username'=>'author',
            'email'=>'author@blog.com',
            'password'=>bcrypt('author123'),
        ]);
       // factory(App\User::class,15)->create();
    }
}