<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Achievement</title>
    <style>
        @page {
            margin: 0px;
            size: A4 landscape;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            margin: 0; 
            padding: 0;
            width: 100%;
            height: 100%;
            position: relative;
            background-color: #fdfdfd;
            color: #333333;
        }
        
        /* Ornamental Border */
        .border-outer {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 6px double #1e3a8a;
            padding: 10px;
            z-index: 10;
        }
        .border-inner {
            width: 100%;
            height: 100%;
            border: 2px solid #5580ce;
            position: relative;
        }
        
        /* Background Shapes */
        .shape-tl-1 { position: absolute; top: -10px; left: -10px; width: 0; height: 0; border-style: solid; border-width: 350px 350px 0 0; border-color: #e2ebf9 transparent transparent transparent; z-index: -3; }
        .shape-tl-2 { position: absolute; top: -10px; left: -10px; width: 0; height: 0; border-style: solid; border-width: 200px 200px 0 0; border-color: #90b3ec transparent transparent transparent; z-index: -2; }
        
        .shape-br-1 { position: absolute; bottom: -10px; right: -10px; width: 0; height: 0; border-style: solid; border-width: 0 0 450px 450px; border-color: transparent transparent #e2ebf9 transparent; z-index: -3; }
        .shape-br-2 { position: absolute; bottom: -10px; right: -10px; width: 0; height: 0; border-style: solid; border-width: 0 0 300px 300px; border-color: transparent transparent #3065c7 transparent; z-index: -2; }

        .content {
            padding: 40px 60px;
            text-align: center;
        }

        .corp-learning {
            position: absolute;
            top: 40px;
            left: 50px;
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
            color: #1e3a8a;
            letter-spacing: 1px;
        }
        
        .logo-box {
            position: absolute;
            top: 30px;
            right: 50px;
            text-align: right;
        }

        .main-title {
            margin-top: 100px;
            font-size: 48px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .subtitle-award {
            margin-top: 10px;
            font-size: 18px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .name-presented {
            margin-top: 40px;
            font-size: 20px;
            font-style: italic;
            color: #555;
        }

        .trainee-name {
            margin-top: 10px;
            font-size: 42px;
            font-weight: bold;
            color: #000;
            border-bottom: 2px solid #5580ce;
            display: inline-block;
            padding: 0 40px 5px 40px;
        }

        .course-details {
            margin-top: 30px;
            font-size: 18px;
            line-height: 1.6;
            color: #444;
        }
        
        .course-title {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            display: block;
            margin-top: 10px;
        }

        .footer {
            position: absolute;
            bottom: 60px;
            width: 100%;
        }
        
        .footer-col {
            width: 33.33%;
            float: left;
            text-align: center;
        }

        .seal-box {
            margin-top: -30px;
        }

        .info-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .info-val {
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }

        .sig-box {
            padding: 0 40px;
        }
        .signature-img {
            max-width: 140px;
            height: 50px;
            margin-bottom: 5px;
        }
        .sig-line {
            border-top: 1px solid #1e3a8a;
            margin-top: 5px;
        }
        .sig-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="border-outer">
        <div class="border-inner">
            <!-- Corner Shapes Inside Border -->
            <div class="shape-tl-1"></div>
            <div class="shape-tl-2"></div>
            <div class="shape-br-1"></div>
            <div class="shape-br-2"></div>

            <div class="corp-learning">Corporate Learning</div>

            <div class="logo-box">
                @php
                    $logoPath = public_path('images/logo.png');
                    $logoBase64 = '';
                    if(file_exists($logoPath)) {
                        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                        $logoData = file_get_contents($logoPath);
                        $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
                    }
                @endphp
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" style="height: 50px;">
                @else
                    <div style="font-size:24px;font-weight:bold;color:#1e3a8a;">Kadel<span style="color:#8bc53f;">Labs</span></div>
                    <div style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:1px;">serving through technology</div>
                @endif
            </div>

            <div class="content">
                <div class="main-title">Certificate</div>
                <div class="subtitle-award">of Achievement</div>

                <div class="name-presented">This certificate is proudly presented to</div>
                <div class="trainee-name">{{ $certificate->user->name }}</div>

                <div class="course-details">
                    for the successful completion of the specialized course
                    <span class="course-title">{{ $certificate->course->title }}</span>
                </div>

                <div class="footer">
                    <div class="footer-col" style="text-align: left; padding-left: 60px;">
                        <div class="info-label">Issued on</div>
                        <div class="info-val">{{ $certificate->created_at->format('M d, Y') }}</div>
                        <div style="margin-top:15px;" class="info-label">Certificate ID</div>
                        <div class="info-val">#KL-{{ str_pad($certificate->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>

                    <div class="footer-col seal-box">
                        <!-- Gold Excellence Seal SVG fallback -->
                        <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="45" fill="#d4af37" stroke="#b8860b" stroke-width="2"/><circle cx="50" cy="50" r="38" fill="none" stroke="#fff" stroke-width="1" stroke-dasharray="2,2"/><path d="M50 20 L55 35 L70 35 L58 45 L63 60 L50 50 L37 60 L42 45 L30 35 L45 35 Z" fill="#fff"/><text x="50" y="75" text-anchor="middle" font-family="Arial" font-size="8" font-weight="bold" fill="#fff">EXCELLENCE</text></svg>') }}" width="80">
                    </div>

                    <div class="footer-col sig-box" style="text-align: right; padding-right: 60px;">
                        @php
                            $sigPath = public_path('images/signature.png');
                            $sigBase64 = '';
                            if(file_exists($sigPath)) {
                                $sigType = pathinfo($sigPath, PATHINFO_EXTENSION);
                                $sigData = file_get_contents($sigPath);
                                $sigBase64 = 'data:image/' . $sigType . ';base64,' . base64_encode($sigData);
                            }
                        @endphp
                        @if($sigBase64)
                            <img src="{{ $sigBase64 }}" alt="Signature" class="signature-img">
                        @else
                            <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="150" height="60" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg"><path d="M 20,60 L 25,20 L 30,60 C 35,20 40,30 45,60" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M 45,60 C 50,45 55,45 60,60 C 65,45 70,30 75,55 C 80,45 85,45 90,60" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M 110,60 C 100,50 115,20 120,25 C 130,30 100,40 125,55" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M 125,55 C 135,45 135,65 145,55 C 150,45 155,65 160,55 C 165,45 170,65 175,55" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="172" cy="40" r="2" fill="#222" /><path d="M 10,70 Q 100,80 190,40" fill="none" stroke="#222" stroke-width="1.5" stroke-linecap="round"/></svg>') }}" width="140" style="margin-bottom: 5px;">
                        @endif
                        <div class="sig-line"></div>
                        <div class="sig-name">NEHA SONI</div>
                        <div style="font-size: 10px; color: #777;">Director of Training</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
