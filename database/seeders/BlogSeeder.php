<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo posts, filed right across the menu — some at a top-level category, some
 * at a subcategory, some at a child category — because Blog::inCategory()
 * matches any of the three columns and only a spread like this proves every
 * level of the app has something to show.
 *
 * A post records the whole trail it was filed under, so filing one under
 * "जन्म दर्ता" also lists it under "दर्ता सेवा" and "सेवा तथा सिफारिस".
 */
class BlogSeeder extends Seeder
{
    public function run()
    {
        DemoImage::rewind();

        $author = User::orderBy('id')->value('id');
        $categories = Category::with('parent.parent')->get()->keyBy('slug');

        foreach ($this->posts() as $index => $post) {
            $category = $categories->get($post['category']);

            if (! $category) {
                $this->command?->warn("Unknown category slug: {$post['category']}");

                continue;
            }

            // Category → Subcategory → Child Category, however deep this one
            // sits; the missing levels stay null.
            $trail = $category->ancestors()->push($category)->values();

            $blog = Blog::withTrashed()->firstOrNew(['slug' => $post['slug']]);

            $blog->forceFill([
                // Legacy column, still NOT NULL. Posts belong to the menu now,
                // not to a business, so nothing reads it.
                'business_id' => 0,
                'user_id' => $author,
                'category_id' => $trail->get(0)?->id,
                'subcategory_id' => $trail->get(1)?->id,
                'child_category_id' => $trail->get(2)?->id,
                'title' => $post['title'],
                'slug' => $post['slug'],
                'short_description' => $post['short'],
                'long_description' => $this->body($post['title'], $post['short']),
                'thumbnail' => $blog->thumbnail ?: DemoImage::next(),
                'cover' => null,
                'status' => 1,
                'is_breaking' => ! empty($post['breaking']),
                'deleted_at' => null,
                'deleted_by' => null,
                // Spread backwards from today. The first few keep today's date
                // so the notifications tab and its badge have something in them.
                'created_at' => now()->subDays($post['days'] ?? $index)->setTime(10, 0),
                'updated_at' => now()->subDays($post['days'] ?? $index)->setTime(10, 0),
            ])->save();
        }
    }

    /** Editor-style HTML, the shape Summernote leaves behind in the admin. */
    protected function body($title, $short)
    {
        return '<p>'.$short.'</p>'
            .'<p>बारबर्दिया नगरपालिकाको कार्यालयबाट "'.$title.'" सम्बन्धी यो जानकारी '
            .'सर्वसाधारणको जानकारीका लागि प्रकाशित गरिएको छ। सेवाग्राहीहरूलाई तोकिएको '
            .'कागजात सहित कार्यालय समयभित्र सम्पर्क राख्न अनुरोध गरिन्छ।</p>'
            .'<ul>'
            .'<li>कार्यालय समय: आइतबार–बिहीबार १०:००–१७:००, शुक्रबार १०:००–१५:००</li>'
            .'<li>आवश्यक कागजात: नागरिकताको प्रतिलिपि, निवेदन र सम्बन्धित प्रमाण</li>'
            .'<li>सम्पर्क: ०८४-४०२०११ / info@barbardiyamun.gov.np</li>'
            .'</ul>'
            .'<p>थप जानकारीका लागि सम्बन्धित शाखा वा वडा कार्यालयमा सम्पर्क गर्नुहोला।</p>';
    }

