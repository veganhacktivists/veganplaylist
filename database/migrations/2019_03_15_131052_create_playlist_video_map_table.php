<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistVideoMapTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('playlist_video_map', function (Blueprint $table) {
			$table->unsignedBigInteger('playlist_id');
			$table->foreign('playlist_id')->references('id')->on('playlists');

			$table->unsignedBigInteger('video_id');
			$table->foreign('video_id')->references('id')->on('videos');

			$table->integer('order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('playlist_video_map');
	}
}
