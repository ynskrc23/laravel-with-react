<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsPage;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPagesRecords = [
            [
                'id'=>1,
                'title'=>'about us',
                'description'=>'deneme',
                'url'=>'about-us',
                'meta_title'=>'about us',
                'meta_description'=>'about us',
                'meta_keywords'=>'about, us, karaca',
                'status'=>1
            ],
            [
                'id'=>2,
                'title'=>'deneme us',
                'description'=>'test',
                'url'=>'deneme-us',
                'meta_title'=>'yest us',
                'meta_description'=>'test us',
                'meta_keywords'=>'about, us, test',
                'status'=>1
            ],
        ];

        CmsPage::insert($cmsPagesRecords);
    }
}
