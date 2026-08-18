<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * The demo menu, all three levels of it: category → subcategory → child
 * category. Contact details hang off the child categories, which is where an
 * office or an institution actually is — ringing "स्वास्थ्य सेवा" means
 * nothing to a citizen, ringing "नगर अस्पताल" does. A few leaves higher up the
 * tree carry contacts too, since the columns exist at every level.
 */
class CategorySeeder extends Seeder
{
    /** Rolls the phone number on for each desk-contact fallback. */
    protected $deskExtension = 0;

    public function run()
    {
        foreach ($this->tree() as $position => $category) {
            $this->plant($category, null, $position);
        }
    }

    /**
     * Writes one node and everything under it. Matching on name + parent is
     * what makes a re-run update the demo rather than duplicate it — the same
     * pair the admin's uniqueness rule uses.
     */
    protected function plant(array $node, $parentId, $position)
    {
        $category = Category::firstOrNew([
            'name' => $node['name'],
            'parent_id' => $parentId,
        ]);

        // Every level below the top carries contact details: a citizen who
        // drills into a subcategory or a child category should always find
        // someone to ring. Nodes that name their own office keep it; the
        // rest fall back to the municipality desk that handles them.
        $contact = $node['contact'] ?? ($parentId ? $this->deskContact($node['name']) : []);

        $category->forceFill($contact + [
            'parent_id' => $parentId,
            'name' => $node['name'],
            'slug' => $node['slug'],
            'status' => 1,
            'position' => $position,
            // The tile artwork is part of the demo definition, so a re-run
            // restores it: flat 60x60 icons, not photographs.
            'thumbnail' => $this->icon($node['slug']),
            'show_contact' => $contact ? 1 : 0,
            'owner_name' => null,
            'address' => null,
            'google_map_link' => null,
            'email' => null,
            'phone' => null,
            'whatsapp' => null,
            'messanger' => null,
            'facebook' => null,
            'other' => null,
        ])->save();

        foreach ($node['children'] ?? [] as $childPosition => $child) {
            $this->plant($child, $category->id, $childPosition);
        }

        return $category;
    }

    /**
     * Copies the icon this category uses onto the public disk and hands back
     * the path the blades want. The artwork is versioned in the repo under
     * public/mobile/img/categories, but a category thumbnail is read as
     * asset('storage/'.$thumbnail) — the same convention an admin upload
     * follows — so it has to live under storage/app/public to be served.
     */
    protected function icon($slug)
    {
        $icon = $this->icons()[$slug] ?? 'document';
        $path = 'uploads/categories/'.$icon.'.svg';
        $source = public_path('mobile/img/categories/'.$icon.'.svg');

        if (File::exists($source) && ! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, File::get($source));
        }

