<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebSetting;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebSetting::updateOrCreate(
            ['id' => 1],
            [
                'village_name' => 'TULUNGREJO',
                'subdistrict' => 'BUMIAJI',
                'city' => 'BATU',
                'province' => 'JAWA TIMUR',
                'address' => 'Jl. Pangeran Diponegoro No.04, Tulungrejo, Kec. Bumiaji, Kota Batu, Jawa Timur 65336',
                'logo_path' => 'images/web-settings/logo.png',
                'favicon_path' => 'images/web-settings/icon-tab.png',
                'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63247.51394244399!2d112.48909845018346!3d-7.793041110022066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e787e9ca033bae9%3A0x25ba2f886ca3318d!2sTulungrejo%2C%20Kec.%20Bumiaji%2C%20Kota%20Batu%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1782305890569!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
                'phone' => '082336724454',
                'email' => null,
                'facebook' => null,
                'instagram' => null,
                'youtube' => null,
                'twitter' => null,
            ]
        );
    }
}
