<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Repositories\OptionRepository;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = config('data-presets.options');

        $optionRepo = app(OptionRepository::class);

        $optionRepo->setOptions($options);
    }
}
