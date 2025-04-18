<?php

namespace App\ReservationManagement\Customers\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Customers\application\internal\commandservices\CustomersCommandServiceImpl;
use App\ReservationManagement\Customers\application\internal\queryservices\CustomersQueryServiceImpl;
use App\ReservationManagement\Customers\domain\model\commands\CustomerCommand;
use App\ReservationManagement\Customers\interfaces\rest\resources\CustomersResource;
use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(
 *     name="Customers",
 *     description="API Endpoints for Customer Management"
 * )
 */
class CustomerController extends Controller
{
    private CustomersCommandServiceImpl $commandService;
    private CustomersQueryServiceImpl $queryService;

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
     *     summary="List all customers",
     *     description="Returns a collection of all customer records in the system",
     *     operationId="listCustomers",
     *     tags={"Customers"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Customer")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $customers = $this->queryService->execute(new \App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery());
        return CustomersResource::collection($customers);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Get customer details",
     *     description="Returns details for a specific customer by ID",
     *     operationId="getCustomer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Customer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function show(Customers $customer): CustomersResource
    {
        return new CustomersResource($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     description="Creates a new customer record in the system",
     *     operationId="createCustomer",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Customer data",
     *         @OA\JsonContent(
     *             required={"nombre", "correo", "telefono", "direccion"},
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan.perez@example.com"),
     *             @OA\Property(property="telefono", type="string", example="555-123-4567"),
     *             @OA\Property(property="direccion", type="string", example="Av. Insurgentes Sur 123, CDMX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Customer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"nombre": {"The nombre field is required."}}
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre'    => 'required|string',
            'correo'    => 'required|email|unique:customers,correo',
            'telefono'  => 'required|string',
            'direccion' => 'required|string',
        ]);

        $command = new CustomerCommand(
            null,
            $validated['nombre'],
            $validated['correo'],
            $validated['telefono'],
            $validated['direccion'],
        );

        $customer = $this->commandService->handle($command);

        return (new CustomersResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update a customer",
     *     description="Updates an existing customer record",
     *     operationId="updateCustomer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Customer data",
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez Actualizado"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan.updated@example.com"),
     *             @OA\Property(property="telefono", type="string", example="555-987-6543"),
     *             @OA\Property(property="direccion", type="string", example="Nueva Dirección 456, CDMX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Customer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"correo": {"The email has already been taken."}}
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, Customers $customer): CustomersResource
    {
        $validated = $request->validate([
            'nombre'    => 'sometimes|required|string',
            'correo'    => "sometimes|required|email|unique:customers,correo,{$customer->id}",
            'telefono'  => 'sometimes|required|string',
            'direccion' => 'sometimes|required|string',
        ]);

        $command = new CustomerCommand(
            $customer->id,
            $validated['nombre']    ?? $customer->nombre,
            $validated['correo']    ?? $customer->correo,
            $validated['telefono']  ?? $customer->telefono,
            $validated['direccion'] ?? $customer->direccion,
        );

        $updated = $this->commandService->handle($command);

        return new CustomersResource($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Delete a customer",
     *     description="Removes a customer record from the system",
     *     operationId="deleteCustomer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the customer to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Customer deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function destroy(Customers $customer): JsonResponse
    {
        $this->commandService->delete($customer->id);

        return response()->json([
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
