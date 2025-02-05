<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromArray, WithHeadings, WithStyles
{
    protected $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    public function array(): array
    {
        return [
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
        ];
    }

    public function headings(): array
    {
        return [
            'Keterangan',
            'Nominal'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A' => ['font' => ['bold' => true]],
            'B' => ['alignment' => ['horizontal' => 'right']],
        ];
    }
}
