<?php

namespace App\Repositories;

use App\Models\Keyword;
use DateInterval;
use DateTime;

class KeywordRepository
{
    public function hasValidKeyword(string $name) : bool
    {
        $keyword = Keyword::where('name', $name)
            ->where('expiry_datetime', '>', (new DateTime('now'))->format('Y-m-d H:i:s'))
            ->first();

        return !($keyword === null);
    }

    public function updateOrCreate(array $parameters = [])
    {
        $parameters['expiry_datetime'] = (new DateTime('now'))
            ->add(new DateInterval('P1D'))
            ->format('Y-m-d H:i:s');

        return Keyword::updateOrCreate(
            ['name' => $parameters['name']],
            $parameters
        );
    }
}
