<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket - {{ $booking->order_id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #db2777;
            padding: 30px;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #db2777;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #db2777;
            text-transform: uppercase;
        }
        .ticket-title {
            font-size: 20px;
            margin-top: 10px;
            color: #555;
        }
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-box {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .trip-details {
            background-color: #fff1f2;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 30px;
        }
        .qr-placeholder {
            text-align: right;
        }
        .status-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 15px;
            background-color: #10b981;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="status-badge">PAID & CONFIRMED</div>
        
        <div class="header">
            <div class="logo">Pink Tour and Travel</div>
            <div class="ticket-title">E-TICKET / BOOKING VOUCHER</div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <div class="label">Booking ID</div>
                <div class="value">#{{ $booking->order_id }}</div>

                <div class="label">Guest Name</div>
                <div class="value">{{ $booking->user->name }}</div>
                
                <div class="label">Email Address</div>
                <div class="value">{{ $booking->user->email }}</div>
            </div>
            <div class="info-box" style="text-align: right;">
                <div class="label">Booking Date</div>
                <div class="value">{{ $booking->created_at->format('d M Y') }}</div>
                
                <div class="label">Phone Number</div>
                <div class="value">{{ $booking->phone }}</div>
            </div>
        </div>

        <div class="trip-details">
            <div class="label">Trip / Destination</div>
            <div class="value" style="font-size: 20px; color: #db2777;">{{ $booking->trip->title }}</div>

            <div style="display: table; width: 100%; margin-top: 15px;">
                <div style="display: table-cell; width: 33%;">
                    <div class="label">Departure Date</div>
                    <div class="value">{{ $booking->preferred_date->format('l, d M Y') }}</div>
                </div>
                <div style="display: table-cell; width: 33%;">
                    <div class="label">Participants</div>
                    <div class="value">{{ $booking->participants }} Person(s)</div>
                </div>
                <div style="display: table-cell; width: 33%; text-align: right;">
                    <div class="label">Total Price</div>
                    <div class="value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        @if($booking->special_request)
        <div style="margin-bottom: 20px;">
            <div class="label">Special Request</div>
            <div class="value" style="font-weight: normal; font-style: italic;">"{{ $booking->special_request }}"</div>
        </div>
        @endif

        <div style="background-color: #f8fafc; padding: 15px; border-left: 4px solid #db2777; font-size: 13px;">
            <strong>Important Notes:</strong>
            <ul style="margin-top: 5px; padding-left: 20px;">
                <li>Please bring this e-ticket (digital or printed) to the meeting point.</li>
                <li>Arrival at least 30 minutes before departure is recommended.</li>
                <li>This ticket is non-refundable but transferable with prior notice.</li>
            </ul>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>Pink Tour and Travel</strong> for your journey!</p>
            <p>Jl. Raya Banda Neira, Maluku, Indonesia | WhatsApp: +62 812-3456-7890</p>
        </div>
    </div>
</body>
</html>
