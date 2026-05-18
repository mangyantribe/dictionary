<?php

namespace App\Repositories;
use App\Models\Word;
use App\Interfaces\WordInterface;
class WordRepository implements WordInterface
{
    public function saveWord($data)
    {
        return Word::updateOrCreate(['word' => $data['word']],$data);
    }

    public function getWords($search = null)
    {
        return Word::query()->when($search, function ($query) use ($search) {
            $query->where('word', 'like', '%' . $search . '%');
        })->orderBy('word')->paginate(10);
    }

    public function findWord($id)
    {
        return Word::find($id);
    }
}
