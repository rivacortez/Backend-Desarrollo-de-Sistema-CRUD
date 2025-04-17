<?php

namespace App\ReservationManagement\Customers\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Customers\Application\Internal\CommandServices\CustomersCommandServiceImpl;
use App\ReservationManagement\Customers\Application\Internal\QueryServices\CustomersQueryServiceImpl;
use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\Interfaces\Rest\Resources\CustomersResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $commandService;
    private $queryService;

    public function __construct(
        CustomersCommandServiceImpl $commandService,
        CustomersQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    public function index()
    {
        $customers = $this->queryService->execute(new GetAllCustomersQuery());
        return CustomersResource::collection($customers);
    }

    public function show($id)
    {
        $customer = $this->queryService->executeById(new GetAllCustomersByIdQuery($id));
        return new CustomersResource($customer);
    }

    public function store(Request $request)
    {
        $command = new CustomerCommand(
            null,
            $request->nombre,
            $request->correo,
            $request->telefono,
            $request->direccion
        );

        $customer = $this->commandService->handle($command);
        return new CustomersResource($customer);
    }

    public function update(Request $request, $id)
    {
        $command = new CustomerCommand(
            $id,
            $request->nombre,
            $request->correo,
            $request->telefono,
            $request->direccion
        );

        $customer = $this->commandService->handle($command);
        return new CustomersResource($customer);
    }

    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
