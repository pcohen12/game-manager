<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Game;

class Listing extends Component
{
    public $games;
    public $selected_game;

    public $default_filters = [
        'players' => 'All',
        'playtime' => 'Any'
    ];

    public $filter = [];

    public $modal_open = false;

    public function render()
    {
        return view('livewire.listing');
    }

    public function mount()
    {
        $this->resetFilters();
    }

    public function loadList()
    {
        $where = [];
        if ('All' !== $this->filter['players']) {
            $players = $this->filter['players'];
            $where[] = ['players_min', '<=', $players];
            $where[] = ['players_max', '>=', $players];
        }
        if ('Any' !== $this->filter['playtime']) {
            $playtime = $this->filter['playtime'];
            $where[] = ['playtime_min', '<=', $playtime];
        }
        $this->games = Game::where($where)
            ->orderBy('title')
            ->get();
    }

    public function resetFilters()
    {
        $this->filter = $this->default_filters;
        $this->loadList();
    }

    public function viewGame($game_id)
    {
        $this->selected_game = Game::find($game_id);
        $this->modal_open = true;
    }

    public function removeGame()
    {
        $this->selected_game->delete();
        $this->loadList();
        session()->flash('status', '"' . $this->selected_game->title . '" has been removed.');
        $this->selected_game = null;
        $this->modal_open = false;
    }
}
