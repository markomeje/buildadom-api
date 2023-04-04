<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\{Role, User};

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('roles')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $roles = ['admin', 'customer', 'marchant'];
    foreach ($roles as $role) {
      Role::create([
        'name' => $role,
        'user_id' => rand(1, User::count()),
      ]);
    }
  }
}
