<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Game::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = $this->validator($data);

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $data['cover'] = $request->file('cover')->store('/public/games/covers');
        }
        if ($validator->fails()) {
            return response('Não foi possível salvar seu jogo', 400);
        }

        $data['user_id'] = 1;

        $game = Game::create($data);

        return $game;
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }

    public function validator(array $data)
    {
        return Validator($data, [
            'name' => ['required', 'max:200'],
            'description' => ['required'],
            'console' => ['required', 'max:100']
        ]);
    }
}
