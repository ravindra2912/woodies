<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminMember;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\AdminManagenent;
use App\Models\LegalPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LegalPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        LegalPage::create([
            'page_type' => 'PrivacyPolicy',
            'description' => '<p>Privacy Policy</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'TermsAndCondition',
            'description' => '<p>Terms And Condition</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'CopyRight',
            'description' => '<p>Copy right</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'AboutUs',
            'description' => '<p>AboutUs</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'RefundPolicy',
            'description' => '<p>RefundPolicy</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'ReturnPolicy',
            'description' => '<p>ReturnPolicy</p>',
        ]);

        LegalPage::create([
            'page_type' => 'ShippingPolicy',
            'description' => '<p>ShippingPolicy</p>',
        ]);
        
        LegalPage::create([
            'page_type' => 'CancellationPolicy',
            'description' => '<p>CancellationPolicy</p>',
        ]);
    
    }
}
