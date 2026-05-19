<?php

namespace App\Services;
use App\Interfaces\WordInterface;
class WordService
{
    protected $wordInterface;
    /**
     * Create a new class instance.
     */
    public function __construct(WordInterface $wordInterface)
    {
        $this->wordInterface = $wordInterface;
    }

    public function saveWord($request)
    {
        $data = [
            'word' => $request->word,
        ];
        return $this->wordInterface->saveWord($data);
    }

    public function getWords($keyword)
    {
        return $this->wordInterface->getWords($keyword);
    }

    public function findWord($id)
    {
        return $this->wordInterface->findWord($id);
    }

    public function saveTranslation($request)
    {
        $data = [
            'country_id' => $request->country,
            'word_id' => $request->wordId,
            'translation' => $request->translation,
            'sample' => $request->example,
        ];
        return $this->wordInterface->saveTranslation($data);
    }

    // public function getTranslation($wordId,$cursor)
    // {
    //     return $this->wordInterface->getTranslation($wordId,$cursor);    
    // }

    public function getTranslation($wordId,$cursor)
    {
        $data = [];

        $translations = $this->wordInterface->getTranslation($wordId,$cursor);

        foreach ($translations as $key => $translation) {

            $data[] = array(
                'id'            => $translation->id,
                'country'       => $translation->country?->name ,
                'translation'   => $translation->translation,  
            );
        }
        return [
            'data'   => $data,
            'cursor' => $translations->nextCursor()?->encode(),
        ];
    }
}
