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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Customer REST API Controller
 *
 * This controller implements the REST API endpoints for customer management following
 * CQRS (Command Query Responsibility Segregation) pattern. It provides operations for
 * creating, reading, updating, and deleting customer records within the restaurant
 * reservation system.
 *
 * @package App\ReservationManagement\Customers\interfaces\rest
 * @OA\Tag(name="Customers", description="API Endpoints for Customer Management")
 */
class CustomerController extends Controller
{
    /**
     * Command service for handling customer write operations
     *
     * @var CustomersCommandServiceImpl
     */
    private $commandService;

    /**
     * Query service for handling customer read operations
     *
     * @var CustomersQueryServiceImpl
     */
    private $queryService;

    /**
     * CustomerController constructor
     *
     * @param CustomersCommandServiceImpl $commandService Service for customer write operations
     * @param CustomersQueryServiceImpl $queryService Service for customer read operations
     */
    public function __construct(
        CustomersCommandServiceImpl $commandService,
        CustomersQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    /**
     * Retrieve all customers
     *
     * Returns a paginated collection of all customer records in the system.
     * Results are transformed through the CustomersResource for consistent API response format.
     *
     * @return AnonymousResourceCollection Collection of customer resources
     *
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
     * Retrieve a specific customer by ID
     *
     * Finds and returns a single customer record by its unique identifier.
     * Throws a CustomerNotFoundException (404) if the specified customer doesn't exist.
     *
     * @param int $id The unique identifier of the customer
     * @return CustomersResource The customer resource
     *
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
     * Create a new customer
     *
     * Processes the incoming request data to create a new customer record.
     * Validates input through command handler validation rules.
     * Returns 422 Unprocessable Entity response on validation failure.
     *
     * @param Request $request The HTTP request containing customer data
     * @return CustomersResource The newly created customer resource
     *
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
     * Update an existing customer
     *
     * Updates a specific customer record with the provided data.
     * Validates input through command handler validation rules.
     * Throws a CustomerNotFoundException (404) if the specified customer doesn't exist.
     *
     * @param Request $request The HTTP request containing updated customer data
     * @param int $id The unique identifier of the customer to update
     * @return CustomersResource The updated customer resource
     *
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
     * Delete a customer
     *
     * Permanently removes a customer record from the system.
     * Throws a CustomerNotFoundException (404) if the specified customer doesn't exist.
     * Returns a confirmation message upon successful deletion.
     *
     * @param int $id The unique identifier of the customer to delete
     * @return JsonResponse Response with success message
     *
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
