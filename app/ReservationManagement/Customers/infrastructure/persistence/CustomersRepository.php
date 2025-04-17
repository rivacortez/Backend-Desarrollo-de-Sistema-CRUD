<?php

namespace App\ReservationManagement\Customers\infrastructure\persistence;

use App\ReservationManagement\Customers\domain\exeptions\CustomerCreationException;
use App\ReservationManagement\Customers\domain\exeptions\CustomerDeletionException;
use App\ReservationManagement\Customers\domain\exeptions\CustomerNotFoundException;
use App\ReservationManagement\Customers\domain\exeptions\CustomerUpdateException;
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
            throw new CustomerNotFoundException("Customer with ID {$id} not found");
        }

        return $customer;
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, (new Customers())->rules());

        if ($validator->fails()) {
            throw new CustomerCreationException($validator->errors()->first());
        }

        try {
            return Customers::create($data);
        } catch (\Exception $e) {
            throw new CustomerCreationException("Failed to create customer: " . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomerNotFoundException("Customer with ID {$id} not found");
        }

        $validator = Validator::make($data, $customer->rules());

        if ($validator->fails()) {
            throw new CustomerUpdateException($validator->errors()->first());
        }

        try {
            $customer->update($data);
            return $customer;
        } catch (\Exception $e) {
            throw new CustomerUpdateException("Failed to update customer: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomerNotFoundException("Customer with ID {$id} not found");
        }

        try {
            return $customer->delete();
        } catch (\Exception $e) {
            throw new CustomerDeletionException("Failed to delete customer: " . $e->getMessage());
        }
    }
}
