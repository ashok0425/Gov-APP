<?php

namespace Database\Seeders;

use App\Models\Cms;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Site settings are a single row that CmsController looks up by id 1,
        // so a fresh install needs it to exist before that screen will open.
        $cms = Cms::find(1) ?: new Cms;
        $cms->id = 1;
        $cms->meta_title = 'बारबर्दिया नगरपालिका';
        $cms->meta_description = $cms->meta_description ?: 'बारबर्दिया नगरपालिकाको आधिकारिक सूचना तथा सेवा एप';
        $cms->meta_keyword = $cms->meta_keyword ?: 'बारबर्दिया, नगरपालिका, बर्दिया, सूचना, सिफारिस';
        $cms->url = $cms->url ?: 'https://barbardiyamun.gov.np';
        $cms->phone1 = $cms->phone1 ?: '084402011';
        $cms->phone2 = $cms->phone2 ?: '9848012301';
        $cms->email1 = $cms->email1 ?: 'info@barbardiyamun.gov.np';
        $cms->email2 = $cms->email2 ?: 'ito@barbardiyamun.gov.np';
        $cms->address = $cms->address ?: 'बारबर्दिया, बर्दिया, लुम्बिनी प्रदेश';
        // The line under the app's header banner.
        $cms->location_text = $cms->location_text ?: 'लुम्बिनी प्रदेश, बर्दिया, बारबर्दिया नगरपालिका';
        $cms->facebook = $cms->facebook ?: 'https://facebook.com/barbardiyamun';
        // The Palika tab stays off: the app is the menu tree now, so the demo
        // ships without palikas. Tick "Show Palika" in Cms to bring it back.
        $cms->show_palika = 0;
        $cms->save();

        // The account a fresh install signs in with. Role 1 is Super Admin —
        // the Gate::before in AuthServiceProvider grants it everything — and
        // status has to be on or AuthController turns the login away.
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'phone' => '9813519397',
                'password' => Hash::make('password'),
                'role' => 1,
                'status' => 1,
            ]
        );

        // Demo content, in dependency order: the menu first, then the posts
        // filed under it. Every one of these is re-runnable — they match on
        // slug or name, so seeding twice updates rather than doubles.
        $this->call([
            CategorySeeder::class,
            BlogSeeder::class,
            BannerSeeder::class,
            NoticeSeeder::class,
            PageSeeder::class,
        ]);
    }
}
