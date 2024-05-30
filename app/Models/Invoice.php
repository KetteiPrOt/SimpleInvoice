<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'authorized',
        'status_details',
        'issuance_date',
        'access_key',
        'content',
        'user_id',
    ];

    public function appendSequential(): void
    {
        $sequential = $this->id;
        // Add left zeros
        for($i = 0; $i < 8; $i++){
            if($sequential < (10 ** ($i + 1))){
                $sequential = str_repeat('0', 8 - $i) . $sequential;
                break;
            }
        }
        $this->sequential = '001-001-' . $sequential;
    }

    /**
     * Relations
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
