<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategoryProductSeeder;
use Database\Seeders\WishlistSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            RolePermissionSeeder::class,
            ProductSeeder::class,
            CategoryProductSeeder::class, 
            WishlistSeeder::class, 
        ]);
        \App\Models\User::factory(20)->create()->each(function ($user) {
        // Assign the 'default' role to each user instance
            if($user->id==8){
                $user->assignRole(['super-admin','admin', 'default']);
            }else if($user->id==6){
                $user->assignRole(['admin', 'default']);
            }else{
                $user->assignRole(['default']);
            }
        });
    }
}
