<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

/**
 * The carousel on the app's home screen. MobileAppController::banners() reads
 * type 1 rows with no business_id and is_homepage_banner on, so that is the
 * only shape seeded here.
 */
class BannerSeeder extends Seeder
{
    public function run()
    {
        DemoImage::rewind();

        foreach ($this->homeBanners() as $title) {
            $banner = Banner::firstOrNew([
                'title' => $title,
                'business_id' => null,
            ]);

            $banner->forceFill([
                'title' => $title,
                'business_id' => null,
                'type' => 1,
                'is_homepage_banner' => 1,
                'status' => 1,
                'thumbnail' => $banner->thumbnail ?: DemoImage::next(),
            ])->save();
        }
    }

    protected function homeBanners()
    {
        return [
            'नगरपालिका परिचय',
            'डिजिटल नागरिक सेवा',
            'सरसफाइ अभियान',
        ];
    }
}