        return $path;
    }

    /**
     * Which icon each category wears. Anything unlisted falls back to the
     * generic document, so adding a category never leaves a blank tile.
     */
    protected function icons()
    {
        return [
            'palika' => 'palika',
            'nagar-karyapalika' => 'office',
            'nagar-pramukh' => 'person',
            'nagar-upapramukh' => 'person',
            'pramukh-prashasakiya-adhikrit' => 'person',
            'shakha-tatha-mahashakha' => 'clipboard',
            'prashasan-shakha' => 'clipboard',
            'yojana-tatha-prabidhik-shakha' => 'clipboard',
            'samajik-bikas-shakha' => 'person',
            'nagarpalika-karyalaya' => 'palika',

            'sahakari' => 'group',
            'bachat-tatha-rin-sahakari' => 'money',
            'janakalyan-sahakari' => 'money',
            'nawajagriti-sahakari' => 'money',
            'krishi-sahakari' => 'plant',
            'barbardiya-krishi-sahakari' => 'plant',
            'dugdha-utpadak-sahakari' => 'plant',
            'sahakari-darta-niyaman' => 'clipboard',

            'sewa-tatha-sifaris' => 'document',
            'sifaris-sewa' => 'document',
            'nagarikta-sifaris' => 'id-card',
            'nata-pramanit' => 'document',
            'gharjagga-namsari' => 'house',
            'darta-sewa' => 'clipboard',
            'janma-darta' => 'document',
            'bibaha-darta' => 'document',
            'mrityu-darta' => 'document',
            'rajaswa-tatha-kar' => 'money',

            'suchana-tatha-samachar' => 'megaphone',
            'sarbajanik-suchana' => 'megaphone',
            'press-bigyapti' => 'megaphone',
            'bolpatra-aahwan' => 'clipboard',

            'wada-karyalaya' => 'office',
            'wada-1' => 'house',
            'wada-2' => 'house',
            'wada-3' => 'house',
            'wada-1-adhyakshya' => 'person',
            'wada-2-adhyakshya' => 'person',
            'wada-3-adhyakshya' => 'person',
            'wada-1-suchana' => 'megaphone',
            'wada-2-suchana' => 'megaphone',
            'wada-3-suchana' => 'megaphone',

            'swasthya-sewa' => 'hospital',
            'aspatal-tatha-swasthya-chauki' => 'hospital',
            'nagar-aspatal' => 'hospital',
            'swasthya-chauki-wada-2' => 'hospital',
            'ambulance-sewa' => 'ambulance',
            'khop-karyakram' => 'syringe',

            'shiksha' => 'school',
            'bidyalaya' => 'school',
            'shree-janata-mavi' => 'school',
            'shree-saraswati-aavi' => 'school',
            'chhatrabritti' => 'graduation',

            'aapatkalin-sewa' => 'siren',
            'prahari-karyalaya' => 'siren',
            'damkal-sewa' => 'fire',
            'bipad-byabasthapan' => 'warning',
        ];
    }

    /**
     * The fallback contact for a node that has no office of its own — the
     * municipality's front desk, with a distinct extension per node so the
     * demo does not show the same number on every screen.
     */
    protected function deskContact($name)
    {
        $this->deskExtension++;

        return $this->contact(
            $name.' – सम्पर्क डेस्क',
            '98480124'.str_pad($this->deskExtension, 2, '0', STR_PAD_LEFT),
            'बारबर्दिया नगरपालिका कार्यालय, बारबर्दिया, बर्दिया'
        );
    }

    /** The contact block for one demo office. */
    protected function contact($owner, $phone, $address, $email = null)
    {
        return [
            'owner_name' => $owner,
            'address' => $address,
            'google_map_link' => 'https://maps.google.com/?q=Barbardiya+Municipality',
            'email' => $email ?: 'info@barbardiyamun.gov.np',
            'phone' => $phone,
            'whatsapp' => $phone,
            'messanger' => 'https://m.me/barbardiyamun',
            'facebook' => 'https://facebook.com/barbardiyamun',
            'other' => null,
        ];
    }

    /** The eight top-level categories the app's home grid shows. */
    protected function tree()
    {
        return [
            [
                'name' => 'पालिका',
                'slug' => 'palika',
                'children' => [
                    [
                        'name' => 'नगर कार्यपालिका',
                        'slug' => 'nagar-karyapalika',
                        'children' => [
                            [
                                'name' => 'नगर प्रमुख',
                                'slug' => 'nagar-pramukh',
                                'contact' => $this->contact('नगर प्रमुख – टेकबहादुर चौधरी', '9848012001', 'नगरपालिका कार्यालय, कोठा नं. ००१', 'mayor@barbardiyamun.gov.np'),
                            ],
                            [
                                'name' => 'नगर उपप्रमुख',
                                'slug' => 'nagar-upapramukh',
                                'contact' => $this->contact('नगर उपप्रमुख – सरिता के.सी.', '9848012002', 'नगरपालिका कार्यालय, कोठा नं. ००२'),
                            ],
                            [
                                'name' => 'प्रमुख प्रशासकीय अधिकृत',
                                'slug' => 'pramukh-prashasakiya-adhikrit',
                                'contact' => $this->contact('प्र.प्र.अ. – रामेश्वर पौडेल', '9848012003', 'नगरपालिका कार्यालय, कोठा नं. ००३', 'ceo@barbardiyamun.gov.np'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'शाखा तथा महाशाखा',
                        'slug' => 'shakha-tatha-mahashakha',
                        'children' => [
                            [
                                'name' => 'प्रशासन शाखा',
                                'slug' => 'prashasan-shakha',
                                'contact' => $this->contact('प्रशासन शाखा प्रमुख', '9848012004', 'नगरपालिका कार्यालय, कोठा नं. १०५'),
                            ],
                            [
                                'name' => 'योजना तथा प्राविधिक शाखा',
                                'slug' => 'yojana-tatha-prabidhik-shakha',
                                'contact' => $this->contact('प्राविधिक शाखा प्रमुख', '9848012005', 'नगरपालिका कार्यालय, कोठा नं. २०५'),
                            ],
                            [
                                'name' => 'सामाजिक विकास शाखा',
                                'slug' => 'samajik-bikas-shakha',
                                'contact' => $this->contact('सामाजिक विकास शाखा प्रमुख', '9848012006', 'नगरपालिका कार्यालय, कोठा नं. २०६'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'नगरपालिका कार्यालय',
                        'slug' => 'nagarpalika-karyalaya',
                        'contact' => $this->contact('बारबर्दिया नगरपालिका', '084402011', 'बारबर्दिया, बर्दिया, लुम्बिनी प्रदेश'),
                    ],
                ],
            ],
            [
                'name' => 'सेवा तथा सिफारिस',
                'slug' => 'sewa-tatha-sifaris',
                'children' => [
                    [
                        'name' => 'सिफारिस सेवा',
                        'slug' => 'sifaris-sewa',
                        'children' => [
                            [
                                'name' => 'नागरिकता सिफारिस',
                                'slug' => 'nagarikta-sifaris',
                                'contact' => $this->contact('राम बहादुर चौधरी', '9848012301', 'नगरपालिका कार्यालय, कोठा नं. १०१'),
                            ],
                            [
                                'name' => 'नाता प्रमाणित',
                                'slug' => 'nata-pramanit',
                                'contact' => $this->contact('सीता कुमारी थारू', '9848012302', 'नगरपालिका कार्यालय, कोठा नं. १०२'),
                            ],
                            [
                                'name' => 'घरजग्गा नामसारी',
                                'slug' => 'gharjagga-namsari',
                                'contact' => $this->contact('हरि प्रसाद शर्मा', '9848012303', 'नगरपालिका कार्यालय, कोठा नं. १०३'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'दर्ता सेवा',
                        'slug' => 'darta-sewa',
                        'children' => [
                            [
                                'name' => 'जन्म दर्ता',
                                'slug' => 'janma-darta',
                                'contact' => $this->contact('गीता देवी यादव', '9848012304', 'पञ्जीकरण शाखा, कोठा नं. २०१'),
                            ],
                            [
                                'name' => 'विवाह दर्ता',
                                'slug' => 'bibaha-darta',
                                'contact' => $this->contact('गीता देवी यादव', '9848012305', 'पञ्जीकरण शाखा, कोठा नं. २०१'),
                            ],
                            [
                                'name' => 'मृत्यु दर्ता',
                                'slug' => 'mrityu-darta',
                                'contact' => $this->contact('विनोद कुमार चौधरी', '9848012306', 'पञ्जीकरण शाखा, कोठा नं. २०२'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'राजस्व तथा कर',
                        'slug' => 'rajaswa-tatha-kar',
                    ],
                ],
            ],
            [
                'name' => 'सूचना तथा समाचार',
                'slug' => 'suchana-tatha-samachar',
                'children' => [
                    ['name' => 'सार्वजनिक सूचना', 'slug' => 'sarbajanik-suchana'],
                    ['name' => 'प्रेस विज्ञप्ति', 'slug' => 'press-bigyapti'],
                    ['name' => 'बोलपत्र आह्वान', 'slug' => 'bolpatra-aahwan'],
                ],
            ],
            [
                'name' => 'वडा कार्यालय',
                'slug' => 'wada-karyalaya',
                'children' => [
                    [
                        'name' => 'वडा नं. १',
                        'slug' => 'wada-1',
                        'children' => [
                            [
                                'name' => 'वडा अध्यक्ष सम्पर्क',
                                'slug' => 'wada-1-adhyakshya',
                                'contact' => $this->contact('कृष्ण बहादुर थारू', '9848012311', 'वडा कार्यालय नं. १, बारबर्दिया'),
                            ],
                            ['name' => 'वडा सूचना', 'slug' => 'wada-1-suchana'],
                        ],
                    ],
                    [
                        'name' => 'वडा नं. २',
                        'slug' => 'wada-2',
                        'children' => [
                            [
                                'name' => 'वडा अध्यक्ष सम्पर्क',
                                'slug' => 'wada-2-adhyakshya',
                                'contact' => $this->contact('मीना चौधरी', '9848012312', 'वडा कार्यालय नं. २, बारबर्दिया'),
                            ],
                            ['name' => 'वडा सूचना', 'slug' => 'wada-2-suchana'],
                        ],
                    ],
                    [
                        'name' => 'वडा नं. ३',
                        'slug' => 'wada-3',
                        'children' => [
                            [
                                'name' => 'वडा अध्यक्ष सम्पर्क',
                                'slug' => 'wada-3-adhyakshya',
                                'contact' => $this->contact('दिपक कुमार यादव', '9848012313', 'वडा कार्यालय नं. ३, बारबर्दिया'),
                            ],
                            ['name' => 'वडा सूचना', 'slug' => 'wada-3-suchana'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'स्वास्थ्य सेवा',
                'slug' => 'swasthya-sewa',
                'children' => [
                    [
                        'name' => 'अस्पताल तथा स्वास्थ्य चौकी',
                        'slug' => 'aspatal-tatha-swasthya-chauki',
                        'children' => [
                            [
                                'name' => 'नगर अस्पताल',
                                'slug' => 'nagar-aspatal',
                                'contact' => $this->contact('डा. सुरेश पाण्डे', '9848012321', 'बारबर्दिया नगर अस्पताल, वडा नं. १', 'hospital@barbardiyamun.gov.np'),
                            ],
                            [
                                'name' => 'स्वास्थ्य चौकी – वडा २',
                                'slug' => 'swasthya-chauki-wada-2',
                                'contact' => $this->contact('अनिता शर्मा', '9848012322', 'स्वास्थ्य चौकी, वडा नं. २'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'एम्बुलेन्स सेवा',
                        'slug' => 'ambulance-sewa',
                        'contact' => $this->contact('एम्बुलेन्स समन्वय कक्ष', '9848012323', 'बारबर्दिया नगरपालिका'),
                    ],
                    ['name' => 'खोप कार्यक्रम', 'slug' => 'khop-karyakram'],
                ],
            ],
            [
                'name' => 'शिक्षा',
                'slug' => 'shiksha',
                'children' => [
                    [
                        'name' => 'विद्यालय',
                        'slug' => 'bidyalaya',
                        'children' => [
                            [
                                'name' => 'श्री जनता मा.वि.',
                                'slug' => 'shree-janata-mavi',
                                'contact' => $this->contact('प्रधानाध्यापक – नारायण अधिकारी', '9848012331', 'वडा नं. २, बारबर्दिया'),
                            ],
                            [
                                'name' => 'श्री सरस्वती आ.वि.',
                                'slug' => 'shree-saraswati-aavi',
                                'contact' => $this->contact('प्रधानाध्यापक – कमला थारू', '9848012332', 'वडा नं. ३, बारबर्दिया'),
                            ],
                        ],
                    ],
                    ['name' => 'छात्रवृत्ति', 'slug' => 'chhatrabritti'],
                ],
            ],
            [
                'name' => 'सहकारी',
                'slug' => 'sahakari',
                'children' => [
                    [
                        'name' => 'बचत तथा ऋण सहकारी',
                        'slug' => 'bachat-tatha-rin-sahakari',
                        'children' => [
                            [
                                'name' => 'जनकल्याण बचत तथा ऋण सहकारी',
                                'slug' => 'janakalyan-sahakari',
                                'contact' => $this->contact('अध्यक्ष – मोहन थारू', '9848012351', 'वडा नं. १, बारबर्दिया', 'janakalyan.sahakari@gmail.com'),
                            ],
                            [
                                'name' => 'नवजागृति बचत तथा ऋण सहकारी',
                                'slug' => 'nawajagriti-sahakari',
                                'contact' => $this->contact('अध्यक्ष – सुनिता चौधरी', '9848012352', 'वडा नं. ३, बारबर्दिया', 'nawajagriti.sahakari@gmail.com'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'कृषि सहकारी',
                        'slug' => 'krishi-sahakari',
                        'children' => [
                            [
                                'name' => 'बारबर्दिया कृषि सहकारी संस्था',
                                'slug' => 'barbardiya-krishi-sahakari',
                                'contact' => $this->contact('अध्यक्ष – दिलबहादुर थारू', '9848012353', 'वडा नं. २, बारबर्दिया'),
                            ],
                            [
                                'name' => 'दुग्ध उत्पादक सहकारी',
                                'slug' => 'dugdha-utpadak-sahakari',
                                'contact' => $this->contact('अध्यक्ष – पार्वती यादव', '9848012354', 'वडा नं. ४, बारबर्दिया'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'सहकारी दर्ता तथा नियमन',
                        'slug' => 'sahakari-darta-niyaman',
                        'contact' => $this->contact('सहकारी शाखा', '9848012355', 'नगरपालिका कार्यालय, कोठा नं. २०३'),
                    ],
                ],
            ],
            [
                'name' => 'आपतकालीन सेवा',
                'slug' => 'aapatkalin-sewa',
                'children' => [
                    [
                        'name' => 'प्रहरी कार्यालय',
                        'slug' => 'prahari-karyalaya',
                        'contact' => $this->contact('इलाका प्रहरी कार्यालय', '100', 'बारबर्दिया, बर्दिया'),
                    ],
                    [
                        'name' => 'दमकल सेवा',
                        'slug' => 'damkal-sewa',
                        'contact' => $this->contact('दमकल नियन्त्रण कक्ष', '101', 'नगरपालिका कार्यालय परिसर'),
                    ],
                    [
                        'name' => 'विपद् व्यवस्थापन',
                        'slug' => 'bipad-byabasthapan',
                        'contact' => $this->contact('विपद् व्यवस्थापन शाखा', '9848012341', 'नगरपालिका कार्यालय, कोठा नं. ३०१'),
                    ],
                ],
            ],
        ];
    }
}
