<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Add extends Component
{
    public $title;
    public $year;
    public $bgg_id;
    public $image;
    public $description;
    public $players_min;
    public $players_max;
    public $playtime_min;
    public $playtime_max;
    public $complexity;
    public $rating;
    public $categories;
    public $notes;

    public $bgg_url = 'https://www.boardgamegeek.com/xmlapi2/';
    public $game_suggestions = [];

    public function render()
    {
        return view('livewire.game.add');
    }

    public function getGameTitles($term)
    {
        $this->game_suggestions = [];
        if (strlen($term) < 3) {
            return;
        }
        $cacheKey = 'game_title_' . $term;
        if (!$response = simplexml_load_string(Cache::get($cacheKey))) {
            $type = 'boardgame,boardgameaccessory';
            $response = simplexml_load_file($this->bgg_url . 'search?query=' . $term . '&type=' . $type);
            Cache::put($cacheKey, $response->asXML(), 60*60*24);
        }
        if (false !== $response) {
            foreach ($response->item as $item) {
                $this->game_suggestions[] = [
                    'id'    => (string) $item['id'],
                    'label' => (string) $item->name['value'],
                    'year'  => (string) $item->yearpublished['value'],
                ];
            }
        }
    }

    public function chooseGame($game_id)
    {
        $this->game_suggestions = [];
        $cacheKey = 'game_' . $game_id;
        if (!$response = simplexml_load_string(Cache::get($cacheKey))) {
            $response = simplexml_load_file($this->bgg_url . 'thing?id=' . $game_id);
            Cache::put($cacheKey, $response->asXML(), 60*60*24);
        }
        if (false !== $response) {
            $item = $response->item;
            $description = html_entity_decode((string) $item->description, ENT_XML1, 'UTF-8');
            $this->title = (string) $item->name['value'];
            $this->year = (int) $item->yearpublished['value'];
            $this->bgg_id = $game_id;
            $this->image = (string) $item->thumbnail;
            $this->description = str_replace(['&mdash;', '&ndash;'], ' - ', $description);
            $this->players_min = (int) $item->minplayers['value'];
            $this->players_max = (int) $item->maxplayers['value'];
            $this->playtime_min = (int) $item->minplaytime['value'];
            $this->playtime_max = (int) $item->maxplaytime['value'];
            $this->categories = [];
            foreach ($item->link as $link) {
                switch ($link['type']) {
                    case 'boardgamecategory':
                        $this->categories[] = (string) $link['value'];
                        break;
                }
            }
        }
    }

    public function addGame()
    {
        $this->validate([
            'title' => 'required',
        ]);

        Game::create(
            [
                'title' => $this->title,
                'year' => $this->year,
                'bgg_id' => $this->bgg_id,
                'image' => $this->image,
                'description' => $this->description,
                'players_min' => $this->players_min,
                'players_max' => $this->players_max,
                'playtime_min' => $this->playtime_min,
                'playtime_max' => $this->playtime_max,
                'complexity' => $this->complexity,
                'rating' => $this->rating,
                'categories' => implode(',', $this->categories),
                'notes' => $this->notes,
            ]
        );

        session()->flash('status', '"' . $this->title . '" added!');
        return redirect()->route('home');
    }

    public function getHasImageProperty()
    {
        $imgExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (!empty($this->image)) {
            $path = parse_url($this->image);
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
