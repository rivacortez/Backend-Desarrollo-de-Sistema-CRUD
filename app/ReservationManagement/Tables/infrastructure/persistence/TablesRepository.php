<?php

namespace App\ReservationManagement\Tables\infrastructure\persistence;


use App\ReservationManagement\Tables\domain\exeptions\TablesCreationException;
use App\ReservationManagement\Tables\domain\exeptions\TablesDeletionException;
use App\ReservationManagement\Tables\domain\exeptions\TablesNotFoundException;
use App\ReservationManagement\Tables\domain\exeptions\TablesUpdateException;
use App\ReservationManagement\Tables\Domain\Model\Aggregates\Tables;

use Illuminate\Support\Facades\Validator;

class TablesRepository
{
    public function getAll()
    {
        return Tables::all();
    }

    public function getById($id)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        return $table;
    }

    public function store(array $data)
    {
        $validator = Validator::make($data, (new Tables())->rules());

        if ($validator->fails()) {
            throw new TablesCreationException($validator->errors()->first());
        }

        try {
            return Tables::create($data);
        } catch (\Exception $e) {
            throw new TablesCreationException("Failed to create table: " . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        $validator = Validator::make($data, $table->rules());

        if ($validator->fails()) {
            throw new TablesUpdateException($validator->errors()->first());
        }

        try {
            $table->update($data);
            return $table;
        } catch (\Exception $e) {
            throw new TablesUpdateException("Failed to update table: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        try {
            return $table->delete();
        } catch (\Exception $e) {
            throw new TablesDeletionException("Failed to delete table: " . $e->getMessage());
        }
    }
}
