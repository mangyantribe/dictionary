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
            'type' => $request->type,
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
            'kahulugan' => $request->kahulugan,
            'salin' => $request->salin,
            'halimbawa' => $request->halimbawa,
        ];
        return $this->wordInterface->saveTranslation($data);
    }

    public function getTranslation($wordId,$cursor)
    {
        $data = [];

        $translations = $this->wordInterface->getTranslation($wordId,$cursor);

        foreach ($translations as $key => $translation) {

            $data[] = array(
                'id'            => $translation->id,
                'country'       => $translation->country?->name ,
                'kahulugan'     => $translation->kahulugan,  
            );
        }
        return [
            'data'   => $data,
            'cursor' => $translations->nextCursor()?->encode(),
        ];
    }

    public function getCountryWords($id)
    {
        return $this->wordInterface->getCountryWords($id);
    }
}
