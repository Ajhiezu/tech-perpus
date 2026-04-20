<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoansExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Loan::with(['user', 'loanDetails.book'])
            ->when($this->request->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->request->start_date))
            ->when($this->request->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->request->end_date))
            ->when($this->request->status, fn($q) => $q->where('status', $this->request->status))
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Pinjam',
            'Member',
            'Buku',
            'Tgl Pinjam',
            'Tgl Kembali Plan',
            'Tgl Kembali Real',
            'Denda',
            'Status',
        ];
    }

    public function map($loan): array
    {
        return [
            $loan->id,
            $loan->user->name,
            $loan->loanDetails->map(fn($d) => $d->book->title)->implode(', '),
            $loan->loan_date,
            $loan->due_date,
            $loan->return_date ?? '-',
            $loan->fine_amount ?? 0,
            strtoupper($loan->status),
        ];
    }
}
