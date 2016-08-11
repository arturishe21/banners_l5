<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        if (!Schema::hasTable ('banners_platforms')) {
            Schema::create ('banners_platforms', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments ('id');
                $table->string ('title', 255);
                $table->string ('slug', 255)->unique ();
                $table->integer ('width');
                $table->integer ('height');
                $table->timestamps ();

            });
        }
        if (!Schema::hasTable ('banners')) {
            Schema::create ('banners', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments ('id')->unsigned ();
                $table->integer ('id_banners_platform')->unsigned ();;
                $table->string ('title', 255);
                $table->string ('link', 255);
                $table->string ('path_file', 255);
                $table->tinyInteger ('is_target_blank');
                $table->tinyInteger ('is_show');
                $table->integer ('hit_count');
                $table->integer ('click_count');
                $table->timestamps ();
                $table->dateTime ('show_start');
                $table->dateTime ('show_finish');
                $table->tinyInteger ('is_show_all');

                $table->index ('id_banners_platform');
                $table->foreign ('id_banners_platform')->references ('id')
                    ->on ('banners_platforms')->onDelete ('cascade');
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists ('banners');
        Schema::dropIfExists ('banners_platforms');
    }

}
