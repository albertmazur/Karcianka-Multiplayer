<?php

namespace App\Repository;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface GameRepository{
    public function add(int $idAuth, int $user): Game;
    public function remove(int $idAuth, int $user): User;
    public function listLatestGames(int $idAuth): Collection;
    public function listFriends(int $idAuth): Collection;
    public function getLast(int $id): Game|null;
}
