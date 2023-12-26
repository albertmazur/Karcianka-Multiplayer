<?php

namespace App\Http\Controllers;

use App\Events\GameBroadcast;
use App\Models\User;
use App\Repository\GameRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GameController extends Controller{

    private GameRepository $gameInvationRepository;

    public function __construct(GameRepository $gameInvationRepository){
        $this->gameInvationRepository = $gameInvationRepository;
    }

    public function start(): View{
        return view("game.index", [
            "friends" => $this->gameInvationRepository->listFriends(Auth::id()),
            "games" => $this->gameInvationRepository->listGames(Auth::id())
        ]);
    }

    public function single(): View{
        return view('game.single');
    }

    public function multiplayer(Request $request){
        $date = $request->validate(["id" => ["required", "integer"]]);
        $user = $this->gameInvationRepository->add(Auth::id(), $date["id"]);

        if($user == true) return view("game.multiplayer", ["user" => $user]);
        else return back()->with(["error" => "Nie uruchomiono gry"]);
    }

    public function join(Request $request){
        $date = $request->validate(["id" => ["required", "integer"]]);
        $user = User::find($date['id']);

        if($user == true) return view("game.multiplayer", ["user" => $user, "join" => 1]);
        else return back()->with(["error" => "Nie można dołaczyć do gry"]);
    }

    public function broadcast(Request $request){
        $date = $request->validate([
            "userId" => ["required", "integer"],
            "message" => ["string"],
        ]);

        if($date["message"] == "start"){

        }
        else{
            
        }
        event(new GameBroadcast($date["userId"], ["start" => $date["message"]]));

        return response()->json(['status' => 'Message sent!']);
    }
}
