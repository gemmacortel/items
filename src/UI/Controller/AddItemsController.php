<?php

namespace App\UI\Controller;

use App\Application\Exception\ItemNotFoundException;
use App\Application\Service\AddItems;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddItemsController extends AbstractController
{
    private $applicationService;

    public function __construct(AddItems $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * @Route("/add/{id}/{quantity}", name="add", requirements={"id" = "\d+"}, methods={"PATCH"})
     * @param int $id
     * @param int $quantity
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(int $id, int $quantity)
    {
        try {
            $itemData = $this->applicationService->execute($id, $quantity);
        } catch (ItemNotFoundException $e) {
            return $this->json('The item does not exist', Response::HTTP_BAD_REQUEST);
        }

        return $this->json($itemData);
    }
}
