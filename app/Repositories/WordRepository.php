<?php

namespace App\Repositories;
use App\Models\Word;
use App\Models\Translation;
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

    public function saveTranslation($data)
    {
        return Translation::updateOrCreate([
            'word_id' => $data['word_id'],
            'country_id' => $data['country_id'],
            ],$data
        );
    }

    public function getTranslation($wordId,$cursor = null)
    {
        //return Translation::with('country')->where('word_id', $wordId)->get();
        return Translation::with('country')->where('word_id', $wordId)->cursorPaginate(
            10,
            ['id', 'country_id', 'translation'],
            'cursor',
            $cursor
        );
    }
}
