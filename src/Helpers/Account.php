<?php

namespace src\Helpers;

class Account
{
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';
    const TYPE_TRANSFER = 'transfer';

    const JSON_PATH = __DIR__ . '/../Repository/account.json';

    public function __construct()
    {
        $this->json = Json::read(self::JSON_PATH);
    }

    public function reset()
    {
        Json::clear(self::JSON_PATH);
    }

}
