<?php

namespace App\Exports;

use App\Models\Booking;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class BookingExport
{
    public static function download($status)
    {
        $query = Booking::with(['user', 'trip']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->get();

        $templatePath = base_path('bookingrecaptemplate.xlsx');
        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found at " . $templatePath);
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Set Header Info
        // K2: REKAPAN PEMESANAN BULAN
        Carbon::setLocale('id');
        $monthName = Carbon::now()->translatedFormat('F Y');
        $sheet->setCellValue('K2', 'REKAPAN PEMESANAN BULAN ' . strtoupper($monthName));

        // K3: STATUS
        $statusLabels = [
            'all' => 'SEMUA',
            'pending' => 'PENDING (MENUNGGU)',
            'confirmed' => 'CONFIRMED (DIPESAN)',
            'completed' => 'COMPLETED (SELESAI)',
            'cancelled' => 'CANCELLED (DIBATALKAN)',
        ];
        $displayStatus = $statusLabels[strtolower($status)] ?? strtoupper($status);
        $sheet->setCellValue('K3', 'STATUS: ' . $displayStatus);

        // Data starts at row 7
        $row = 7;
        foreach ($bookings as $booking) {
            $sheet->setCellValue('I' . $row, $booking->order_id);
            $sheet->setCellValue('J' . $row, $booking->user->name ?? 'N/A');
            $sheet->setCellValue('K' . $row, $booking->trip->title ?? 'N/A');
            $sheet->setCellValue('L' . $row, (float) $booking->total_price);
            
            $formattedDate = $booking->preferred_date ? $booking->preferred_date->format('Y-m-d') : 'N/A';
            $sheet->setCellValue('M' . $row, $formattedDate);

            // Styling for the data row
            $styleArray = [
                'font' => [
                    'name' => 'Aptos Narrow',
                    'size' => 11,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];
            $sheet->getStyle("I$row:M$row")->applyFromArray($styleArray);

            // Alignments
            $sheet->getStyle("I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("M$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Price Number Formatting
            $sheet->getStyle("L$row")->getNumberFormat()->setFormatCode('#,##0');

            $row++;
        }

        // Auto-fit column widths
        foreach (range('I', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "bookings_" . $status . "_" . date('Y-m-d_His') . ".xlsx";
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }
}

