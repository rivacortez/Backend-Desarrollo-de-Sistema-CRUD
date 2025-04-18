<?php

namespace App\ReservationManagement\Customers\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Customers\application\internal\commandservices\CustomersCommandServiceImpl;
use App\ReservationManagement\Customers\application\internal\queryservices\CustomersQueryServiceImpl;
use App\ReservationManagement\Customers\domain\model\commands\CustomerCommand;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\interfaces\rest\resources\CustomersResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Commensals", description="API Endpoints for Commensals")
 */
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

    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Get all customers",
     *     tags={"Customers"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all customers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $customers = $this->queryService->execute(new GetAllCustomersQuery());
        return CustomersResource::collection($customers);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Get a customer by ID",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer details",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function show($id)
    {
        $customer = $this->queryService->executeById(new GetAllCustomersByIdQuery($id));
        return new CustomersResource($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="correo", type="string", example="juan.perez@example.com"),
     *             @OA\Property(property="telefono", type="string", example="555-123-4567"),
     *             @OA\Property(property="direccion", type="string", example="Av. Insurgentes Sur 123, CDMX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update a customer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez Actualizado"),
     *             @OA\Property(property="correo", type="string", example="juan.perez.update@example.com"),
     *             @OA\Property(property="telefono", type="string", example="555-987-6543"),
     *             @OA\Property(property="direccion", type="string", example="Nueva Dirección 456, CDMX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Delete a customer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
