<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 0;
        $options = [
            'general' => [
                'sitename' => 3,
                'title' => 3,
                'description' => 4,
                'keywords' => 4,
                'main_logo' => 5,
                'white_logo' => 5,
                'fav_icon' => 5,
                'default_lang' => 6,
                'menu' => 7,
            ],
        ];
        
        foreach ($options as $group => $option_group) {
            $index++;
            $current = $index;
            \DB::table('options')->insert([
                'key' => $group,
                'type' => 1,
            ]);

            if (is_array($option_group)) {
                foreach ($option_group as $key => $value) {
                    \DB::table('options')->insert([
                        'key' => $key,
                        'value' => null,
                        'parent_id' => $current,
                        'type' => $value,
                    ]);
                    $index++;
                }
            }
        } 
    }
}
