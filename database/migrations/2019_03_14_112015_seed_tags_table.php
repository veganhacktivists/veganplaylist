<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tags')->insert(
            array(
                array(
                    'name' => 'Ethics',
                    'color' => 'primary'
                ),
                array(
                    'name' => 'Humor',
                    'color' => 'secondary'
                ),
                array(
                    'name' => 'Environment',
                    'color' => 'success'
                ),
                array(
                    'name'  => 'Health',
                    'color' => 'danger'
                ),
                array(
                    'name' => 'Inspiring',
                    'color' => 'primary'
                ),
                array(
                    'name' => 'Documentary',
                    'color' => 'warning'
                ),
                array(
                    'name' => 'Information',
                    'color' => 'info'
                ),
                array(
                    'name' => 'Fitness',
                    'color' => 'fitness'
                ),
                array(
                    'name' => 'Activism',
                    'color' => 'dark'
                ),
                array(
                    'name' => 'Speech',
                    'color' => 'light'
                ),
                array(
                    'name' => 'Music',
                    'color' => 'warning'
                ),
                array(
                    'name' => 'Recipes',
                    'color' => 'danger'
                ),
                array(
                    'name' => 'Science',
                    'color' => 'secondary'
                ),
                array(
                    'name' => 'Philosophy',
                    'color' => 'light'
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
