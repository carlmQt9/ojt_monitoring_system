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
    line-height: 1.6;
  }

  /* ── Letterhead ── */
  .hdr { text-align: center; margin-bottom: 8pt; }
  .hdr .republic  { font-size: 10.5pt; text-transform: uppercase; letter-spacing: 0.4pt; }
  .hdr .univ      { font-size: 13pt; font-weight: bold; text-transform: uppercase; }
  .hdr .address   { font-size: 10pt; color: #333; margin: 2pt 0 6pt; }
  .hdr .title-box {
    font-size: 13pt; font-weight: bold; text-transform: uppercase;
    letter-spacing: 1.5pt;
    border-top: 1.5pt solid #000; border-bottom: 1.5pt solid #000;
    padding: 4pt 0; margin: 4pt 0 10pt;
  }

  /* ── Info table ── */
  table.info {
    width: 100%; border-collapse: collapse; margin-bottom: 10pt; font-size: 11pt;
  }
  table.info td {
    width: 50%; padding: 4pt 6pt 7pt 6pt;
    vertical-align: top; border-bottom: 1pt solid #ccc;
  }
  table.info td:last-child { border-left: 1pt solid #ccc; }
  .lbl {
    font-size: 8pt; color: #666; text-transform: uppercase;
    letter-spacing: 0.4pt; display: block; margin-bottom: 2pt;
  }
  .val   { font-size: 11pt; font-weight: bold; border-bottom: 1pt solid #000; display: block; padding-bottom: 1pt; }
  .val-n { font-size: 11pt; border-bottom: 1pt solid #000; display: block; padding-bottom: 1pt; }

  /* ── Summary ── */
  table.sumrow {
    width: 100%; border-collapse: collapse;
    border: 1pt solid #aaa; margin: 6pt 0 12pt; font-size: 10.5pt;
  }
  table.sumrow td {
    width: 33.33%; text-align: center; padding: 5pt 8pt;
    border-right: 1pt solid #ccc; vertical-align: middle;
  }
  table.sumrow td:last-child { border-right: none; }
  .s-lbl { font-size: 8pt; color: #555; text-transform: uppercase; display: block; margin-bottom: 1pt; }
  .s-val { font-size: 12pt; font-weight: bold; display: block; }

  /* ── Section heading ── */
  .sec-heading {
    font-size: 11pt; font-weight: bold; text-transform: uppercase;
    letter-spacing: 0.5pt; border-bottom: 1.5pt solid #000;
    padding-bottom: 3pt; margin: 10pt 0 8pt;
  }

  /* ── Day block ── */
  .day-block { margin-bottom: 14pt; page-break-inside: avoid; }

  .day-hdr-table {
    width: 100%; border-collapse: collapse;
    background: #1a3a6b; margin-bottom: 0;
  }
  .day-hdr-table td {
    padding: 4pt 8pt; color: #fff; font-size: 10.5pt; vertical-align: middle;
  }
  .day-hdr-table .day-num { font-weight: bold; width: 70pt; }
  .day-hdr-table .day-dt  { font-size: 9.5pt; text-align: right; }

  .day-content {
    border: 1pt solid #bbb; border-top: none; padding: 8pt 10pt;
  }

  /* ── Photo (centered via table) ── */
  table.photo-tbl {
    width: 100%; border-collapse: collapse;
    margin-bottom: 8pt; border-bottom: 1pt solid #ddd; padding-bottom: 6pt;
  }
  table.photo-tbl td { text-align: center; padding-bottom: 4pt; }
  .photo-cap {
    font-size: 8.5pt; color: #555; font-style: italic;
    text-align: center; display: block; margin-top: 3pt;
  }

  /* ── Description ── */
  .day-desc {
    font-size: 11.5pt;
    line-height: 1.7;
    color: #000;
    margin: 0;
    padding: 4pt 0 0;
    text-align: justify;
    text-justify: inter-word;
  }

  /* ── Signature ── */
  table.sig {
    width: 100%; border-collapse: collapse; margin-top: 32pt; font-size: 11pt;
  }
  table.sig td { width: 50%; padding: 0 8pt; vertical-align: bottom; }
  table.sig td:last-child { text-align: center; }
  .sig-name  { font-weight: bold; border-top: 1pt solid #000; padding-top: 2pt; display: block; }
  .sig-role  { font-size: 9pt; color: #555; display: block; margin-top: 2pt; }
  .sig-blank { border-top: 1pt solid #000; display: block; height: 18pt; }

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

  {{-- Day header bar --}}
  <table class="day-hdr-table">
    <tr>
      <td class="day-num">Day {{ $entry->day_number }}</td>
      <td class="day-dt">{{ \Carbon\Carbon::parse($entry->report_date)->format('l, F d, Y') }}</td>
    </tr>
  </table>

  <div class="day-content">

    {{-- Photo centered using a table row (Word-safe) --}}
    @if($entry->photo_path)
    @php
      $cid     = 'photo_day_' . $entry->day_number . '@narrative';
      $absPath = public_path('storage/' . $entry->photo_path);
    @endphp
    @if(file_exists($absPath))
    <table class="photo-tbl">
      <tr>
        <td>
          <img src="__CID__{{ $cid }}" width="211" height="158"
               style="border:1pt solid #bbb;display:block;margin:0 auto;"
               alt="Day {{ $entry->day_number }} photo"><br>
          <span class="photo-cap">Figure {{ $entry->day_number }}. Photo — {{ \Carbon\Carbon::parse($entry->report_date)->format('M d, Y') }}</span>
        </td>
      </tr>
    </table>
    @endif
    @endif

    {{-- Narrative description --}}
    <p class="day-desc" style="text-align:justify;mso-line-height-rule:exactly;">{!! nl2br(e($entry->description)) !!}</p>

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
