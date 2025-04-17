<?php

namespace App\ReservationManagement\Customers\infrastructure\persistence;

use App\ReservationManagement\Customers\domain\exeptions\CustomersCreationException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersDeletionException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersUpdateException;
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
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        return $customer;
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, (new Customers())->rules());

        if ($validator->fails()) {
            throw new CustomersCreationException($validator->errors()->first());
        }

        try {
            return Customers::create($data);
        } catch (\Exception $e) {
            throw new CustomersCreationException("Failed to create customer: " . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        $validator = Validator::make($data, $customer->rules());

        if ($validator->fails()) {
            throw new CustomersUpdateException($validator->errors()->first());
        }

        try {
            $customer->update($data);
            return $customer;
        } catch (\Exception $e) {
            throw new CustomersUpdateException("Failed to update customer: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        try {
            return $customer->delete();
        } catch (\Exception $e) {
            throw new CustomersDeletionException("Failed to delete customer: " . $e->getMessage());
        }
    }
}
