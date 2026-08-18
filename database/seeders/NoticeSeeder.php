<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

/**
 * Demo notifications for the app's सूचना tab. The first two are dated inside
 * the last 24 hours on purpose — that is what the badge on the tab counts.
 */
class NoticeSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->notices() as $notice) {
            Notice::updateOrCreate(
                ['title' => $notice['title']],
                $notice + ['status' => 1]
            );
        }
    }

    protected function notices()
    {
        return [
            [
                'title' => 'खानेपानी वितरण बन्द हुने सूचना',
                'short_description' => 'मर्मत कार्यका कारण भोलि बिहान ६ देखि दिउँसो २ बजेसम्म खानेपानी वितरण बन्द रहनेछ।',
                'description' => '<p>मुख्य पाइपलाइनको मर्मत कार्य हुने भएकाले वडा नं. १, २ र ३ मा भोलि '
                    .'बिहान ६:०० बजेदेखि दिउँसो २:०० बजेसम्म खानेपानी वितरण बन्द रहने व्यहोरा '
                    .'सम्बन्धित सबैलाई जानकारी गराइन्छ।</p>',
                'published_at' => now()->subHours(2),
            ],
            [
                'title' => 'सिफारिस सेवा अनलाइन दर्ता सुरु',
                'short_description' => 'अब सिफारिससम्बन्धी निवेदन एपबाटै दर्ता गर्न सकिने।',
                'description' => '<p>नागरिकता, नाता प्रमाणित तथा घरजग्गा नामसारी सिफारिसका लागि '
                    .'निवेदन अब एपबाटै दर्ता गर्न सकिने व्यवस्था मिलाइएको छ।</p>',
                'published_at' => now()->subHours(9),
            ],
            [
                'title' => 'नगरसभा बैठक बस्ने सूचना',
                'short_description' => 'आगामी शुक्रबार बिहान ११ बजे नगरसभाको बैठक बस्नेछ।',
                'description' => '<p>नगरसभाको बैठक नगरपालिका कार्यालयको सभाहलमा बस्ने भएकाले '
                    .'सम्पूर्ण सदस्यज्यूहरूको उपस्थितिका लागि अनुरोध गरिन्छ।</p>',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'निःशुल्क स्वास्थ्य शिविर सञ्चालन',
                'short_description' => 'वडा नं. ४ मा आउँदो शनिबार निःशुल्क स्वास्थ्य शिविर सञ्चालन हुनेछ।',
                'description' => '<p>नगर अस्पतालको सहयोगमा वडा नं. ४ को सामुदायिक भवनमा '
                    .'निःशुल्क स्वास्थ्य परीक्षण तथा औषधि वितरण शिविर सञ्चालन गरिनेछ।</p>',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'सम्पत्ति कर तिर्ने म्याद थप',
                'short_description' => 'सम्पत्ति कर तिर्ने अन्तिम म्याद असार मसान्तसम्म थप गरिएको छ।',
                'description' => '<p>करदाताहरूको अनुरोधलाई मध्यनजर गर्दै सम्पत्ति तथा व्यवसाय कर '
                    .'तिर्ने म्याद असार मसान्तसम्म थप गरिएको जानकारी गराइन्छ।</p>',
                'published_at' => now()->subDays(6),
            ],
        ];
    }
}
