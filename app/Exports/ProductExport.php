<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $rowNumber = 0;
    private $belowMinimumRows = [];

    public function collection()
    {
        // Ambil data dan urutkan berdasarkan status stok
        $products = Product::with(['supplier', 'largestUnit', 'smallestUnit'])
            ->get()
            ->sortBy(function ($product) {
                // Produk dengan stok di bawah minimum akan berada di atas
                return $product->smallest_stock >= $product->minimum_smallest_stock;
            });

        if ($products->isEmpty()) {
            throw new \Exception('Tidak ada data produk yang dapat diexport');
        }

        return $products;
    }

    public function map($product): array
    {
        $this->rowNumber++;

        $isbelowMinimum = $product->smallest_stock <= $product->minimum_smallest_stock;
        if ($isbelowMinimum) {
            $this->belowMinimumRows[] = $this->rowNumber + 1; // +1 karena header ada di baris 1
        }

        $stockStatus = $isbelowMinimum ? 'Di bawah minimum' : 'Stok aman';

        return [
            $product->name ?? '-',
            $product->type ?? '-',
            $product->drug_group ?? '-',
            $product->sku ?? '-',
            optional($product->supplier)->name ?? '-',
            optional($product->largestUnit)->symbol ?? '-',
            optional($product->smallestUnit)->symbol ?? '-',
            $product->conversion_value ?? 0,
            $product->largest_stock ?? 0,
            $product->smallest_stock ?? 0,
            $product->minimum_smallest_stock ?? 0,
            $stockStatus,
            'Rp ' . number_format($product->purchase_price ?? 0, 2, ',', '.'),
            'Rp ' . number_format($product->selling_price ?? 0, 2, ',', '.'),
            ($product->margin_percentage ?? 0) . '%',
            $product->is_active ? 'Aktif' : 'Tidak Aktif',
            $product->description ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Tipe',
            'Golongan Obat',
            'SKU',
            'Supplier',
            'Satuan Terbesar',
            'Satuan Terkecil',
            'Nilai Konversi',
            'Stok Satuan Besar',
            'Stok Satuan Kecil',
            'Minimum Stok Kecil',
            'Status Stok',
            'Harga Beli',
            'Harga Jual',
            'Persentase Margin',
            'Status',
            'Deskripsi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => ['font' => ['bold' => true]],
            'M:N' => ['alignment' => ['horizontal' => 'right']], // Align currency columns
        ];

        // Terapkan background merah dan text putih untuk baris dengan stok di bawah minimum
        foreach ($this->belowMinimumRows as $row) {
            $sheet->getStyle($sheet->getCellByColumnAndRow(1, $row)->getColumn() . $row . ':' .
                $sheet->getCellByColumnAndRow(17, $row)->getColumn() . $row)
                ->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FF0000']
                    ],
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF']
                    ]
                ]);
        }

        return $styles;
    }
}