    /**
     * 'category' is the slug of the deepest node the post is filed under.
     * 'days' overrides how far back it is dated; without it the post lands
     * one day older than the one before it.
     */
    protected function posts()
    {
        return [
            [
                'category' => 'sarbajanik-suchana',
                'slug' => 'aa-ba-2082-83-ko-budget-sarbajanik',
                'title' => 'आ.व. २०८२/८३ को नगर बजेट सार्वजनिक',
                'short' => 'नगरसभाबाट स्वीकृत आगामी आर्थिक वर्षको बजेट तथा कार्यक्रम सार्वजनिक गरिएको छ।',
                'breaking' => true,
                'days' => 0,
            ],
            [
                'category' => 'aapatkalin-sewa',
                'slug' => 'barsa-yam-purba-taiyari-suchana',
                'title' => 'वर्षायाम पूर्वतयारी सम्बन्धी जरुरी सूचना',
                'short' => 'बाढी तथा डुबान जोखिम क्षेत्रका बासिन्दालाई सतर्क रहन नगरपालिकाको अनुरोध।',
                'breaking' => true,
                'days' => 0,
            ],
            [
                'category' => 'nagar-aspatal',
                'slug' => 'nagar-aspatal-ma-nishulka-swasthya-shibir',
                'title' => 'नगर अस्पतालमा निःशुल्क स्वास्थ्य शिविर सञ्चालन',
                'short' => 'आगामी शनिबार नगर अस्पतालमा निःशुल्क स्वास्थ्य परीक्षण शिविर सञ्चालन हुने।',
                'days' => 0,
            ],
            [
                'category' => 'janma-darta',
                'slug' => 'janma-darta-online-sewa-suru',
                'title' => 'जन्म दर्ता अनलाइन सेवा सुरु',
                'short' => 'अब जन्म दर्ताको निवेदन घरैबाट अनलाइन पेस गर्न सकिने व्यवस्था मिलाइएको छ।',
                'days' => 1,
            ],
            [
                'category' => 'bibaha-darta',
                'slug' => 'bibaha-darta-ma-lagne-kagajat',
                'title' => 'विवाह दर्तामा आवश्यक कागजातको सूची',
                'short' => 'विवाह दर्ताका लागि दुवै पक्षको नागरिकता र दुई जना साक्षी अनिवार्य गरिएको छ।',
                'days' => 2,
            ],
            [
                'category' => 'mrityu-darta',
                'slug' => 'mrityu-darta-samayama-garna-anurodh',
                'title' => 'मृत्यु दर्ता ३५ दिनभित्र गर्न अनुरोध',
                'short' => 'ढिलो दर्ता गर्दा लाग्ने शुल्कबाट बच्न समयमै दर्ता गर्न पञ्जीकरण शाखाको आग्रह।',
                'days' => 3,
            ],
            [
                'category' => 'nagarikta-sifaris',
                'slug' => 'nagarikta-sifaris-sewa-prabaha-sahaj',
                'title' => 'नागरिकता सिफारिस सेवा अझ सहज',
                'short' => 'सिफारिसका लागि अब वडा कार्यालय हुँदै नगरपालिकामा आउनुपर्ने झन्झट हट्यो।',
                'days' => 4,
            ],
            [
                'category' => 'nata-pramanit',
                'slug' => 'nata-pramanit-sewa-suchana',
                'title' => 'नाता प्रमाणित सेवा सम्बन्धी सूचना',
                'short' => 'नाता प्रमाणितका लागि सम्बन्धित वडाको सिफारिस अनिवार्य रहेको जानकारी।',
                'days' => 5,
            ],
            [
                'category' => 'gharjagga-namsari',
                'slug' => 'gharjagga-namsari-suchana',
                'title' => 'घरजग्गा नामसारी सम्बन्धी सूचना',
                'short' => 'मालपोत कार्यालयसँगको समन्वयमा नामसारी प्रक्रिया छिटो बनाइएको छ।',
                'days' => 6,
            ],
            [
                'category' => 'bolpatra-aahwan',
                'slug' => 'sadak-kalopatre-bolpatra-aahwan',
                'title' => 'सडक कालोपत्रे कार्यको बोलपत्र आह्वान',
                'short' => 'वडा नं. २ र ३ मा सडक कालोपत्रे कार्यका लागि बोलपत्र आह्वान गरिएको छ।',
                'breaking' => true,
                'days' => 7,
            ],
            [
                'category' => 'bolpatra-aahwan',
                'slug' => 'khanepani-yojana-bolpatra',
                'title' => 'खानेपानी योजनाको बोलपत्र सम्बन्धी सूचना',
                'short' => 'खानेपानी विस्तार योजनाका लागि इच्छुक निर्माण व्यवसायीबाट बोलपत्र आह्वान।',
                'days' => 9,
            ],
            [
                'category' => 'press-bigyapti',
                'slug' => 'nagar-sabha-ko-press-bigyapti',
                'title' => 'नगरसभाको निर्णय सम्बन्धी प्रेस विज्ञप्ति',
                'short' => 'नगरसभाले पारित गरेका नीति तथा कार्यक्रमबारे प्रेस विज्ञप्ति जारी।',
                'days' => 10,
            ],
            [
                'category' => 'press-bigyapti',
                'slug' => 'safai-abhiyan-press-bigyapti',
                'title' => 'सरसफाइ अभियान सम्बन्धी प्रेस विज्ञप्ति',
                'short' => 'नगरक्षेत्रमा साप्ताहिक सरसफाइ अभियान सञ्चालन गरिने जानकारी।',
                'days' => 11,
            ],
            [
                'category' => 'sarbajanik-suchana',
                'slug' => 'karyalaya-samaya-parivartan',
                'title' => 'कार्यालय समय परिवर्तन सम्बन्धी सूचना',
                'short' => 'हिउँदे समयतालिका अनुसार कार्यालय समयमा हेरफेर गरिएको छ।',
                'days' => 12,
            ],
            [
                'category' => 'wada-1-suchana',
                'slug' => 'wada-1-ko-basti-star-bhela',
                'title' => 'वडा नं. १ मा बस्ती स्तरीय भेला',
                'short' => 'योजना छनोटका लागि वडा नं. १ का सबै टोलमा बस्ती स्तरीय भेला हुने।',
                'days' => 13,
            ],
            [
                'category' => 'wada-2-suchana',
                'slug' => 'wada-2-ko-yojana-chhanot',
                'title' => 'वडा नं. २ को योजना छनोट सम्पन्न',
                'short' => 'आगामी वर्षका लागि छनोट भएका योजनाहरूको सूची सार्वजनिक।',
                'days' => 14,
            ],
            [
                'category' => 'wada-3-suchana',
                'slug' => 'wada-3-ma-sifaris-sewa-suru',
                'title' => 'वडा नं. ३ मा सिफारिस सेवा सुरु',
                'short' => 'वडा कार्यालय नं. ३ बाट पनि अब सबै प्रकारका सिफारिस उपलब्ध हुने।',
                'days' => 15,
            ],
            [
                'category' => 'wada-karyalaya',
                'slug' => 'wada-karyalaya-haruko-sampark-number',
                'title' => 'वडा कार्यालयहरूको सम्पर्क नम्बर सार्वजनिक',
                'short' => 'सबै वडा कार्यालयका सम्पर्क नम्बर एकै ठाउँमा उपलब्ध गराइएको छ।',
                'days' => 16,
            ],
            [
                'category' => 'swasthya-chauki-wada-2',
                'slug' => 'swasthya-chauki-wada-2-ma-nayan-sewa',
                'title' => 'स्वास्थ्य चौकी वडा २ मा नयाँ सेवा थपियो',
                'short' => 'प्रयोगशाला सेवा सहित बिहान ७ बजेदेखि सेवा सुरु गरिएको छ।',
                'days' => 17,
            ],
            [
                'category' => 'khop-karyakram',
                'slug' => 'dadura-rubella-khop-karyakram',
                'title' => 'दादुरा–रुबेला खोप कार्यक्रम सञ्चालन',
                'short' => 'नगरका सबै विद्यालयमा दादुरा–रुबेला खोप कार्यक्रम सञ्चालन हुने।',
                'days' => 18,
            ],
            [
                'category' => 'ambulance-sewa',
                'slug' => 'ambulance-sewa-24-ghanta',
                'title' => 'एम्बुलेन्स सेवा २४ सै घण्टा उपलब्ध',
                'short' => 'नगरपालिकाको एम्बुलेन्स सेवा अब चौबीसै घण्टा सञ्चालनमा रहने।',
                'days' => 19,
            ],
            [
                'category' => 'shree-janata-mavi',
                'slug' => 'janata-mavi-ma-bhauna-nirman',
                'title' => 'श्री जनता मा.वि. मा नयाँ भवन निर्माण',
                'short' => 'दश कोठे नयाँ भवनको निर्माण कार्य सम्पन्न भई हस्तान्तरण गरिएको छ।',
                'days' => 20,
            ],
            [
                'category' => 'shree-saraswati-aavi',
                'slug' => 'saraswati-aavi-ma-bharna-abhiyan',
                'title' => 'श्री सरस्वती आ.वि. मा भर्ना अभियान',
                'short' => 'नयाँ शैक्षिक सत्रका लागि भर्ना अभियान सुरु भएको छ।',
                'days' => 21,
            ],
            [
                'category' => 'chhatrabritti',
                'slug' => 'chhatrabritti-ko-lagi-nibedan-aahwan',
                'title' => 'छात्रवृत्तिका लागि निवेदन आह्वान',
                'short' => 'जेहेन्दार तथा विपन्न विद्यार्थीका लागि छात्रवृत्ति निवेदन आह्वान गरिएको छ।',
                'days' => 22,
            ],
            [
                'category' => 'rajaswa-tatha-kar',
                'slug' => 'sampatti-kar-ma-chhut',
                'title' => 'सम्पत्ति करमा छुटको व्यवस्था',
                'short' => 'असार मसान्तभित्र कर तिर्नेलाई १० प्रतिशत छुट दिने निर्णय।',
                'days' => 23,
            ],
            [
                'category' => 'prahari-karyalaya',
                'slug' => 'suraksha-sanjal-bistar',
                'title' => 'नगरक्षेत्रमा सुरक्षा सञ्जाल विस्तार',
                'short' => 'मुख्य बजार क्षेत्रमा सीसीटीभी जडान गरी सुरक्षा सञ्जाल विस्तार गरिएको छ।',
                'days' => 24,
            ],
            [
                'category' => 'damkal-sewa',
                'slug' => 'damkal-ma-nayan-gadi-thapiyo',
                'title' => 'दमकल सेवामा नयाँ गाडी थपियो',
                'short' => 'आगलागी नियन्त्रणका लागि नयाँ दमकल गाडी खरिद गरी सञ्चालनमा ल्याइएको छ।',
                'days' => 25,
            ],
            [
                'category' => 'bipad-byabasthapan',
                'slug' => 'bipad-byabasthapan-kosh-sthapana',
                'title' => 'विपद् व्यवस्थापन कोष स्थापना',
                'short' => 'विपद्‌मा तत्काल राहत उपलब्ध गराउन छुट्टै कोष स्थापना गरिएको छ।',
                'days' => 26,
            ],
            [
                'category' => 'nagar-karyapalika',
                'slug' => 'nagar-karyapalika-baithak-nirnaya',
                'title' => 'नगर कार्यपालिका बैठकका निर्णयहरू सार्वजनिक',
                'short' => 'कार्यपालिकाको बैठकबाट पारित नीति तथा निर्णयहरू सर्वसाधारणका लागि सार्वजनिक गरिएको छ।',
                'days' => 27,
            ],
            [
                'category' => 'prashasan-shakha',
                'slug' => 'karyalaya-samaya-parivartan-suchana',
                'title' => 'कार्यालय समय परिवर्तन सम्बन्धी सूचना',
                'short' => 'हिउँदे समयतालिका अनुसार कार्यालय समयमा हेरफेर गरिएको जानकारी गराइन्छ।',
                'days' => 28,
            ],
            [
                'category' => 'sahakari-darta-niyaman',
                'slug' => 'sahakari-darta-nabikaran-suchana',
                'title' => 'सहकारी संस्था नवीकरण सम्बन्धी सूचना',
                'short' => 'नगरपालिकाभित्र दर्ता भएका सहकारी संस्थाहरूले तोकिएको म्यादभित्र नवीकरण गर्नुपर्ने।',
                'days' => 29,
            ],
            [
                'category' => 'janakalyan-sahakari',
                'slug' => 'janakalyan-sahakari-sadharan-sabha',
                'title' => 'जनकल्याण सहकारीको वार्षिक साधारण सभा',
                'short' => 'संस्थाको वार्षिक साधारण सभा तथा लाभांश वितरण कार्यक्रम सम्पन्न भएको छ।',
                'days' => 30,
            ],
            [
                'category' => 'krishi-sahakari',
                'slug' => 'krishi-sahakari-anudan-karyakram',
                'title' => 'कृषि सहकारीमार्फत बीउ तथा मल अनुदान',
                'short' => 'कृषि सहकारी संस्थामार्फत किसानलाई अनुदानमा बीउ तथा मल वितरण गरिने भएको छ।',
                'days' => 31,
            ],
        ];
    }
}
