<?php
namespace ViralsInfyom\ViralsPermission\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ViralsInfyom\ViralsPermission\Models\Role;
use ViralsInfyom\ViralsPermission\Models\Permission;
use ViralsInfyom\ViralsPermission\Models\ViralsUser;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        // import from dump.sql
        $path = base_path('database/sql/permissions.sql');
        $sql = file_get_contents($path);

        DB::unprepared($sql);

        $this->command->info('Permissions table seeded!');

        $permissions = Permission::all();

        $role = Role::create(['name' => 'SuperAdmin']);
        $role->permissions()->attach($permissions->pluck('id')->toArray());

        $this->command->info('Roles table seeded!');

        $user = ViralsUser::create([
            'name' => 'Admin ViralSoft',
            'email' => 'admin@viralsoft.vn',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'), // password
            'remember_token' => Str::random(10),
        ]);

        $user->roles()->attach([$role->id]);

        $this->command->info('Users table seeded!');
        $this->command->info('Email : admin@viralsoft.vn');
        $this->command->info('Password : 123456789');
    }
}
