<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;
use App\Game;

class Edit extends Component
{
    public $game;

    public function render()
    {
        return view('livewire.game.edit');
    }

    public function mount(Game $game)
    {
        $this->game = $game->toArray();
    }

    public function updateGame()
    {
        $this->validate([
            'game.title' => 'required',
        ]);
        $game = Game::find($this->game['id']);
        $game->fill($this->game);

        $game->save();

        session()->flash('status', '"' . $game->title . '" updated!');

        return redirect()->route('home');
    }

    public function getHasImageProperty()
    {
        $imgExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (!empty($this->game['image'])) {
            $path = parse_url($this->game['image']);
            if (!empty($path['path'])) {
                $extension = strtolower(pathinfo($path['path'], PATHINFO_EXTENSION));
                if (in_array($extension, $imgExtensions, true)) {
                    return true;
                }
            }
        }
        return false;
    }
}
