<?php

namespace Fury473\Bundle\AtarashiiBundle\Service;

use Fury473\Bundle\AtarashiiBundle\Model\Account;
use Fury473\Bundle\AtarashiiBundle\Model\Anime;
use GuzzleHttp\Exception\ClientException;

/**
 * Class AnimeService
 * @author Olivier Haag <olivierhaag92@gmail.com>
 */
class AnimeService extends AbstractService
{

    const TYPE_ANIME = 'anime';
    const TYPE_MANGA = 'manga';

    const STATUS_WATCHING = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_ONHOLD = 4;
    const STATUS_DROPPED = 5;
    const STATUS_PLANTOWATCH = 6;
    const STATUS_ALL = 7;

    /**
     * @param $username
     * @return array
     */
    public function animeList($username)
    {
        $response = $this->getClient()->request('GET', '/2.1/animelist/' . $username);

        return $this->getSerializer()->decode((string)$response->getBody(), 'json');
        $myInfo = $data['myinfo'];
        $list = $data[$type];
        $account = (new Account())->denormalize($this->getSerializer(), $myInfo);
        $animes = [];
        foreach ($list as $row) {
            $animes[] = (new Anime())->denormalize($this->getSerializer(), $row, null, ['groups' => ['list']]);
        }
        return ['infos' => $account, 'animes' => $animes];
    }

    /**
     * @return Anime[]
     */
    public function search($q)
    {
        try {
            $query = http_build_query(['q' => $q]);
            $response = $this->getClient()->request('GET', '/api/anime/search.xml?' . $query);
        } catch (ClientException $e) {
            $this->handleClientException($e);
            return null;
        }

        $data = $this->getSerializer()->decode((string)$response->getBody(), 'xml');
        $animes = [];
        foreach ($data['entry'] as $item) {
            $animes[] = (new Anime())->denormalize($this->getSerializer(), $item);
        }

        return $animes;
    }


    /**
     * @param string $type
     * @return string
     */
    private function getClass($type)
    {
        switch ($type) {
            case static::TYPE_ANIME:
                return Anime::class;
            case static::TYPE_MANGA:
                return Manga::class;
        }
    }
}