<?php


namespace App\Controller\Character;


use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LocationController
 * @Route("/api/location", name="location_")
 */
class LocationController extends AbstractController
{

    private $repository;

    /**
     * LocationController constructor.
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->repository = $locationRepository;
    }

    /**
     * @Route("/{id}", name="read", methods="GET")
     * @param Location $location
     * @return JsonResponse
     */
    public function read(Location $location)
    {
        return $this->json(['success' => true, 'location' => ['id' => $location->getId(), 'name' => $location->getName()]]);
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
            $location = new Location();
            $location->setName($payload['name'] ?? '');
            $location->setType($payload['type'] ?? '');
            $location->setDimension($payload['dimension'] ?? '');
            $em->persist($location);
            $em->flush($location);
            return $this->json(['success' => true, 'id' => $location->getId()], Response::HTTP_CREATED);

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
        foreach ($this->repository->findAll() as $location) {
            $list[] = $location->serialize();
        }
        return $this->json($list);
    }
}