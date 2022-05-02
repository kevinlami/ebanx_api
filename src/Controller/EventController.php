<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use src\Helpers\Account;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event-index", methods={"POST"})
     */
    public function index(Request $request): JsonResponse
    {
        $params = $request->toArray();
        $account = new Account;
        $body = $account->process_event($params);

        if ($body) {
            return $this->json($body, 201);
        } 

        return $this->json(0, 404);
    }
}
