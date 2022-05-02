<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use src\Helpers\Account;

class BalanceController extends AbstractController
{
    /**
     * @Route("/balance", name="balance-index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        $account_id = $request->query->get('account_id');
        $account = new Account;
        $balance = $account->getBalance($account_id);
        if ($balance) {
            return $this->json($balance);
        } 

        return $this->json(0, 404);
    }
}
