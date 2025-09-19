<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\Seeder;

class TestPackageSeeder extends Seeder
{
    public function run()
    {
        // Get first category (wedding)
        $category = Category::where('slug', 'wedding')->first();
        
        if (!$category) {
            echo "No wedding category found. Please run CategorySeeder first.\n";
            return;
        }

        // Create test package
        Package::firstOrCreate([
            'category_id' => $category->id,
            'slug' => 'test-wedding-package'
        ], [
            'title' => 'Test Wedding Package',
            'price' => 500000,
            'duration_minutes' => 180,
            'description' => "• Bridal makeup & hair styling\n• 3 jam sesi\n• Touch-up kit\n• Photo ready finish",
            'status' => 'active'
        ]);

        echo "Test package created successfully!\n";
    }
}