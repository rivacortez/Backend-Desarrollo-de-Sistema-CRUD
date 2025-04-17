<?php

namespace App\ReservationManagement\Customers\Infrastructure\Persistence;

use App\ReservationManagement\Customers\Domain\Model\Aggregates\Customers;
use Illuminate\Support\Facades\Validator;

class CustomersRepository
{
    public function getAll()
    {
        return Customers::all();
    }

    public function getById($id)
    {
        return Customers::findOrFail($id);
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, (new Customers())->rules());

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        return Customers::create($data);
    }

    public function update($id, array $data)
    {
        $customer = Customers::findOrFail($id);

        $validator = Validator::make($data, $customer->rules());

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        $customer = Customers::findOrFail($id);
        return $customer->delete();
    }
}
