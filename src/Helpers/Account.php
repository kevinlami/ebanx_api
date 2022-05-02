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

    public function getBalance($account_id)
    {
        return Utils::getArrayValueByKey($this->json, $account_id);
    }

    public function deposit($destination, $amount)
    {
        if ($this->accountExist($destination)) {
            $this->json[$destination] += $amount;
        } else {
            $this->json[$destination] = $amount;
        }

        return [
            'destination' => [
                'id' => $destination,
                'balance' => $this->json[$destination]
            ]
        ];
    }
    
    public function withdraw($origin, $amount)
    {
        $this->json[$origin] -= $amount;

        return [
            'origin' => [
                'id' => $origin,
                'balance' => $this->json[$origin]
            ]
        ];
    }
    
    public function transfer($origin, $amount, $destination)
    {
        $withdraw = $this->withdraw($origin, $amount);
        $deposit = $this->deposit($destination, $amount);

        return $withdraw + $deposit;
    }

    public function process_event($params)
    {
        $type = Utils::getArrayValueByKey($params, 'type');
        $amount = Utils::getArrayValueByKey($params, 'amount');
        $origin = Utils::getArrayValueByKey($params, 'origin');
        $destination = Utils::getArrayValueByKey($params, 'destination');
        $originExist = $this->accountExist($origin);
        $destinationExist = $this->accountExist($destination);
        $body = false;

        if( $type === self::TYPE_DEPOSIT && $amount && $destination)
        {
            $body = $this->deposit($destination, $amount);
        }
        
        if ( $type === self::TYPE_WITHDRAW && $originExist && $amount)
        {
            $body = $this->withdraw($origin, $amount);
        }
        
        if ( $type === self::TYPE_TRANSFER && $amount && $originExist)
        {
            $body = $this->transfer($origin, $amount, $destination);
        }

        if ($body) {
            $this->_save();
        }
        
        return $body;
    }

    protected function _save()
    {
        return Json::write(self::JSON_PATH, $this->json);
    }

    public function accountExist($account_id)
    {
        if(is_array($this->json) && array_key_exists($account_id, $this->json)) {
            return true;
        }
        return false;
    }
}
