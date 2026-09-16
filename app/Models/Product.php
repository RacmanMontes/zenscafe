<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $sku
 * @property int $category_id
 * @property int|null $supplier_id
 * @property string $unit
 * @property int $quantity
 * @property int $min_stock
 * @property int|null $max_stock
 * @property float|null $cost_per_unit
 * @property string $status
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['name', 'slug', 'sku', 'category_id', 'supplier_id', 'unit', 'quantity', 'min_stock', 'max_stock', 'cost_per_unit', 'status', 'description'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    public const STATUS_ACTIVE = 'active';

    public const STATUS_ARCHIVED = 'archived';

    protected static function booted(): void
    {
        static::saving(function (Product $product): void {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the category that this product belongs to.
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the supplier for this product.
     *
     * @return BelongsTo<Supplier, $this>
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the inventory transactions for this product.
     *
     * @return HasMany<InventoryTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Determine if the product is low on stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->min_stock;
    }

    /**
     * Determine if the product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  Builder<Product>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include low stock products.
     *
     * @param  Builder<Product>  $query
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0)
            ->whereColumn('quantity', '<=', 'min_stock')
            ->where('quantity', '>', 0);
    }

    /**
     * Scope a query to only include out of stock products.
     *
     * @param  Builder<Product>  $query
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Scope a query to only include products that are in stock.
     *
     * @param  Builder<Product>  $query
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0)
            ->where(function (Builder $sub) {
                $sub->where('quantity', '>', 'min_stock')
                    ->orWhereNull('min_stock');
            });
    }
}
