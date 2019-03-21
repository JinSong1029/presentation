<?php
use Illuminate\Database\Seeder;

class QuotesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('quotes')->insert([
            [
                'author' => 'wonderful serenity',
                'role' => 'existence',
                'image' => NULL,
                'double' => 0,
                'quote' => '<p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. </p>',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('quotes')->insert([
            [
                'author' => 'Gregor Samsa',
                'role' => 'dreamer',
                'image' => NULL,
                'double' => 0,
                'quote' => '<p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.</p>',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('quotes')->insert([
            [
                'author' => '',
                'role' => '',
                'image' => '1449850022-calm-place-16366741837.jpeg',
                'double' => 0,
                'quote' => '',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('quotes')->insert([
            [
                'author' => 'Brown fox',
                'role' => 'jumper',
                'image' => NULL,
                'double' => 0,
                'quote' => '<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps. Bawds jog, flick quartz, vex nymphs. Waltz, bad nymph, for quick jigs vex! Fox nymphs grab quick-jived waltz. </p>',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}