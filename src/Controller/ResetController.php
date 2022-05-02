<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use src\Helpers\Account;

class ResetController extends AbstractController
{
    /**
     * @Route("/reset")
     */
    public function index(): JsonResponse
    {
        $account = new Account;
        $account->reset();
        return JsonResponse::fromJsonString('OK');
    }
}
