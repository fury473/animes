<?php

namespace Fury473\Bundle\AtarashiiBundle\Model;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class Anime
 * @author Olivier Haag <olivierhaag92@gmail.com>
 */
class Anime implements DenormalizableInterface
{
    const STATUS_WATCHING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_ONHOLD = 3;
    const STATUS_DROPPED = 4;
    const STATUS_PLANTOWATCH = 6;
    const STATUS_ALL = 7;
    /** @var \DateTime */
    private $endDate;
    /** @var string */
    private $englishTitle;
    /** @var int */
    private $episodes;
    /** @var int */
    private $id;
    /** @var string */
    private $image;
    /** @var float */
    private $score;
    /** @var \DateTime */
    private $startDate;
    /** @var string */
    private $status;
    /** @var array */
    private $synonyms;
    /** @var string */
    private $synopsis;
    /** @var string */
    private $title;
    /** @var string */
    private $type;
    /** @var \DateTime */
    private $userEndDate;
    /** @var \DateTime */
    private $userLastUpdated;
    /** @var int */
    private $userRewatchingEpisode;
    /** @var float */
    private $userScore;
    /** @var \DateTime */
    private $userStartDate;
    /** @var int */
    private $userStatus;
    /** @var array */
    private $userTags;
    /** @var int */
    private $userWatchedEpisodes;

    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $anime = new static();

        if (isset($context['groups']) && in_array('list', $context['groups'])) {
            $this->fetchListData($anime, $data);
        } else {
            $anime->setId((int)$data['id']);
            $anime->setTitle($data['title']);
            $anime->setEnglishTitle($data['english']);
            $anime->setSynonyms($data['synonyms']);
            $anime->setEpisodes((int)$data['episodes']);
            $anime->setScore((float)$data['score']);
            $anime->setType($data['type']);
            $anime->setStatus($data['status']);
            $anime->setStartDate(new \DateTime($data['start_date']));
            $anime->setEndDate(new \DateTime($data['end_date']));
            $anime->setSynopsis(strip_tags(str_replace("\n", "", $data['synopsis'])));
            $anime->setImage($data['image']);
        }

        return $anime;
    }

    public function fetchListData(Anime $anime, $data)
    {
        $anime->setId((int)$data['series_animedb_id']);
        $anime->setTitle($data['series_title']);
        $synonyms = explode(';', $data['series_synonyms']);
        array_walk($synonyms, function (&$value) {
            $value = trim($value);
        });
        $anime->setSynonyms($synonyms);
        $anime->setEpisodes((int)$data['series_episodes']);
        $anime->setType((int)$data['series_type']);
        $anime->setStatus((int)$data['series_status']);
        $anime->setStartDate(new \DateTime($data['series_start']));
        $anime->setEndDate(new \DateTime($data['series_end']));
        $anime->setImage($data['series_image']);
        $anime->setUserEndDate($data['my_finish_date']);
        $anime->setUserRewatchingEpisode($data['my_rewatching_ep']);
        $anime->setUserScore((float)$data['my_score']);
        $anime->setUserStartDate($data['my_start_date']);
        $anime->setUserStatus((int)$data['my_status']);
        $anime->setUserWatchedEpisodes((int)$data['my_watched_episodes']);
        $anime->setUserLastUpdated((new \DateTime())->setTimestamp($data['my_last_updated']));
        $tags = explode(';', $data['my_tags']);
        array_walk($tags, function (&$value) {
            $value = trim($value);
        });
        $anime->setUserTags($tags);
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getEnglishTitle()
    {
        return $this->englishTitle;
    }

    /**
     * @return int
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSynonyms()
    {
        return $this->synonyms;
    }

    /**
     * @return string
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getUserEndDate()
    {
        return $this->userEndDate;
    }

    /**
     * @return \DateTime
     */
    public function getUserLastUpdated()
    {
        return $this->userLastUpdated;
    }

    /**
     * @return int
     */
    public function getUserRewatchingEpisode()
    {
        return $this->userRewatchingEpisode;
    }

    /**
     * @return float
     */
    public function getUserScore()
    {
        return $this->userScore;
    }

    /**
     * @return \DateTime
     */
    public function getUserStartDate()
    {
        return $this->userStartDate;
    }

    /**
     * @return int
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * @return array
     */
    public function getUserTags()
    {
        return $this->userTags;
    }

    /**
     * @return int
     */
    public function getUserWatchedEpisodes()
    {
        return $this->userWatchedEpisodes;
    }

    /**
     * @param \DateTime $endDate
     * @return Anime
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param string $englishTitle
     * @return Anime
     */
    public function setEnglishTitle($englishTitle)
    {
        $this->englishTitle = $englishTitle;
        return $this;
    }

    /**
     * @param int $episodes
     * @return Anime
     */
    public function setEpisodes($episodes)
    {
        $this->episodes = $episodes;
        return $this;
    }

    /**
     * @param int $id
     * @return Anime
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $image
     * @return Anime
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param float $score
     * @return Anime
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @param \DateTime $startDate
     * @return Anime
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param string $status
     * @return Anime
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $synonyms
     * @return Anime
     */
    public function setSynonyms($synonyms)
    {
        $this->synonyms = $synonyms;
        return $this;
    }

    /**
     * @param string $synopsis
     * @return Anime
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
        return $this;
    }

    /**
     * @param string $title
     * @return Anime
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $type
     * @return Anime
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param \DateTime $userEndDate
     * @return Anime
     */
    public function setUserEndDate($userEndDate)
    {
        $this->userEndDate = $userEndDate;
        return $this;
    }

    /**
     * @param \DateTime $userLastUpdated
     * @return Anime
     */
    public function setUserLastUpdated($userLastUpdated)
    {
        $this->userLastUpdated = $userLastUpdated;
        return $this;
    }

    /**
     * @param int $userRewatchingEpisode
     * @return Anime
     */
    public function setUserRewatchingEpisode($userRewatchingEpisode)
    {
        $this->userRewatchingEpisode = $userRewatchingEpisode;
        return $this;
    }

    /**
     * @param float $userScore
     * @return Anime
     */
    public function setUserScore($userScore)
    {
        $this->userScore = $userScore;
        return $this;
    }

    /**
     * @param \DateTime $userStartDate
     * @return Anime
     */
    public function setUserStartDate($userStartDate)
    {
        $this->userStartDate = $userStartDate;
        return $this;
    }

    /**
     * @param int $userStatus
     * @return Anime
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
        return $this;
    }

    /**
     * @param array $userTags
     * @return Anime
     */
    public function setUserTags($userTags)
    {
        $this->userTags = $userTags;
        return $this;
    }

    /**
     * @param int $userWatchedEpisodes
     * @return Anime
     */
    public function setUserWatchedEpisodes($userWatchedEpisodes)
    {
        $this->userWatchedEpisodes = $userWatchedEpisodes;
        return $this;
    }
}
