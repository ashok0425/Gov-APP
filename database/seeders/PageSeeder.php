<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * The four static pages the app's Settings screen links to. Their slugs are
 * hard-coded in resources/views/mobile/settings.blade.php, so a missing row
 * there is a 404 on a tile the user can see — they are seeded, not optional.
 */
class PageSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->pages() as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }

    protected function pages()
    {
        return [
            [
                'slug' => 'about-us',
                'name' => 'हाम्रो बारेमा',
                'title' => 'हाम्रो बारेमा',
                'description' => '<p>बारबर्दिया नगरपालिका बर्दिया जिल्लामा अवस्थित छ। यो एप नगरपालिकाका '
                    .'सेवा, सूचना तथा समाचार सर्वसाधारणसम्म छिटो पुर्‍याउन तयार पारिएको हो।</p>'
                    .'<p>यहाँबाट सिफारिस तथा दर्ता सेवाको जानकारी, वडा कार्यालयको सम्पर्क, '
                    .'स्वास्थ्य र शिक्षा सम्बन्धी सूचना तथा आपतकालीन सम्पर्क नम्बर पाउन सकिन्छ।</p>',
            ],
            [
                'slug' => 'contact-us',
                'name' => 'सम्पर्क',
                'title' => 'सम्पर्क',
                'description' => '<p><strong>बारबर्दिया नगरपालिका</strong><br>बारबर्दिया, बर्दिया, लुम्बिनी प्रदेश</p>'
                    .'<p>फोन: ०८४-४०२०११<br>इमेल: info@barbardiyamun.gov.np</p>'
                    .'<p>कार्यालय समय: आइतबार–बिहीबार १०:००–१७:००, शुक्रबार १०:००–१५:००</p>',
            ],
            [
                'slug' => 'privacy-policy',
                'name' => 'गोपनीयता नीति',
                'title' => 'गोपनीयता नीति',
                'description' => '<p>यो एपले प्रयोगकर्ताको व्यक्तिगत विवरण सङ्कलन गर्दैन। '
                    .'सूचना तथा समाचार हेर्न कुनै दर्ता आवश्यक पर्दैन।</p>'
                    .'<p>सेवा सुधारका लागि प्रयोग सम्बन्धी सामान्य तथ्याङ्क मात्र राखिन्छ र '
                    .'त्यस्तो तथ्याङ्क कुनै तेस्रो पक्षलाई उपलब्ध गराइँदैन।</p>',
            ],
            [
                'slug' => 'term-condition',
                'name' => 'नियम तथा सर्तहरू',
                'title' => 'नियम तथा सर्तहरू',
                'description' => '<p>यस एपमा प्रकाशित सूचना तथा समाचार जानकारीका लागि मात्र हुन्। '
                    .'आधिकारिक प्रयोजनका लागि सम्बन्धित शाखा वा वडा कार्यालयबाट पुष्टि गर्नुपर्नेछ।</p>'
                    .'<p>एपको सामग्री नगरपालिकाको स्वामित्वमा रहन्छ र पूर्व स्वीकृतिबिना '
                    .'व्यावसायिक प्रयोजनमा प्रयोग गर्न पाइने छैन।</p>',
            ],
        ];
    }
}
