<?php

namespace App\ReservationManagement\Customers\domain\model\aggregates;

use Database\Factories\CustomersFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Customers Aggregate Root
 *
 * This class represents the Customer entity as an aggregate root in the domain model.
 * It serves as the central entity within the Customers bounded context and encapsulates
 * the core business rules and attributes for customer management.
 *
 * In the reservation system, customers are essential entities who make reservations
 * for tables. This class provides the structure and validation rules for customer data.
 *
 * @property int $id Primary key identifier
 * @property string $nombre Customer's name
 * @property string $correo Customer's email address (unique)
 * @property string|null $telefono Customer's phone number
 * @property string|null $direccion Customer's physical address
 * @property \Carbon\Carbon $created_at Timestamp of creation
 * @property \Carbon\Carbon $updated_at Timestamp of last update
 */
class Customers extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * These fields can be bulk set through the create() or fill() methods.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'correo', 'telefono', 'direccion'];

    /**
     * Get the validation rules for the model.
     *
     * These rules ensure data integrity and business rule compliance
     * for customer information. Used during creation and updates
     * to validate incoming data.
     *
     * Rules:
     * - nombre: Required, max 255 characters
     * - correo: Required valid email, unique within customers table (except current record)
     * - telefono: Optional, max 20 characters
     * - direccion: Optional, max 255 characters
     *
     * @return array<string, string> The validation rules array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:customers,correo,' . $this->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ];
    }

    protected static function newFactory()
    {
        return CustomersFactory::new();
    }
}
