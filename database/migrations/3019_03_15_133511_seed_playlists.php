<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Migrations\Migration;
use Faker\Provider\Lorem;

class SeedPlaylists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $g_user = new App\User;
        $g_user->name = 'Guest';
        $g_user->slug = 'guest';
        $g_user->email = 'g@vgn.soy';
        $g_user->password = Hash::make('imvegan');
        $g_user->save();

        $user = new App\User;
        $user->name = 'David';
        $user->slug = 'david';
        $user->email = 'd@d.d';
        $user->password = Hash::make('imvegan');
        $user->save();


        for( $i = 0; $i < 9; $i++ ) {

            $playlist = new App\Playlist;

            $playlist->name = ucwords( rtrim( Lorem::text(30), '.' ) );
            $playlist->creator_id = $user->id;
            $playlist->featured = true;
            $playlist->save();

            $videos = App\Video::inRandomOrder()->take( rand( 4, 10 ) )->get();
            $order = 0;

            foreach ($videos as $video) {
                DB::table('playlist_video_map')->insert(
                    array(
                        array(
                            'playlist_id' => $playlist->id,
                            'video_id' => $video->id,
                            'order' => $order++
                        )
                    )
                );
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
