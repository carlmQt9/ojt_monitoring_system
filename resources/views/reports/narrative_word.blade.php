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
    size: 595.3pt 841.9pt;
    margin: 2cm 2.5cm 2cm 2.5cm;
    mso-header-margin: .5cm;
    mso-footer-margin: .5cm;
    mso-paper-source: 0;
  }
  div.Section1 { page: Section1; }

  * { box-sizing: border-box; }
  body {
    font-family: Arial, sans-serif;
    font-size: 11pt;
    color: #000;
    margin: 0; padding: 0;
  }

  /* ── Header ── */
  .hdr { text-align: center; margin-bottom: 10pt; border-bottom: 2pt solid #1a3a6b; padding-bottom: 8pt; }
  .hdr .republic { font-size: 12pt; font-weight: bold; color: #1a3a6b; text-transform: uppercase; }
  .hdr .dept     { font-size: 10pt; font-weight: bold; color: #000; margin: 3pt 0; }
  .hdr .school   { font-size: 9.5pt; color: #444; margin-bottom: 4pt; }
  .hdr .doc-title{
    font-size: 18pt; font-weight: bold;
    color: #1a3a6b; letter-spacing: 2pt;
    text-transform: uppercase;
    margin: 6pt 0 2pt;
    border: 2pt solid #1a3a6b;
    padding: 4pt 10pt; display: inline-block;
  }

  /* ── Student info table ── */
  table.info {
    width: 100%; border-collapse: collapse;
    border: 1.5pt solid #1a3a6b; margin-bottom: 12pt;
    font-size: 10pt;
  }
  table.info td {
    width: 50%; padding: 5pt 10pt;
    border: 1pt solid #c0c8dc; vertical-align: top;
  }
  table.info .lbl { font-size: 7.5pt; color: #777; text-transform: uppercase; letter-spacing: 0.5pt; }
  table.info .val { font-size: 11pt; font-weight: bold; margin-top: 2pt;
    border-bottom: 1pt solid #000; padding-bottom: 1pt; }
  table.info .val-normal { font-size: 10pt; font-weight: normal; margin-top: 2pt;
    border-bottom: 1pt solid #000; padding-bottom: 1pt; }

  /* ── Summary bar ── */
  table.sum {
    width: 100%; border-collapse: collapse;
    border: 1.5pt solid #1a3a6b; margin-bottom: 14pt;
    font-size: 10pt;
  }
  table.sum td {
    width: 33.33%; text-align: center; padding: 8pt 4pt;
    border-right: 1pt solid #c0c8dc; background: #eef2ff; vertical-align: middle;
  }
  table.sum td:last-child { border-right: none; }
  .slbl { display: block; font-size: 8pt; color: #555; text-transform: uppercase; letter-spacing: 0.4pt; margin-bottom: 3pt; }
  .sval { display: block; font-size: 18pt; font-weight: bold; color: #1a3a6b; }

  /* ── Day entry ── */
  .day-entry {
    margin-bottom: 14pt;
    page-break-inside: avoid;
    border: 1pt solid #c0c8dc;
    border-left: 4pt solid #1a3a6b;
    border-radius: 2pt;
  }
  .day-header {
    background: #1a3a6b; color: #fff;
    padding: 5pt 10pt; font-size: 10pt; font-weight: bold;
  }
  .day-body {
    padding: 8pt 10pt;
    font-size: 10.5pt;
    line-height: 1.65;
    color: #111;
  }
  .day-date {
    font-size: 8.5pt; color: #aaa;
    float: right; font-weight: normal;
    margin-top: 2pt;
  }
  .day-photo-row {
    padding: 0 10pt 8pt;
    text-align: center;
  }
  .day-photo-row img {
    max-width: 380pt; max-height: 260pt;
    border: 1pt solid #ccc; border-radius: 3pt;
    display: block; margin: 0 auto 4pt;
  }
  .day-photo-caption {
    font-size: 8pt; color: #777; font-style: italic;
  }

  /* ── Footer ── */
  .sig-table {
    width: 100%; border-collapse: collapse;
    margin-top: 24pt; font-size: 10pt;
  }
  .sig-table td {
    width: 50%; padding: 4pt 10pt; vertical-align: bottom;
  }
  .sig-line {
    border-top: 1pt solid #000; padding-top: 3pt;
    font-weight: bold; font-size: 10pt;
  }
  .sig-lbl { font-size: 8pt; color: #666; }

  .page-break { page-break-before: always; }

  /* ── "No entries" placeholder ── */
  .empty-notice {
    text-align: center; padding: 30pt;
    font-size: 12pt; color: #888; border: 1pt dashed #ccc;
    margin: 20pt 0;
  }
</style>
</head>
<body>
<div class="Section1">

{{-- ══════════════════════════════════════════════
     HEADER
══════════════════════════════════════════════ --}}
<div class="hdr">
  <div class="republic">Republic of the Philippines</div>
  <div class="dept">PALAWAN STATE UNIVERSITY</div>
  <div class="school">Puerto Princesa City, Palawan</div>
  <div class="doc-title">OJT Narrative Report</div>
</div>

{{-- ══════════════════════════════════════════════
     STUDENT INFO
══════════════════════════════════════════════ --}}
<table class="info">
  <tr>
    <td>
      <div class="lbl">Student Name</div>
      <div class="val">{{ strtoupper($student->name) }}</div>
    </td>
    <td>
      <div class="lbl">Company / Organization</div>
      <div class="val">{{ strtoupper($company) }}</div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="lbl">School Year</div>
      <div class="val-normal">{{ $student->school_year ?? '—' }}</div>
    </td>
    <td>
      <div class="lbl">Date Generated</div>
      <div class="val-normal">{{ now()->format('F d, Y') }}</div>
    </td>
  </tr>
</table>

{{-- ══════════════════════════════════════════════
     SUMMARY BAR
══════════════════════════════════════════════ --}}
<table class="sum">
  <tr>
    <td>
      <span class="slbl">Total Days Reported</span>
      <span class="sval">{{ $narratives->count() }}</span>
    </td>
    <td>
      <span class="slbl">Hours Completed</span>
      <span class="sval">{{ number_format($completed, 2) }}</span>
    </td>
    <td>
      <span class="slbl">Hours Required</span>
      <span class="sval">{{ number_format($required, 2) }}</span>
    </td>
  </tr>
</table>

{{-- ══════════════════════════════════════════════
     DAILY NARRATIVE ENTRIES
══════════════════════════════════════════════ --}}
@if($narratives->isEmpty())
<div class="empty-notice">No narrative entries submitted yet.</div>
@else

@foreach($narratives as $entry)
{{-- Page-break every 2 entries to keep photos from running over --}}
@if(!$loop->first && $loop->index % 2 === 0)
<div class="page-break"></div>
@endif

<div class="day-entry">

  {{-- Day header row --}}
  <div class="day-header">
    Day {{ $entry->day_number }}
    <span class="day-date">{{ \Carbon\Carbon::parse($entry->report_date)->format('l, F d, Y') }}</span>
  </div>

  {{-- Photo (if any) --}}
  @if($entry->photo_path)
  <div class="day-photo-row">
    <img src="{{ storage_path('app/public/' . $entry->photo_path) }}" alt="Day {{ $entry->day_number }} photo">
    <div class="day-photo-caption">Photo — Day {{ $entry->day_number }}</div>
  </div>
  @endif

  {{-- Description --}}
  <div class="day-body">
    {!! nl2br(e($entry->description)) !!}
  </div>

</div>
@endforeach

@endif

{{-- ══════════════════════════════════════════════
     SIGNATURE BLOCK
══════════════════════════════════════════════ --}}
<table class="sig-table" style="margin-top:30pt;">
  <tr>
    <td>
      <div style="margin-bottom:24pt;"></div>
      <div class="sig-line">{{ strtoupper($student->name) }}</div>
      <div class="sig-lbl">OJT Student</div>
    </td>
    <td style="text-align:right;">
      <div style="margin-bottom:24pt;"></div>
      <div class="sig-line">________________________________</div>
      <div class="sig-lbl">Supervisor / OJT Coordinator</div>
    </td>
  </tr>
</table>

</div>{{-- end Section1 --}}
</body>
</html>
