<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'loan_code', 'loan_type', 'loan_date', 'due_date', 'status', 'total_books'])]
class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_code',
        'loan_type',
        'loan_date',
        'due_date',
        'status',
        'total_books',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function returnBook(): HasOne
    {
        return $this->hasOne(ReturnBook::class);
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    public function isDigital(): bool
    {
        return $this->loan_type === 'digital';
    }

    public function isPhysical(): bool
    {
        return $this->loan_type === 'physical';
    }

    public function isActive(): bool
    {
        return $this->status === 'borrowed' && now()->startOfDay()->lte($this->due_date);
    }

    public function isExpired(): bool
    {
        return $this->status === 'borrowed' && now()->startOfDay()->gt($this->due_date);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'borrowed')->whereDate('due_date', '>=', now()->toDateString());
    }

    public function scopeDigital($query)
    {
        return $query->where('loan_type', 'digital');
    }

    public function scopePhysical($query)
    {
        return $query->where('loan_type', 'physical');
    }
}
