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
}
