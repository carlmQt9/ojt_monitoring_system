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
    line-height: 1.4;
  }

  /* ── Letterhead ── */
  .hdr { text-align: center; margin-bottom: 10pt; }
  .hdr .republic  { font-size: 10pt; text-transform: uppercase; }
  .hdr .univ      { font-size: 12pt; font-weight: bold; text-transform: uppercase; }
  .hdr .address   { font-size: 9pt; color: #333; margin: 1pt 0 6pt; }
  .hdr .title-box {
    font-size: 12pt; font-weight: bold; text-transform: uppercase;
    border-top: 1pt solid #000; border-bottom: 1pt solid #000;
    padding: 3pt 0; margin: 4pt 0 8pt;
  }

  /* ── Info table ── */
  table.info {
    width: 100%; table-layout: fixed; border-collapse: collapse;
    margin: 2pt 0 10pt; font-size: 10.5pt;
  }
  table.info td {
    width: 50%; padding: 5pt 10pt 7pt 10pt;
    vertical-align: top; border-bottom: 0.5pt solid #d5d5d5;
  }
  table.info td:first-child { padding-left: 0; text-align: left; }
  table.info td:last-child {
    border-left: 0.5pt solid #d5d5d5;
    padding-right: 0;
    text-align: right;
  }
  .lbl {
    font-size: 7.5pt; color: #666; text-transform: uppercase;
    display: block; margin-bottom: 2pt; letter-spacing: 0.3pt;
  }
  .val, .val-n {
    font-size: 10.5pt; border-bottom: none; display: block;
    padding-bottom: 0; line-height: 1.15;
  }
  .val { font-weight: bold; }

  /* ── Summary ── */
  table.sumrow {
    width: 100%; border-collapse: collapse;
    border: 0.5pt solid #aaa;
    margin: 6pt 0 10pt; font-size: 10pt;
  }
  table.sumrow td {
    width: 33.33%; text-align: center; padding: 4pt 6pt;
    border-right: 0.5pt solid #ccc;
    vertical-align: middle;
  }
  table.sumrow td:last-child { border-right: none; }
  .s-lbl { font-size: 7.5pt; color: #555; text-transform: uppercase; display: block; margin-bottom: 2pt; }
  .s-val { font-size: 11pt; font-weight: bold; display: block; }

  /* ── Section heading ── */
  .sec-heading {
    font-size: 10.5pt; font-weight: bold; text-transform: uppercase;
    border-bottom: 1pt solid #000;
    padding-bottom: 2pt; margin: 8pt 0 7pt;
  }

  /* ── Day block ── */
  .day-block { margin-bottom: 12pt; page-break-inside: avoid; }

  .day-hdr-table {
    width: 100%; border-collapse: collapse;
    background: #1a3a6b; margin-bottom: 0;
  }
  .day-hdr-table td {
    padding: 4pt 8pt; color: #fff; font-size: 10pt; vertical-align: middle;
  }
  .day-hdr-table .day-num { width: 50%; font-weight: bold; }
  .day-hdr-table .day-dt  { width: 50%; font-size: 9.5pt; text-align: right; }

  .day-content {
    border: 0.5pt solid #ccc; border-top: none; padding: 8pt 10pt;
  }

  /* ── Photo (centered via table) ── */
  table.photo-tbl {
    width: 100%; border-collapse: collapse;
    margin-bottom: 6pt; border-bottom: 0.5pt solid #ddd; padding-bottom: 5pt;
  }
  table.photo-tbl td { text-align: center; padding-bottom: 4pt; }
  .photo-cap {
    font-size: 8.5pt; color: #555; font-style: italic;
    text-align: center; display: block; margin-top: 3pt;
  }

  /* ── Description ── */
  .day-desc {
    font-size: 11pt;
    line-height: 1.45;
    color: #000;
    margin: 0;
    padding: 6pt 0 2pt;
    text-align: left !important;
    text-justify: none;
    word-spacing: normal;
    letter-spacing: normal;
    mso-line-height-rule: exactly;
    mso-style-name: Normal;
  }

  /* ── Signature ── */
  table.sig {
    width: 100%; border-collapse: collapse; margin-top: 10pt; font-size: 10.5pt;
  }
  table.sig td {
    width: 50%; padding: 2pt 8pt 0; vertical-align: top;
    border-top: 1pt solid #000; line-height: 1;
    mso-line-height-rule: exactly;
  }
  table.sig td:last-child { text-align: center; }
  .sig-name  { font-weight: bold; display: block; line-height: 1; }
  .sig-role  { font-size: 8.5pt; color: #555; display: block; line-height: 1; margin: 1pt 0 0; }

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
      <span class="lbl">Student Name:&nbsp;</span>
      <span class="val">{{ strtoupper($student->name) }}</span>
    </td>
    <td>
      <span class="lbl">Company / Organization:&nbsp;</span>
      <span class="val">{{ strtoupper($company) }}</span>
    </td>
  </tr>
  <tr>
    <td>
      <span class="lbl">Course &amp; School Year:&nbsp;</span>
      <span class="val-n">BSCS — {{ $student->school_year ?? '—' }}</span>
    </td>
    <td>
      <span class="lbl">Date Generated:&nbsp;</span>
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
          <span class="photo-cap">Photo - {{ \Carbon\Carbon::parse($entry->report_date)->format('M d, Y') }}</span>
        </td>
      </tr>
    </table>
    @endif
    @endif

    {{-- Narrative description --}}
    <div class="day-desc" align="left">{!! nl2br(e($entry->description)) !!}</div>

  </div>
</div>
@endforeach
@endif

{{-- ═══ SIGNATURE BLOCK ═══ --}}
<table class="sig">
  <tr>
    <td>
      <span class="sig-name">{{ strtoupper($student->name) }}</span><br>
      <span class="sig-role">OJT Student</span>
    </td>
    <td>
      <span class="sig-role">Noted by: Supervisor / OJT Coordinator</span>
    </td>
  </tr>
</table>

</div>
</body>
</html>
