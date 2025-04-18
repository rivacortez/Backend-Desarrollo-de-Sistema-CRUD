<?php

namespace App\ReservationManagement\Tables\domain\model\aggregates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Tables Aggregate Root Entity
 *
 * This class represents the Table aggregate root within the Reservation Management bounded context.
 * It encapsulates all table-related attributes and business rules, serving as the primary entity
 * for restaurant table management operations.
 *
 * As an aggregate root, this entity enforces invariants and business rules for tables,
 * ensuring data integrity and consistency in the restaurant seating management system.
 *
 * The class handles:
 * - Core table data (table number, capacity, location)
 * - Validation rules to maintain data integrity
 * - Persistence mapping to the database layer
 *
 * In the domain model, a table can be reserved by customers and is a critical
 * resource managed by the restaurant reservation system.
 *
 * @property int $id Unique identifier for the table
 * @property string $numero_mesa Table number or code (must be unique)
 * @property int $capacidad Seating capacity of the table
 * @property string|null $ubicacion Physical location of the table within the restaurant
 * @property \DateTime $created_at Timestamp of record creation
 * @property \DateTime $updated_at Timestamp of last record update
 */
class Tables extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model
     *
     * @var string
     */
    protected $table = 'tables';

    /**
     * The attributes that are mass assignable
     *
     * Defines which fields can be filled through mass assignment operations,
     * protecting other attributes from unintended modification.
     *
     * @var array<string>
     */
    protected $fillable = ['numero_mesa', 'capacidad', 'ubicacion'];

    /**
     * Get validation rules for table attributes
     *
     * Defines the validation constraints that ensure table data integrity.
     * These rules enforce:
     * - Required and unique table number with maximum length
     * - Required positive capacity value
     * - Optional location description
     *
     * The unique constraint includes the current record's ID to allow updates
     * without triggering unique validation errors when the table number isn't changed.
     *
     * @return array<string, string> The validation rules for table attributes
     */
    public function rules()
    {
        return [
            'numero_mesa' => 'required|string|max:20|unique:tables,numero_mesa,' . $this->id,
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:255',
        ];
    }
}
