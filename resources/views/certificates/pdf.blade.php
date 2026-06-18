<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado - {{ $certificate_code }}</title>
    <style>
        @page {
            margin: 0;
            size: {{ $paper_size ?? 'letter' }} {{ $orientation ?? 'landscape' }};
        }
        body {
            margin: 0;
            padding: 0;
            font-family: '{{ $font_family ?? 'Helvetica' }}', Arial, sans-serif;
            color: {{ $text_color }};
            background: {{ $background_color }};
        }
        .certificate-container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .border-decoration {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 4px solid {{ $primary_color }};
            border-radius: 8px;
        }
        .inner-border {
            position: absolute;
            top: 28px;
            left: 28px;
            right: 28px;
            bottom: 28px;
            border: 2px solid {{ $secondary_color }};
            border-radius: 4px;
        }
        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 60px 80px;
            width: 100%;
        }
        .logo {
            max-height: 60px;
            margin-bottom: 20px;
        }
        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: {{ $primary_color }};
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .subtitle {
            font-size: 18px;
            color: {{ $secondary_color }};
            margin: 0 0 30px 0;
            letter-spacing: 1px;
        }
        .recipient-name {
            font-size: 36px;
            font-weight: bold;
            color: {{ $primary_color }};
            margin: 20px 0;
            padding: 10px 40px;
            border-bottom: 2px solid {{ $accent_color }};
            display: inline-block;
        }
        .body-text {
            font-size: 16px;
            line-height: 1.6;
            margin: 20px auto;
            max-width: 600px;
        }
        .course-title {
            font-size: 22px;
            font-weight: bold;
            color: {{ $secondary_color }};
            margin: 10px 0;
        }
        .details-row {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 40px;
        }
        .detail-item {
            text-align: center;
        }
        .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            color: {{ $secondary_color }};
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: bold;
        }
        .signature-area {
            display: flex;
            justify-content: center;
            gap: 100px;
            margin-top: 50px;
        }
        .signature-block {
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-bottom: 1px solid {{ $text_color }};
            margin: 30px auto 10px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 14px;
        }
        .signature-role {
            font-size: 12px;
            color: {{ $secondary_color }};
        }
        .certificate-footer {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }
        .qr-code {
            margin-top: 15px;
            text-align: center;
        }
        .qr-code img {
            width: 80px;
            height: 80px;
        }
        .accent-bar-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, {{ $primary_color }}, {{ $accent_color }}, {{ $secondary_color }});
        }
        .accent-bar-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, {{ $secondary_color }}, {{ $accent_color }}, {{ $primary_color }});
        }
    </style>
</head>
<body>
    <div class="accent-bar-top"></div>
    <div class="accent-bar-bottom"></div>

    <div class="certificate-container">
        <div class="border-decoration">
            <div class="inner-border"></div>
        </div>

        <div class="content">
            @if($show_logo)
                <div style="text-align: center; margin-bottom: 10px;">
                    <span style="font-size: 24px; font-weight: bold; color: {{ $primary_color }};">NEXORA</span>
                    <span style="font-size: 14px; color: {{ $secondary_color }}; margin-left: 5px;">LEARNING</span>
                </div>
            @endif

            <h1 class="certificate-title">{{ $title }}</h1>
            <p class="subtitle">{{ $subtitle }}</p>

            <div class="recipient-name">{{ $employee_name }}</div>

            <p class="body-text">{{ $body_text }}</p>

            <div class="course-title">{{ $course_title }}</div>

            <div class="details-row">
                <div class="detail-item">
                    <div class="detail-label">Fecha de Emisión</div>
                    <div class="detail-value">{{ $issue_date }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Código</div>
                    <div class="detail-value">{{ $certificate_code }}</div>
                </div>
                @if($score !== null)
                <div class="detail-item">
                    <div class="detail-label">Calificación</div>
                    <div class="detail-value">{{ $score }}%</div>
                </div>
                @endif
            </div>

            @if($show_signature && $signature_name)
            <div class="signature-area">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $signature_name }}</div>
                    <div class="signature-role">{{ $signature_title }}</div>
                </div>
            </div>
            @endif

            @if($show_qr)
            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80">
                        <rect width="80" height="80" fill="white"/>
                        <text x="40" y="45" text-anchor="middle" font-size="8" fill="black">' . $certificate_code . '</text>
                    </svg>
                ') }}" alt="QR Code"/>
            </div>
            @endif
        </div>

        <div class="certificate-footer">
            Verifica este certificado en: nexoralearning.com/verify/{{ $certificate_code }}
        </div>
    </div>
</body>
</html>
