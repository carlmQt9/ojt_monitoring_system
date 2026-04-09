<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OJT Certificate – {{ $student->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Great+Vibes&family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 100%; height: 100%;
            background: #e8e0d0;
            display: flex; align-items: center; justify-content: center;
            font-family: 'EB Garamond', Georgia, serif;
        }

        /* ── Certificate shell ── */
        .cert {
            width: 277mm;          /* A4 landscape width */
            height: 190mm;         /* A4 landscape height minus margins */
            background: #fffdf5;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 14mm 18mm;
        }

        /* Thick outer border */
        .cert::before {
            content: '';
            position: absolute; inset: 6mm;
            border: 3px solid #b8860b;
            pointer-events: none; z-index: 0;
        }
        /* Thin inner border */
        .cert::after {
            content: '';
            position: absolute; inset: 8mm;
            border: 1px solid #d4a843;
            pointer-events: none; z-index: 0;
        }

        /* Watermark crest */
        .watermark {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none; z-index: 0;
            opacity: 0.04;
        }
        .watermark svg { width: 160mm; height: 160mm; }

        /* Corner ornaments */
        .corner {
            position: absolute; width: 22mm; height: 22mm;
            z-index: 1; pointer-events: none;
        }
        .corner.tl { top: 3mm; left: 3mm; }
        .corner.tr { top: 3mm; right: 3mm; transform: scaleX(-1); }
        .corner.bl { bottom: 3mm; left: 3mm; transform: scaleY(-1); }
        .corner.br { bottom: 3mm; right: 3mm; transform: scale(-1,-1); }

        /* Content */
        .content { position: relative; z-index: 2; width: 100%; text-align: center; }

        .institution {
            font-family: 'Cinzel', serif;
            font-size: 8pt; letter-spacing: 0.25em;
            color: #8b6914; text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .cert-title {
            font-family: 'Cinzel', serif;
            font-size: 28pt; font-weight: 700;
            color: #1a1208; letter-spacing: 0.15em;
            line-height: 1;
        }

        .cert-subtitle {
            font-family: 'EB Garamond', serif;
            font-size: 10pt; color: #b8860b;
            letter-spacing: 0.35em; text-transform: uppercase;
            margin-top: 1mm;
        }

        .divider {
            display: flex; align-items: center; gap: 4mm;
            margin: 3mm auto; width: 80%;
        }
        .divider-line { flex: 1; height: 1px; background: linear-gradient(to right, transparent, #c9a227, transparent); }
        .divider-diamond {
            width: 5px; height: 5px;
            background: #c9a227;
            transform: rotate(45deg); flex-shrink: 0;
        }

        .presented-to {
            font-family: 'EB Garamond', serif;
            font-size: 9.5pt; color: #555; letter-spacing: 0.12em;
            text-transform: uppercase; margin-bottom: 1mm;
        }

        .recipient-name {
            font-family: 'Great Vibes', cursive;
            font-size: 38pt; color: #8b4513;
            line-height: 1.1; margin: 1mm 0 2mm;
        }

        .body-text {
            font-family: 'EB Garamond', serif;
            font-size: 10pt; color: #2c2c2c;
            line-height: 1.75; max-width: 200mm; margin: 0 auto;
        }

        /* Signatures row */
        .sig-row {
            display: flex; align-items: flex-end;
            justify-content: space-between;
            width: 100%; margin-top: 6mm;
            padding: 0 8mm;
        }
        .sig-block { text-align: center; min-width: 50mm; }
        .sig-name {
            font-family: 'EB Garamond', serif;
            font-size: 9.5pt; font-weight: 600; color: #1a1208;
        }
        .sig-line {
            border-top: 1px solid #888;
            width: 50mm; margin: 0 auto 1.5mm;
        }
        .sig-role {
            font-family: 'EB Garamond', serif;
            font-size: 8pt; color: #777; letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* ── Print rules ── */
        @media print {
            html, body {
                background: white;
                width: 100%; height: 100%;
                display: block;
            }
            .no-print { display: none !important; }
            .cert {
                width: 100vw; height: 100vh;
                page-break-inside: avoid;
                box-shadow: none;
            }
        }

        @page {
            size: landscape;
            margin: 8mm;
        }
    </style>
</head>
<body>

    <!-- Print button (hidden when inside iframe, hidden on print) -->
    <div class="no-print" id="actionBar" style="position:fixed;top:12px;right:12px;z-index:999;display:flex;gap:8px;">
        <button onclick="window.print()"
            style="padding:8px 18px;background:#b8860b;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:sans-serif;">
            🖨️ Print / Save PDF
        </button>
        <button onclick="window.close()"
            style="padding:8px 18px;background:#374151;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:sans-serif;">
            ✕ Close
        </button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Hide action bar when rendered inside an iframe (modal view)
        if (window.self !== window.top) {
            document.getElementById('actionBar').style.display = 'none';
        }

        // Called by parent modal's Download PDF button
        window.downloadAsPdf = function(filename) {
            const cert = document.querySelector('.cert');
            html2canvas(cert, { scale: 3, useCORS: true, backgroundColor: '#fffdf5' }).then(canvas => {
                const { jsPDF } = window.jspdf;
                // Landscape A4
                const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
                const pdfW = pdf.internal.pageSize.getWidth();
                const pdfH = pdf.internal.pageSize.getHeight();
                const imgData = canvas.toDataURL('image/jpeg', 1.0);
                pdf.addImage(imgData, 'JPEG', 0, 0, pdfW, pdfH);
                pdf.save(filename || 'OJT_Certificate.pdf');
            });
        };
    </script>

    <div class="cert">

        <!-- Watermark -->
        <div class="watermark">
            <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" stroke="#b8860b" stroke-width="4"/>
                <circle cx="100" cy="100" r="78" stroke="#b8860b" stroke-width="2"/>
                <path d="M100 20 L108 70 L160 70 L116 100 L132 150 L100 122 L68 150 L84 100 L40 70 L92 70 Z" fill="#b8860b"/>
            </svg>
        </div>

        <!-- Corner ornaments -->
        @php
        $cornerSvg = '<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2 L78 2 L78 12 L12 12 L12 78 L2 78 Z" fill="#c9a227" opacity=".5"/>
            <path d="M2 2 L30 2 L30 6 L6 6 L6 30 L2 30 Z" fill="#c9a227"/>
            <rect x="2" y="2" width="10" height="10" fill="#c9a227"/>
            <circle cx="20" cy="20" r="4" fill="#c9a227" opacity=".6"/>
        </svg>';
        @endphp
        <div class="corner tl">{!! $cornerSvg !!}</div>
        <div class="corner tr">{!! $cornerSvg !!}</div>
        <div class="corner bl">{!! $cornerSvg !!}</div>
        <div class="corner br">{!! $cornerSvg !!}</div>

        <!-- Main content -->
        <div class="content">

            <p class="institution">College of Computing and Information Technology</p>

            <p class="cert-title">CERTIFICATE</p>
            <p class="cert-subtitle">— &nbsp; of completion &nbsp; —</p>

            <div class="divider">
                <div class="divider-line"></div>
                <div class="divider-diamond"></div>
                <div class="divider-line"></div>
            </div>

            <p class="presented-to">This is to proudly certify that</p>
            <p class="recipient-name">{{ $student->name }}</p>

            <p class="body-text">
                a student of the <strong>College of Computing and Information Technology</strong>,
                has fulfilled all the requirements of the On-the-Job Training program
                @if($student->school_year)
                for Academic Year <strong>{{ $student->school_year }}</strong>,
                @endif
                having rendered a total of <strong>{{ number_format($hours, 2) }} hours</strong>
                out of the required <strong>{{ $required }} hours</strong>
                at <strong>{{ $student->company->name ?? 'the assigned company/organization' }}</strong>.
            </p>

            <p class="body-text" style="margin-top:3mm; font-style:italic; font-size:9.5pt; color:#444;">
                Throughout the training period, this student demonstrated exemplary work ethic,
                technical competence, and a strong sense of professional responsibility —
                qualities that reflect the standards upheld by this institution.
            </p>

            <div class="divider" style="margin-top:4mm;">
                <div class="divider-line"></div>
                <div class="divider-diamond"></div>
                <div class="divider-line"></div>
            </div>

            <!-- Signatures -->
            <div class="sig-row">
                <div class="sig-block">
                    <div class="sig-line"></div>
                    <p class="sig-name">{{ $student->certificate_awarded_by ?? 'Supervisor' }}</p>
                    <p class="sig-role">Company Supervisor</p>
                </div>

                <!-- Center: date + seal -->
                <div style="text-align:center;">
                    <svg width="64" height="64" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <radialGradient id="sg2" cx="38%" cy="32%">
                                <stop offset="0%" stop-color="#ffe680"/>
                                <stop offset="55%" stop-color="#f0a500"/>
                                <stop offset="100%" stop-color="#a06000"/>
                            </radialGradient>
                        </defs>
                        <g transform="translate(50,44)">
                            @for($i=0;$i<20;$i++)
                            <rect x="-2.5" y="-40" width="5" height="13" rx="2" fill="#d4a017" transform="rotate({{ $i*18 }})"/>
                            @endfor
                        </g>
                        <circle cx="50" cy="44" r="28" fill="url(#sg2)" stroke="#a06000" stroke-width="1.5"/>
                        <circle cx="50" cy="44" r="23" fill="none" stroke="#ffe066" stroke-width="1" opacity=".5"/>
                        <path d="M37 44 L46 53 L65 34" stroke="#5a3000" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M36 72 L50 63 L64 72 L60 85 L50 78 L40 85 Z" fill="#d4a017" stroke="#a06000" stroke-width="1"/>
                    </svg>
                    <p style="font-family:'EB Garamond',serif;font-size:8pt;color:#777;margin-top:2mm;">
                        {{ $student->certificate_awarded_at->format('F d, Y') }}
                    </p>
                </div>

                <div class="sig-block">
                    <div class="sig-line"></div>
                    <p class="sig-name">OJT Coordinator</p>
                    <p class="sig-role">CCIT Department</p>
                </div>
            </div>

        </div><!-- end content -->
    </div><!-- end cert -->

</body>
</html>
