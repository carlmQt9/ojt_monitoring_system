<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="utf-8">
<meta name="ProgId" content="Word.Document">
<title>OJT Narrative Report — {{ strtoupper($student->name) }}</title>
<!--[if gte mso 9]><xml>
  <w:WordDocument>
    <w:View>Print</w:View>
    <w:Zoom>100</w:Zoom>
    <w:DoNotOptimizeForBrowser/>
  </w:WordDocument>
</xml><![endif]-->
<style>
  @page Section1 {
    size: 8.5in 11in;
    margin: 1in 1in 1in 1in;
    mso-header-margin: .5in;
    mso-footer-margin: .5in;
    mso-paper-source: 0;
  }
  div.Section1 { page: Section1; }

  * { box-sizing: border-box; }
  body {
    font-family: "Times New Roman", serif;
    font-size: 12pt;
    color: #000;
    margin: 0;
    padding: 0;
    line-height: 1.5;
  }

  /* ─── Header ─── */
  .hdr {
    text-align: center;
    margin-bottom: 6pt;
  }
  .hdr .republic {
    font-size: 11pt;
    font-weight: normal;
    color: #000;
    text-transform: uppercase;
    letter-spacing: 0.5pt;
  }
  .hdr .univ {
    font-size: 13pt;
    font-weight: bold;
    color: #000;
    text-transform: uppercase;
  }
  .hdr .address {
    font-size: 10pt;
    color: #333;
    margin: 1pt 0 6pt;
  }
  .hdr .title-box {
    font-size: 13pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1.5pt;
    border-top: 1.5pt solid #000;
    border-bottom: 1.5pt solid #000;
    padding: 4pt 0;
    margin: 4pt 0 8pt;
  }

  /* ─── Divider ─── */
  hr.divider {
    border: none;
    border-top: 1pt solid #000;
    margin: 4pt 0 8pt;
  }

  /* ─── Info table ─── */
  table.info {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8pt;
    font-size: 11pt;
  }
  table.info td {
    width: 50%;
    padding: 3pt 4pt 6pt 4pt;
    vertical-align: top;
    border-bottom: 1pt solid #ccc;
  }
  table.info td:first-child { padding-right: 16pt; }
  table.info td:last-child  { padding-left: 16pt; border-left: 1pt solid #ccc; }
  .lbl { font-size: 8.5pt; color: #555; text-transform: uppercase; letter-spacing: 0.3pt; display: block; }
  .val { font-size: 11pt; font-weight: bold; border-bottom: 1pt solid #000; padding-bottom: 1pt; display: block; margin-top: 1pt; }
  .val-n { font-size: 11pt; border-bottom: 1pt solid #000; padding-bottom: 1pt; display: block; margin-top: 1pt; }

  /* ─── Summary row ─── */
  table.sumrow {
    width: 100%;
    border-collapse: collapse;
    border: 1pt solid #999;
    margin: 6pt 0 10pt;
    font-size: 10pt;
  }
  table.sumrow td {
    width: 33.33%;
    text-align: center;
    padding: 4pt 6pt;
    border-right: 1pt solid #ccc;
    vertical-align: middle;
  }
  table.sumrow td:last-child { border-right: none; }
  .s-lbl { font-size: 8pt; color: #444; text-transform: uppercase; display: block; }
  .s-val { font-size: 11pt; font-weight: bold; color: #000; display: block; }

  /* ─── Section heading ─── */
  .sec-heading {
    font-size: 11pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5pt;
    border-bottom: 1pt solid #000;
    padding-bottom: 2pt;
    margin: 8pt 0 6pt;
  }

  /* ─── Day entry ─── */
  .day-block {
    margin-bottom: 10pt;
    page-break-inside: avoid;
  }
  .day-hdr-table {
    width: 100%;
    border-collapse: collapse;
    background: #1a3a6b;
    margin-bottom: 0;
  }
  .day-hdr-table td {
    padding: 3pt 6pt;
    color: #fff;
    font-size: 10pt;
    vertical-align: middle;
  }
  .day-hdr-table .day-num { font-weight: bold; width: 60pt; }
  .day-hdr-table .day-dt  { font-size: 9pt; font-weight: normal; text-align: right; }
  .day-content {
    border: 1pt solid #bbb;
    border-top: none;
    padding: 5pt 8pt;
  }
  .day-desc {
    font-size: 11pt;
    line-height: 1.6;
    color: #000;
    margin: 0;
    padding: 0;
  }

  /* ─── Photo ─── */
  .photo-wrap {
    text-align: center;
    padding: 4pt 0 5pt;
    border-bottom: 1pt solid #e0e0e0;
    margin-bottom: 4pt;
  }
  .photo-wrap img {
    max-width: 2.8in;
    max-height: 2in;
    border: 1pt solid #bbb;
    display: block;
    margin: 0 auto 2pt;
  }
  .photo-cap {
    font-size: 8pt;
    color: #666;
    font-style: italic;
  }

  /* ─── Signature ─── */
  table.sig {
    width: 100%;
    border-collapse: collapse;
    margin-top: 28pt;
    font-size: 11pt;
  }
  table.sig td { width: 50%; padding: 0 6pt; vertical-align: bottom; }
  table.sig td:last-child { text-align: center; }
  .sig-name { font-weight: bold; font-size: 11pt; border-top: 1pt solid #000; padding-top: 2pt; display: block; }
  .sig-role { font-size: 9pt; color: #444; display: block; margin-top: 1pt; }
  .sig-blank { border-top: 1pt solid #000; display: block; padding-top: 2pt; height: 16pt; }

  .page-break { page-break-before: always; }
</style>
</head>
<body>
<div class="Section1">

{{-- ═══ LETTERHEAD ═══ --}}
<div class="hdr">
  <div class="republic">Republic of the Philippines</div>
  <div class="univ">President Ramon Magsaysay State University</div>
  <div class="address">Sta. Cruz Campus, Sta. Cruz, Zambales</div>
  <div class="title-box">OJT Narrative Report</div>
</div>

{{-- ═══ STUDENT INFO ═══ --}}
<table class="info">
  <tr>
    <td>
      <span class="lbl">Student Name</span>
      <span class="val">{{ strtoupper($student->name) }}</span>
    </td>
    <td>
      <span class="lbl">Company / Organization</span>
      <span class="val">{{ strtoupper($company) }}</span>
    </td>
  </tr>
  <tr>
    <td>
      <span class="lbl">Course &amp; School Year</span>
      <span class="val-n">BSCS — {{ $student->school_year ?? '—' }}</span>
    </td>
    <td>
      <span class="lbl">Date Generated</span>
      <span class="val-n">{{ now()->format('F d, Y') }}</span>
    </td>
  </tr>
</table>

{{-- ═══ SUMMARY ═══ --}}
<table class="sumrow">
  <tr>
    <td>
      <span class="s-lbl">Total Days</span>
      <span class="s-val">{{ $narratives->count() }}</span>
    </td>
    <td>
      <span class="s-lbl">Hours Completed</span>
      <span class="s-val">{{ number_format($completed, 2) }}</span>
    </td>
    <td>
      <span class="s-lbl">Hours Required</span>
      <span class="s-val">{{ number_format($required, 2) }}</span>
    </td>
  </tr>
</table>

{{-- ═══ ENTRIES HEADING ═══ --}}
<div class="sec-heading">Daily Narrative Entries</div>

{{-- ═══ ENTRIES ═══ --}}
@if($narratives->isEmpty())
<p style="font-size:11pt;color:#666;text-align:center;margin:16pt 0;">No narrative entries have been submitted yet.</p>
@else

@foreach($narratives as $entry)
@if(!$loop->first && $loop->index % 3 === 0)<div class="page-break"></div>@endif

<div class="day-block">

  {{-- header bar --}}
  <table class="day-hdr-table">
    <tr>
      <td class="day-num">Day {{ $entry->day_number }}</td>
      <td class="day-dt">{{ \Carbon\Carbon::parse($entry->report_date)->format('l, F d, Y') }}</td>
    </tr>
  </table>

  <div class="day-content">

    {{-- Photo — base64 embedded, resized to max 800px wide for faster load --}}
    @if($entry->photo_path)
    @php
      $absPath = storage_path('app/public/' . $entry->photo_path);
      $photoB64 = '';
      $mime = 'image/jpeg';
      
      if (file_exists($absPath)) {
        $ext = strtolower(pathinfo($absPath, PATHINFO_EXTENSION));
        
        // Resize and compress the image to reduce document size
        try {
          $img = null;
          if (extension_loaded('gd')) {
            // Use GD
            switch($ext) {
              case 'png':  $img = @imagecreatefrompng($absPath); break;
              case 'webp': $img = @imagecreatefromwebp($absPath); break;
              case 'gif':  $img = @imagecreatefromgif($absPath); break;
              default:     $img = @imagecreatefromjpeg($absPath); break;
            }
            
            if ($img) {
              $origWidth  = imagesx($img);
              $origHeight = imagesy($img);
              $maxWidth   = 800;
              
              // Resize if wider than 800px
              if ($origWidth > $maxWidth) {
                $ratio     = $maxWidth / $origWidth;
                $newWidth  = $maxWidth;
                $newHeight = (int)($origHeight * $ratio);
                $resized   = imagecreatetruecolor($newWidth, $newHeight);
                
                // Preserve transparency for PNG/GIF
                if ($ext === 'png' || $ext === 'gif') {
                  imagealphablending($resized, false);
                  imagesavealpha($resized, true);
                  $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
                  imagefill($resized, 0, 0, $transparent);
                }
                
                imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                imagedestroy($img);
                $img = $resized;
              }
              
              // Capture output
              ob_start();
              switch($ext) {
                case 'png':  imagepng($img, null, 6); $mime = 'image/png'; break;
                case 'webp': imagewebp($img, null, 80); $mime = 'image/webp'; break;
                case 'gif':  imagegif($img); $mime = 'image/gif'; break;
                default:     imagejpeg($img, null, 75); $mime = 'image/jpeg'; break;
              }
              $photoB64 = base64_encode(ob_get_clean());
              imagedestroy($img);
            }
          } else {
            // Fallback: just read the file (no resize)
            $photoB64 = base64_encode(file_get_contents($absPath));
            $mime = match($ext) {
              'png'  => 'image/png',
              'webp' => 'image/webp',
              'gif'  => 'image/gif',
              default => 'image/jpeg',
            };
          }
        } catch (\Exception $e) {
          // Silent fail — just skip the photo
        }
      }
    @endphp
    @if($photoB64)
    <div class="photo-wrap">
      <img src="data:{{ $mime }};base64,{{ $photoB64 }}" alt="Day {{ $entry->day_number }}">
      <span class="photo-cap">Figure {{ $entry->day_number }}. Photo — {{ \Carbon\Carbon::parse($entry->report_date)->format('M d, Y') }}</span>
    </div>
    @endif
    @endif

    {{-- Description --}}
    <p class="day-desc">{!! nl2br(e($entry->description)) !!}</p>

  </div>
</div>
@endforeach
@endif

{{-- ═══ SIGNATURE BLOCK ═══ --}}
<table class="sig">
  <tr>
    <td>
      <span class="sig-name">{{ strtoupper($student->name) }}</span>
      <span class="sig-role">OJT Student</span>
    </td>
    <td>
      <span class="sig-blank"></span>
      <span class="sig-role">Noted by: Supervisor / OJT Coordinator</span>
    </td>
  </tr>
</table>

</div>
</body>
</html>
