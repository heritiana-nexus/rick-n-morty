<?php

namespace App\Controller\Character;


use App\Entity\Episode;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EpisodeController
 * @Route("/api/episode", name="episode_")
 */
class EpisodeController extends AbstractController
{

    private $repository;

    /**
     * EpisodeController constructor.
     * @param EpisodeRepository $episodeRepository
     */
    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->repository = $episodeRepository;
    }

    /**
     * @Route("/{id}", name="read", methods="GET")
     * @param Episode $episode
     * @return JsonResponse
     */
    public function read(Episode $episode)
    {
        return $this->json(['success' => true, 'episode' => ['id' => $episode->getId(), 'name' => $episode->getName()]]);
    }

    /**
     * @Route("", name="create", methods="POST")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request, EntityManagerInterface $em)
    {

        try {
            $payload = json_decode($request->getContent(), true);
            $episode = new Episode();
            $episode->setName($payload['name'] ?? '');
            $em->persist($episode);
            $em->flush($episode);
            return $this->json(['success' => true, 'id' => $episode->getId()], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return $this->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * @Route("", name="list", methods="GET")
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $list = [];
        foreach ($this->repository->findAll() as $episode) {
            $list[] = ['id' => $episode->getId(), 'name' => $episode->getName()];
        }
        return $this->json($list);
    }
}
