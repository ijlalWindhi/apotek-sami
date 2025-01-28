<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            width: 80mm;
            /* Standard thermal receipt width */
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 10px;
            width: 75%;
            /* ubah jadi 100% jika printer lebih besar */
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
        }

        .store-info {
            font-size: 12px;
        }

        .receipt-body {
            font-size: 12px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .receipt-table th,
        .receipt-table td {
            text-align: left;
            padding: 3px 0;
        }

        .receipt-table-item {
            width: 40%;
        }

        .amount-column {
            text-align: right;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .total-section {
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            width: 75%;
            /* ubah jadi 100% jika printer lebih besar */
        }
    </style>
</head>

<body>
    <div class="receipt-header">
        <div class="store-name">APOTEK SUMI TOMO</div>
        <div class="store-info">
            Jl. Kebon Agung No.37, Ngaran, Margokaton, Kec. Seyegan, Kab. Sleman, DIY<br>
            Telp: 085728843033
        </div>
    </div>

    <div class="receipt-body">
        <div>
            No. Invoice: <span id="invoice-number"></span><br>
            Tanggal: <span id="transaction-date"></span><br>
            Kasir: <span id="cashier-name"></span>
        </div>

        <div class="divider"></div>

        <table class="receipt-table" id="items-table">
            <thead>
                <tr>
                    <th class="receipt-table-item">Item</th>
                    <th>Qty</th>
                    <th class="amount-column ">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Items will be inserted here dynamically -->
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="total-section">
            <table class="receipt-table">
                <tr>
                    <td>Subtotal</td>
                    <td class="amount-column" id="subtotal"></td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td class="amount-column" id="discount"></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="amount-column"><strong id="total"></strong></td>
                </tr>
                <tr>
                    <td>Tunai</td>
                    <td class="amount-column" id="cash-amount"></td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td class="amount-column" id="change-amount"></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Terima kasih atas kunjungan Anda<br>
            Semoga lekas sembuh
        </div>
    </div>
</body>

</html>
