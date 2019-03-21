<?php
use Illuminate\Database\Seeder;

class TombstonesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tombstones')->insert([
            ['label' => 'label',
                'image' => '1443605071-lighthouse.jpg',
                'desc' => 'description',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('tombstones')->insert([
            ['label' => 'Lorem ipsum dolor',
             'image' => '1443605071-lighthouse.jpg',
             'desc' => '<p><strong>Lorem ipsum dolor sit amet</strong><strong></strong><br></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('tombstones')->insert([
            ['label' => 'Quick zephyrs',
                'image' => '1449774485-calm-place-to-live2-4.jpg',
                'desc' => '<p><strong>Quick zephyrs blow, vexing daft Jim.</strong><strong></strong><br></p><p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps. Bawds jog, flick quartz, vex nymphs. Waltz, bad nymph, for quick jigs vex! Fox nymphs grab quick-jived waltz. Brick quiz whangs jumpy veldt fox. Bright vixens jump; dozy fowl quack. Quick wafting zephyrs vex bold Jim.</p>',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('tombstones')->insert([
            ['label' => 'One morning',
                'image' => '1449774531-calm-place-16366741837.jpeg',
                'desc' => "<p><strong>One morning, when Gregor Samsa</strong><strong></strong><br></p><p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment.</p><p>His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. Whats happened to me? he thought. It wasn\'t a dream. His room, a proper human room although a little too small, lay peacefully between its four familiar walls.</span></p>",
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}