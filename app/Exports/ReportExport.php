<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

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
            ['', '', '', '', '', '', '', ''],
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
        $data[] = ['', '', '', '', '', '', '', ''];

        // Add total row for payment types
        $data[] = [
            'Total Semua Jenis Pembayaran',
            $this->report['total_transactions'],
            'Rp ' . number_format($this->report['total_amount'], 2, ',', '.'),
        ];

        // Add another empty row with green background
        $data[] = ['', '', '', '', '', '', '', ''];

        // Add transaction details heading
        $data[] = ['Detail Transaksi'];
        $data[] = ['No', 'No. Invoice', 'Tanggal', 'Waktu', 'Tipe Customer', 'Status', 'Metode Pembayaran', 'Total', 'Diskon', 'Kasir'];

        // Add transaction details
        $no = 1;
        foreach ($this->report['transaction_details'] as $transaction) {
            $created_at = Carbon::parse($transaction->created_at);
            $data[] = [
                $no++,
                $transaction->invoice_number,
                $created_at->format('d-m-Y'),
                $created_at->format('H:i:s'),
                $transaction->customer_type,
                $transaction->status,
                $transaction->payment_type,
                'Rp ' . number_format($transaction->total_amount, 2, ',', '.'),
                'Rp ' . number_format($transaction->transaction_discount, 2, ',', '.'),
                $transaction->cashier_name,
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Keterangan',
            'Nominal',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 25,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 20,
            'H' => 20,
            'I' => 15,
            'J' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Find the row indexes for each section
        $paymentTypeStartRow = 9;
        $paymentSeparatorRow = null;
        $paymentTotalRow = null;
        $transactionHeaderRow = null;
        $transactionColumnsRow = null;

        // Find separators and headers
        for ($row = $paymentTypeStartRow; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();

            if ($cellValue === '' && $paymentSeparatorRow === null) {
                $paymentSeparatorRow = $row;
            } else if ($cellValue === 'Total Semua Jenis Pembayaran') {
                $paymentTotalRow = $row;
            } else if ($cellValue === 'Detail Transaksi') {
                $transactionHeaderRow = $row;
            } else if ($cellValue === 'No' && $sheet->getCell('B' . $row)->getValue() === 'No. Invoice') {
                $transactionColumnsRow = $row;
            }
        }

        // Get the green separator rows
        $greenRowIndexes = [9, $paymentSeparatorRow, $paymentTotalRow + 1];

        $styles = [
            1 => ['font' => ['bold' => true]],
            $paymentTypeStartRow => ['font' => ['bold' => true]], // Payment type header row
            $paymentTotalRow => ['font' => ['bold' => true]], // Total row
            $transactionHeaderRow => ['font' => ['bold' => true]], // Transaction details header
            $transactionColumnsRow => ['font' => ['bold' => true]], // Transaction columns row
            'A' => ['font' => ['bold' => true]],
        ];

        // Set right alignment for amount columns
        for ($row = 1; $row <= $lastRow; $row++) {
            // For summary and payment type sections
            if ($row <= $paymentTotalRow) {
                $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal('right');
                if ($row >= $paymentTypeStartRow) { // Only for payment type rows
                    $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal('right');
                }
            }

            // For transaction details section
            if ($row > $transactionColumnsRow) {
                // Align numeric columns to right
                $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal('right'); // Total
                $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal('right'); // Discount
            }
        }

        // Apply green background to separator rows
        foreach ($greenRowIndexes as $rowIndex) {
            $lastColumn = $sheet->getHighestColumn();
            $sheet->getStyle('A' . $rowIndex . ':' . $lastColumn . $rowIndex)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('C6EFCE'); // Light green
        }

        // Set center alignment for transaction details headers
        if ($transactionColumnsRow) {
            $sheet->getStyle('A' . $transactionColumnsRow . ':J' . $transactionColumnsRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Apply borders to transaction details
        if ($transactionColumnsRow && $lastRow > $transactionColumnsRow) {
            $borderStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A' . $transactionColumnsRow . ':J' . $lastRow)->applyFromArray($borderStyle);
        }

        return $styles;
    }
}
