<?php

namespace App\Models;

use App\Enums\TransactionType;
use Database\Factories\InventoryTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property TransactionType $type
 * @property int $quantity
 * @property int $previous_quantity
 * @property int $new_quantity
 * @property Carbon|null $transacted_at
 * @property int|null $supplier_id
 * @property string|null $reference_number
 * @property string|null $reason
 * @property string|null $notes
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['product_id', 'type', 'quantity', 'previous_quantity', 'new_quantity', 'transacted_at', 'supplier_id', 'reference_number', 'reason', 'notes', 'user_id'])]
class InventoryTransaction extends Model
{
    /** @use HasFactory<InventoryTransactionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => TransactionType::class,
            'transacted_at' => 'datetime',
        ];
    }

    /**
     * Get the product associated with this transaction.
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the supplier associated with this transaction.
     *
     * @return BelongsTo<Supplier, $this>
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the user who performed this transaction.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate the next sequential reference number for a transaction type.
     */
    public static function generateReferenceNumber(TransactionType $type, ?Carbon $date = null): string
    {
        $date ??= now();

        $prefix = match ($type) {
            TransactionType::StockIn => 'STKIN',
            TransactionType::StockOut => 'STKOUT',
            TransactionType::Adjustment => 'ADJ',
        };

        $base = $prefix.'-'.$date->format('Ymd').'-';

        $latest = static::query()
            ->where('reference_number', 'like', $base.'%')
            ->orderByDesc('reference_number')
            ->value('reference_number');

        $sequence = $latest === null ? 1 : ((int) substr((string) strrchr((string) $latest, '-'), 1)) + 1;

        return $base.str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);
    }
}
