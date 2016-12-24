<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/")
     */
    public function profileAction()
    {
        $username = $this->getUser()->getUsername();
        $profile = $this->get('atarashii.service.user')->profile($username);
        $animeList = $this->get('atarashii.service.anime')->animeList($username);
        return $this->render('user/profile.html.twig', [
            'avatarUrl' => $profile['avatar_url'],
            'animeList' => $animeList,
            'animeStats' => $profile['anime_stats'],
            'animeCharts' => $this->getAnimeCharts($profile['anime_stats']),
            'mangaCharts' => $this->getMangaCharts($profile['manga_stats']),
        ]);
    }

    private function getAnimeCharts(array $animeStats)
    {
        return [
            'watching' => [
                ['Status', 'Count'],
                ['Watching', $animeStats['watching']],
                ['Others', $animeStats['total_entries'] - $animeStats['watching']]
            ],
            'completed' => [
                ['Status', 'Count'],
                ['Completed', $animeStats['completed']],
                ['Others', $animeStats['total_entries'] - $animeStats['completed']]
            ],
            'dropped' => [
                ['Status', 'Count'],
                ['Dropped', $animeStats['dropped']],
                ['Others', $animeStats['total_entries'] - $animeStats['dropped']]
            ]
        ];
    }

    private function getMangaCharts(array $mangaStats)
    {
        return [
            'watching' => [
                ['Status', 'Count'],
                ['Reading', $mangaStats['reading']],
                ['Others', $mangaStats['total_entries'] - $mangaStats['reading']]
            ],
            'completed' => [
                ['Status', 'Count'],
                ['Completed', $mangaStats['completed']],
                ['Others', $mangaStats['total_entries'] - $mangaStats['completed']]
            ],
            'dropped' => [
                ['Status', 'Count'],
                ['Dropped', $mangaStats['dropped']],
                ['Others', $mangaStats['total_entries'] - $mangaStats['dropped']]
            ]
        ];
    }
}
