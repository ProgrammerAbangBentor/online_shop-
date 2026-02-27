<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportTransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        public string $start,
        public string $end
    ) {}

    public function collection()
    {
        return Transaction::query()
            ->whereBetween('created_at', [
                $this->start . ' 00:00:00',
                $this->end   . ' 23:59:59'
            ])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Order ID',
            'Nama Pelanggan',
            'Email',
            'No HP',
            'Metode Pembayaran',
            'Status',
            'Grand Total',
        ];
    }

    public function map($trx): array
    {
        $created = $trx->created_at ? Carbon::parse($trx->created_at)->format('d M Y H:i') : '-';

        return [
            $created,
            $trx->order_id ?? '-',
            $trx->customer_name ?? '-',
            $trx->customer_email ?? '-',
            $trx->customer_phone ?? '-',
            $trx->payment_type ?? '-',
            $trx->transaction_status ?? '-',
            (int) ($trx->grand_total ?? 0),
        ];
    }
}
