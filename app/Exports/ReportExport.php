<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ReportExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    public function array(): array
    {
        $data = [
            [
                'Penjualan',
                'Rp ' . number_format($this->report['penjualan'], 2, ',', '.')
            ],
            [
                'Tuslah',
                'Rp ' . number_format($this->report['tuslah'], 2, ',', '.')
            ],
            [
                'Diskon Penjualan',
                'Rp ' . number_format($this->report['diskon_penjualan'], 2, ',', '.')
            ],
            [
                'Retur Penjualan',
                'Rp ' . number_format($this->report['retur_penjualan'], 2, ',', '.')
            ],
            [
                'Penjualan Bersih',
                'Rp ' . number_format($this->report['penjualan_bersih'], 2, ',', '.')
            ],
            [
                'Harga Pokok Pembelian',
                'Rp ' . number_format($this->report['harga_pokok_pembelian'], 2, ',', '.')
            ],
            [
                'Keuntungan Apotek',
                'Rp ' . number_format($this->report['keuntungan_apotek'], 2, ',', '.')
            ],
            // Empty row with green background
            ['', ''],
        ];

        // Add payment type heading row
        $data[] = ['Jenis Pembayaran', 'Jumlah Transaksi', 'Total Nominal'];

        // Add payment type rows
        foreach ($this->report['payment_types'] as $paymentType) {
            $data[] = [
                $paymentType->name,
                $paymentType->transaction_count,
                'Rp ' . number_format($paymentType->total_amount, 2, ',', '.'),
            ];
        }

        // Add another empty row with green background
        $data[] = ['', '', ''];

        // Add total row
        $data[] = [
            'Total Semua Jenis Pembayaran',
            $this->report['total_transactions'],
            'Rp ' . number_format($this->report['total_amount'], 2, ',', '.'),
        ];

        return $data;
    }

    public function headings(): array
    {
        return [
            'Keterangan',
            'Nominal',
            'Total Nominal' // Column for payment type totals
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $greenRowIndexes = [9, $lastRow - 1]; // Adjusted for the empty green rows

        $styles = [
            1 => ['font' => ['bold' => true]],
            9 => ['font' => ['bold' => true]], // Payment type header row
            $lastRow => ['font' => ['bold' => true]], // Total row
            'A' => ['font' => ['bold' => true]],
        ];

        // Set right alignment for amount columns
        for ($row = 1; $row <= $lastRow; $row++) {
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal('right');
            if ($row >= 9) { // Only for payment type rows
                $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal('right');
            }
        }

        // Apply green background to separator rows
        foreach ($greenRowIndexes as $rowIndex) {
            $sheet->getStyle('A' . $rowIndex . ':C' . $rowIndex)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('C6EFCE'); // Light green
        }

        return $styles;
    }
}
