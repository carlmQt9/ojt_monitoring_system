<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DTR - {{ strtoupper($student->name) }}</title>
<style>
@page { size: A4 portrait; margin: 8mm; }
@media print {
  .no-print { display: none !important; }
  html, body { margin: 0; padding: 0; background: #fff; width: 100%; }
  .dtr-scale-wrapper { width: 100% !important; overflow: visible !important; }
  .dtr-wrapper { width: 100% !important; border: 2px solid #000; font-size: 9px; }
  table.dtr-table thead tr th { font-size: 8px; padding: 4px 2px; }
  table.dtr-table tbody td { font-size: 8px; padding: 3px 4px; }
  .sum-value { font-size: 13px; }
  .summary-box { grid-template-columns: repeat(4,1fr); }
  .info-value { font-size: 10px; }
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: Arial, sans-serif; font-size: 11px; color: #000; background: #e8e8e8; padding: 20px; }
.dtr-scale-wrapper { width: 100%; overflow-x: auto; }
.dtr-wrapper { width: 780px; margin: 0 auto; background: #fff; border: 2px solid #000; }
@media (max-width: 820px) {
  body { padding: 8px; }
  .dtr-scale-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
}
.dtr-header { text-align: center; padding: 14px 20px 10px; border-bottom: 2px solid #000; }
.dtr-header .republic { font-size: 10px; letter-spacing: 1px; text-transform: uppercase; color: #333; }
.dtr-header .dept { font-size: 11px; font-weight: bold; text-transform: uppercase; margin: 3px 0; }
.dtr-header h1 { font-size: 17px; font-weight: bold; letter-spacing: 3px; margin: 6px 0 2px; text-transform: uppercase; color: #1a3a6b; }
.dtr-header .subtitle { font-size: 10px; color: #555; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; border-bottom: 2px solid #000; }
.info-cell { padding: 7px 14px; border-right: 1px solid #ccc; }
.info-cell:nth-child(even) { border-right: none; }
.info-label { font-size: 9px; color: #666; text-transform: uppercase; letter-spacing: .5px; }
.info-value { font-size: 12px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 2px; margin-top: 3px; min-height: 20px; }
table.dtr-table { width: 100%; border-collapse: collapse; }
table.dtr-table thead tr th { background: #1a3a6b; color: #fff; padding: 6px 4px; font-size: 9px; text-align: center; border: 1px solid #000; }
table.dtr-table tbody td { border: 1px solid #ccc; padding: 4px 6px; font-size: 10px; }
table.dtr-table tbody tr:nth-child(even) { background: #f9f9f9; }
.month-header td { background: #dce8ff !important; font-weight: bold; font-size: 10px; padding: 5px 8px; border-top: 2px solid #1a3a6b; border-bottom: 1px solid #1a3a6b; color: #1a3a6b; }
.month-total td { background: #eef2ff !important; font-weight: bold; font-size: 10px; border-top: 1px solid #1a3a6b; }
.summary-box { display: grid; grid-template-columns: repeat(4,1fr); border-top: 2px solid #000; }
.sum-cell { padding: 10px 12px; border-right: 1px solid #ccc; text-align: center; }
.sum-cell:last-child { border-right: none; }
.sum-label { font-size: 9px; color: #555; text-transform: uppercase; letter-spacing: .4px; }
.sum-value { font-size: 18px; font-weight: bold; color: #1a3a6b; margin: 3px 0; }
.progress-wrap { height: 8px; background: #ddd; border-radius: 4px; margin-top: 4px; }
.progress-fill { height: 8px; background: #1a3a6b; border-radius: 4px; }
.cert-section { border-top: 2px solid #000; padding: 14px 20px 20px; }
.cert-text { font-size: 10px; color: #333; margin-bottom: 24px; font-style: italic; line-height: 1.5; }
.sig-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.sig-name { font-weight: bold; font-size: 11px; border-bottom: 1px solid #000; padding-bottom: 2px; text-transform: uppercase; text-align: center; min-height: 28px; }
.sig-role { font-size: 9px; color: #555; margin-top: 3px; text-align: center; }
.no-print { text-align: center; margin: 20px 0 10px; }
.btn { display: inline-block; padding: 10px 28px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; margin: 0 6px; text-decoration: none; }
.btn-pdf { background: #c0392b; color: #fff; }
.btn-word { background: #2b579a; color: #fff; }
</style>
</head>
<body>

<div class="no-print">
  <button class="btn btn-pdf" onclick="window.print()">🖨️ Download / Print as PDF</button>
  <a class="btn btn-word" href="{{ route('generate-dtr-word', $student->id) }}">📄 Download as Word (.doc)</a>
  <p style="font-size:11px;color:#666;margin-top:8px">For PDF: click Print → change destination to "Save as PDF" → Save</p>
</div>

<div class="dtr-scale-wrapper">
<div class="dtr-wrapper">

  <div class="dtr-header">
    <div class="republic">Republic of the Philippines</div>
    <div class="dept">College of Computing and Information Technology</div>
    <h1>Daily Time Record</h1>
    <div class="subtitle">CS Form No. 48 &mdash; OJT Monitoring System</div>
  </div>

  <div class="info-grid">
    <div class="info-cell">
      <div class="info-label">Name of Intern</div>
      <div class="info-value">{{ strtoupper($student->name) }}</div>
    </div>
    <div class="info-cell">
      <div class="info-label">Company / Organization</div>
      <div class="info-value">{{ strtoupper($company) }}</div>
    </div>
    <div class="info-cell">
      <div class="info-label">Email Address</div>
      <div class="info-value">{{ $student->email }}</div>
    </div>
    <div class="info-cell">
      <div class="info-label">Date Generated</div>
      <div class="info-value">{{ now()->format('F d, Y') }}</div>
    </div>
  </div>

  <table class="dtr-table">
    <thead>
      <tr>
        <th rowspan="2" style="width:32px">Day</th>
        <th rowspan="2" style="width:40px">Wkday</th>
        <th colspan="2">A.M.</th>
        <th colspan="2">P.M.</th>
        <th rowspan="2" style="width:72px">Hours<br>Worked</th>
        <th rowspan="2" style="width:64px">Verified</th>
      </tr>
      <tr>
        <th style="width:72px">Arrival</th>
        <th style="width:72px">Departure</th>
        <th style="width:72px">Arrival</th>
        <th style="width:72px">Departure</th>
      </tr>
    </thead>
    <tbody>
      @foreach($byMonth as $ym => $records)
        @php
          $monthLabel = \Carbon\Carbon::parse($ym.'-01')->format('F Y');
          $monthHours = 0;
        @endphp
        <tr class="month-header">
          <td colspan="8">&#128197; {{ $monthLabel }}</td>
        </tr>
        @foreach($records as $rec)
          @php
            $hrs = 0;
            $amIn = ''; $amOut = ''; $pmIn = ''; $pmOut = '';
            if ($rec->time_out) {
              $hrs = round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out)) / 60, 2);
              $monthHours += $hrs;
              $tIn  = \Carbon\Carbon::parse($rec->time_in);
              $tOut = \Carbon\Carbon::parse($rec->time_out);
              if ($tIn->hour < 12) {
                $amIn = $tIn->format('h:i A');
                if ($tOut->hour < 12) {
                  $amOut = $tOut->format('h:i A');
                } else {
                  $amOut = '12:00 PM';
                  $pmIn  = '01:00 PM';
                  $pmOut = $tOut->format('h:i A');
                }
              } else {
                $pmIn  = $tIn->format('h:i A');
                $pmOut = $tOut->format('h:i A');
              }
            } else {
              $tIn = \Carbon\Carbon::parse($rec->time_in);
              if ($tIn->hour < 12) { $amIn = $tIn->format('h:i A'); }
              else { $pmIn = $tIn->format('h:i A'); }
            }
          @endphp
          <tr>
            <td style="text-align:center">{{ $rec->date->format('d') }}</td>
            <td style="text-align:center">{{ $rec->date->format('D') }}</td>
            <td style="text-align:center">{!! $amIn ?: '&mdash;' !!}</td>
            <td style="text-align:center">{!! $amOut ?: '&mdash;' !!}</td>
            <td style="text-align:center">{!! $pmIn ?: '&mdash;' !!}</td>
            <td style="text-align:center">{!! $pmOut ?: '&mdash;' !!}</td>
            <td style="text-align:center">{!! $hrs > 0 ? number_format($hrs,2) : '&mdash;' !!}</td>
            <td style="text-align:center">
              @if($rec->verified)
                <span style="color:green;font-weight:bold">&#10003; Verified</span>
              @else
                <span style="color:#aaa">Pending</span>
              @endif
            </td>
          </tr>
        @endforeach
        <tr class="month-total">
          <td colspan="6" style="text-align:right;padding-right:12px">Month Total:</td>
          <td style="text-align:center">{{ number_format($monthHours,2) }} hrs</td>
          <td></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="summary-box">
    <div class="sum-cell">
      <div class="sum-label">Total Hours Rendered</div>
      <div class="sum-value">{{ number_format($totalHours,2) }}</div>
    </div>
    <div class="sum-cell">
      <div class="sum-label">Required Hours</div>
      <div class="sum-value">{{ $required }}</div>
    </div>
    <div class="sum-cell">
      <div class="sum-label">Remaining Hours</div>
      <div class="sum-value">{{ number_format($remaining,2) }}</div>
    </div>
    <div class="sum-cell">
      <div class="sum-label">Completion</div>
      <div class="sum-value">{{ $pct }}%</div>
      <div class="progress-wrap">
        <div class="progress-fill" style="width:{{ min($pct,100) }}%"></div>
      </div>
    </div>
  </div>

  <div class="cert-section">
    <p class="cert-text">
      I certify on my honor that the above is a true and correct report of the hours of work performed,
      record of which was made daily at the time of arrival and departure from the company/organization.
    </p>
    <div class="sig-grid">
      <div>
        <div class="sig-name">{{ strtoupper($student->name) }}</div>
        <div class="sig-role">Signature of Intern over Printed Name / Date</div>
      </div>
      <div>
        <div class="sig-name">&nbsp;</div>
        <div class="sig-role">Verified by Supervisor over Printed Name / Date</div>
      </div>
    </div>
  </div>

</div><!-- end dtr-wrapper -->
</div><!-- end dtr-scale-wrapper -->

<div class="no-print"
  <button class="btn btn-pdf" onclick="window.print()">🖨️ Print / Save as PDF</button>
  <a class="btn btn-word" href="{{ route('generate-dtr-word', $student->id) }}">📄 Download as Word (.doc)</a>
</div>

</body>
</html>
