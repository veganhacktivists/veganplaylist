<?php

namespace App\Http\Controllers;

use App\Playlist;
use App\PseudoCrypt;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return redirect('playlist/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if ($request->has('name')) {
            $name = $request->input('name');
        } else {
            $name = '';
        }

        return view('playlist', ['name' => $name]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:playlists|max:42',
            'video_ids' => 'required|min:1',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $name = $request->input('name');
        $ids = $request->input('video_ids');
        if (empty($name)) {
            $name = PseudoCrypt::hash($ids[0], 8);
        }

        $playlist = Playlist::create(['name' => $name, 'creator_id' => Auth::id()]);

        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $playlist->videos()->attach([
                $id => ['order' => $i],
            ]);
        }
        return response()->json($playlist, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist) {
        if (!$playlist->active) abort(404);
        if (is_null($playlist->creator) or !$playlist->creator->is(Auth::user())) abort(403);
        return view('playlist', ['playlist' => $playlist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist) {
        if (is_null($playlist->creator) or !$playlist->creator->is(Auth::user())) abort(403);

        $request->validate([
            'name' => 'required|max:42',
            'video_ids' => 'required|min:1',
        ]);

        $name = $request->input('name');
        $ids  = $request->input('video_ids');

        $playlist->name = $name;
        $playlist->save();

        $playlist->videos()->detach();

        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $playlist->videos()->attach([
                $id => ['order' => $i],
            ]);
        }
        return response()->json($playlist, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist) {
        if (is_null($playlist->creator) or !$playlist->creator->is(Auth::user())) abort(403);
        $playlist->active = 0;
        $playlist->save();
        return response()->json($playlist, 200);
    }

    public function show(Playlist $playlist, Video $video = null) {
        if (!$playlist->active) abort(404);
        // Reference them once so it populates and shows up in the json, TODO: find a setting to make that happen auto
        $playlist->creator;
        $playlist->videos;

        if (is_null($video)) {
            $index = 0;
        } else {
            $index = $playlist->videos->search(function ($item, $key) use ($video) {return $item->is($video);});
        }

        $editUrl = false;
        $deleteUrl = false;
        if ($playlist->creator) {
            $creatorProfileUrl = route('profile', $playlist->creator);
            if ($playlist->creator->is(Auth::user())) {
                $editUrl   = route('playlist.edit',    $playlist);
                $deleteUrl = route('playlist.destroy', $playlist);
            }
        } else {
            $creatorProfileUrl = false;
        }
        $playlist->display_length = $playlist->getDisplayLengthAttribute();

        $playlist->views += 1;
        Playlist::where('id', $playlist->id)->update(array('views' => $playlist->views));

        return view('viewer', [
            'index'             => $index,
            'playlist'          => $playlist,
            'editUrl'           => $editUrl,
            'deleteUrl'         => $deleteUrl,
            'creatorProfileUrl' => $creatorProfileUrl,
            'suppressFooter'    => true
        ]);
    }
}
