<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket #{{ $ticket->ticket_number }}</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 50px;
        }
        .ticket-container {
            width: 100%;
            height: 350px;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        .main-content {
            float: left;
            width: 70%;
            height: 100%;
            padding: 30px;
            box-sizing: border-box;
        }
        .stub {
            float: right;
            width: 30%;
            height: 100%;
            background-color: #16a34a;
            color: #ffffff;
            padding: 30px;
            box-sizing: border-box;
            border-left: 2px dashed #ffffff;
            position: relative;
        }
        /* Stub notches */
        .notch-top {
            position: absolute;
            top: -15px;
            left: -15px;
            width: 30px;
            height: 30px;
            background-color: #f1f5f9;
            border-radius: 50%;
        }
        .notch-bottom {
            position: absolute;
            bottom: -15px;
            left: -15px;
            width: 30px;
            height: 30px;
            background-color: #f1f5f9;
            border-radius: 50%;
        }
        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .match-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0f172a;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-label {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
        }
        .stub-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            opacity: 0.8;
        }
        .stub-info {
            margin-bottom: 15px;
        }
        .stub-label {
            font-size: 9px;
            opacity: 0.7;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .stub-value {
            font-size: 14px;
            font-weight: bold;
        }
        .barcode-area {
            margin-top: 30px;
            text-align: center;
        }
        .barcode {
            height: 60px;
            width: 100%;
            background-color: #000;
        }
        .ticket-number {
            font-family: monospace;
            font-size: 12px;
            margin-top: 5px;
        }
        .tag {
            display: inline-block;
            padding: 4px 10px;
            background-color: #dcfce7;
            color: #166534;
            border-radius: 6px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="main-content">
            <div class="brand">FootballTix</div>
            <div class="tag">{{ $ticket->ticketType->type ?? 'Standard' }} ADMISSION</div>
            <div class="match-title">{{ $ticket->match->home_team }} <span style="color:#16a34a">v</span> {{ $ticket->match->away_team }}</div>
            
            <table class="info-table">
                <tr>
                    <td width="50%" style="padding-bottom: 20px;">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ $ticket->match->match_date->format('F j, Y') }}</div>
                    </td>
                    <td width="50%" style="padding-bottom: 20px;">
                        <div class="info-label">Time</div>
                        <div class="info-value">{{ $ticket->match->match_date->format('g:i A') }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="info-label">Stadium</div>
                        <div class="info-value">{{ $ticket->match->stadium }}</div>
                    </td>
                    <td>
                        <div class="info-label">Gate / Entrance</div>
                        <div class="info-value">General Entry</div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="stub">
            <div class="notch-top"></div>
            <div class="notch-bottom"></div>
            
            <div class="stub-title">Admission Stub</div>
            
            <div class="stub-info">
                <div class="stub-label">Holder</div>
                <div class="stub-value">{{ $ticket->user->name }}</div>
            </div>
            
            <div class="stub-info">
                <div class="stub-label">Price</div>
                <div class="stub-value">£{{ number_format($ticket->price, 2) }}</div>
            </div>

            <div class="barcode-area">
                <div style="height: 60px; background-color: #ffffff; border-radius: 4px; padding: 5px;">
                    <div style="width: 100%; height: 100%; background: #000; border-right: 2px solid white;">
                        <div style="float: left; width: 10%; height: 100%; background: #000; border-right: 2px solid white;"></div>
                        <div style="float: left; width: 5%; height: 100%; background: #000; border-right: 4px solid white;"></div>
                        <div style="float: left; width: 15%; height: 100%; background: #000; border-right: 1px solid white;"></div>
                        <div style="float: left; width: 8%; height: 100%; background: #000; border-right: 3px solid white;"></div>
                        <div style="float: left; width: 12%; height: 100%; background: #000; border-right: 2px solid white;"></div>
                        <div style="float: left; width: 20%; height: 100%; background: #000; border-right: 5px solid white;"></div>
                        <div style="float: left; width: 10%; height: 100%; background: #000; border-right: 1px solid white;"></div>
                    </div>
                </div>
                <div class="ticket-number">#{{ $ticket->ticket_number }}</div>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 20px; color: #94a3b8; font-size: 10px;">
        Official ticket issued by FootballTix. Non-transferable. Valid for single entry only.
    </div>
</body>
</html>
