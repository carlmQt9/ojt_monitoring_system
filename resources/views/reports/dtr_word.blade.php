<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta charset="utf-8">
<meta name="ProgId" content="Word.Document">
<title>DTR - {{ strtoupper($student->name) }}</title>
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
    margin: 1.2cm 1.4cm 1.2cm 1.4cm;
    mso-header-margin: .5cm;
    mso-footer-margin: .5cm;
    mso-paper-source: 0;
  }
  div.Section1 { page: Section1; }

  * { box-sizing: border-box; }
  body {
    font-family: Arial, sans-serif;
    font-size: 10pt;
    color: #000;
    margin: 0; padding: 0;
  }

  /* Header */
  .hdr { text-align: center; margin-bottom: 8pt; border-bottom: 2pt solid #1a3a6b; padding-bottom: 6pt; }
  .hdr .republic { font-size: 12pt; font-weight: bold; color: #1a3a6b; }
  .hdr .dept     { font-size: 10pt; font-weight: bold; color: #000; margin: 2pt 0; }
  .hdr .title    { font-size: 20pt; font-weight: bold; color: #1a3a6b; letter-spacing: 3pt; margin: 4pt 0 2pt; }
  .hdr .sub      { font-size: 8pt; color: #666; }

  /* Info table */
  table.info {
    width: 100%; border-collapse: collapse;
    border: 1.5pt solid #000; margin-bottom: 8pt;
  }
  table.info td {
    width: 50%; padding: 5pt 8pt;
    border: 1pt solid #bbb; vertical-align: top;
  }
  table.info .lbl { font-size: 7pt; color: #777; text-transform: uppercase; letter-spacing: 0.5pt; }
  table.info .val { font-size: 10.5pt; font-weight: bold; margin-top: 2pt; border-bottom: 1pt solid #000; padding-bottom: 1pt; }
  table.info .val-normal { font-size: 9.5pt; font-weight: normal; margin-top: 2pt; border-bottom: 1pt solid #000; padding-bottom: 1pt; }

  /* DTR table */
  table.dtr {
    width: 100%; border-collapse: collapse;
    border: 1.5pt solid #000; margin-bottom: 8pt;
    font-size: 8.5pt;
  }
  table.dtr th {
    background: #1a3a6b; color: #fff;
    font-size: 8pt; font-weight: bold;
    text-align: center; padding: 5pt 3pt;
    border: 1pt solid #000;
  }
  table.dtr td {
    border: 1pt solid #d0d0d0;
    padding: 4pt 3pt; text-align: center;
    vertical-align: middle;
  }
  table.dtr tr.even td { background: #f7f7f7; }
  tr.mhdr td {
    background: #dce8ff; font-weight: bold;
    font-size: 9pt; color: #1a3a6b;
    text-align: left; padding: 4pt 8pt;
    border-top: 1.5pt solid #1a3a6b;
    border-bottom: 1pt solid #1a3a6b;
  }
  tr.mtotal td {
    background: #eef2ff; font-weight: bold;
    font-size: 8.5pt;
    border-top: 1pt solid #1a3a6b;
  }
  .ok  { color: #166534; font-weight: bold; }
  .pnd { color: #92400e; }

  /* Summary table */
  table.sum {
    width: 100%; border-collapse: collapse;
    border: 1.5pt solid #000; margin-bottom: 10pt;
  }
  table.sum td {
    width: 25%; text-align: center;
    padding: 7pt 4pt; border-right: 1pt solid #bbb;
    background: #f0f4ff; vertical-align: middle;
  }
  table.sum td:last-child { border-right: none; }
  .slbl { display: block; font-size: 7.5pt; color: #555; text-transform: uppercase; letter-spacing: 0.3pt; margin-bottom: 3pt; }
  .sval { display: block; font-size: 17pt; font-weight: bold; color: #1a3a6b; }

  /* Cert */
  .cert { font-size: 8.5pt; font-style: italic; color: #333; line-height: 1.6; margin-bottom: 28pt; }

  /* Sig table */
  table.sig { width: 100%; border-collapse: collapse; margin-top: 20pt; }
  table.sig td { padding: 0 6pt; vertical-align: bottom; text-align: center; }
  table.sig .sig-inner { text-align: center; }
  table.sig .sname-row {
    font-weight: bold; font-size: 11pt;
    text-transform: uppercase;
    text-align: center;
    border-bottom: 1pt solid #000;
    padding-bottom: 3pt;
    display: block;
    min-height: 24pt;
  }
  table.sig .srole {
    display: block; font-size: 7.5pt;
    color: #555; text-align: center;
    margin-top: 4pt;
  }
</style>
</head>
<body>
<div class="Section1">

  <!-- Header -->
  <div class="hdr">
    <div class="republic">Republic of the Philippines</div>
    <div class="dept">College of Computing and Information Technology</div>
    <div class="title">DAILY TIME RECORD</div>
    <div class="sub">CS Form No. 48 &mdash; OJT Monitoring System</div>
  </div>

  <!-- Info -->
  <table class="info">
    <tr>
      <td>
        <div class="lbl">Name of Intern</div>
        <div class="val">{{ strtoupper($student->name) }}</div>
      </td>
      <td>
        <div class="lbl">Company / Organization</div>
        <div class="val">{{ strtoupper($company) }}</div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="lbl">Email Address</div>
        <div class="val-normal">{{ $student->email }}</div>
      </td>
      <td>
        <div class="lbl">Date Generated</div>
        <div class="val-normal">{{ now()->format('F d, Y') }}</div>
      </td>
    </tr>
  </table>

  <!-- DTR Table -->
  <table class="dtr">
    <thead>
      <tr>
        <th style="width:5%">Day</th>
        <th style="width:7%">Wkday</th>
        <th style="width:13%">AM Arrival</th>
        <th style="width:13%">AM Departure</th>
        <th style="width:13%">PM Arrival</th>
        <th style="width:13%">PM Departure</th>
        <th style="width:13%">Hrs Worked</th>
        <th style="width:11%">Verified</th>
      </tr>
    </thead>
    <tbody>
      @foreach($byMonth as $ym => $records)
        @php
          $monthLabel = \Carbon\Carbon::parse($ym.'-01')->format('F Y');
          $monthHours = 0;
          $rowIdx = 0;
        @endphp
        <tr class="mhdr">
          <td colspan="8">{{ $monthLabel }}</td>
        </tr>
        @foreach($records as $rec)
          @php
            $hrs=0; $amIn=''; $amOut=''; $pmIn=''; $pmOut='';
            if ($rec->time_out) {
              $hrs = round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out))/60,2);
              $monthHours += $hrs;
              $tIn  = \Carbon\Carbon::parse($rec->time_in);
              $tOut = \Carbon\Carbon::parse($rec->time_out);
              if ($tIn->hour < 12) {
                $amIn = $tIn->format('h:i A');
                if ($tOut->hour < 12) { $amOut = $tOut->format('h:i A'); }
                else { $amOut='12:00 PM'; $pmIn='01:00 PM'; $pmOut=$tOut->format('h:i A'); }
              } else { $pmIn=$tIn->format('h:i A'); $pmOut=$tOut->format('h:i A'); }
            } else {
              $tIn=\Carbon\Carbon::parse($rec->time_in);
              if($tIn->hour<12){$amIn=$tIn->format('h:i A');}else{$pmIn=$tIn->format('h:i A');}
            }
            $rowClass = ($rowIdx % 2 === 1) ? 'even' : '';
            $rowIdx++;
          @endphp
          <tr class="{{ $rowClass }}">
            <td>{{ $rec->date->format('d') }}</td>
            <td>{{ $rec->date->format('D') }}</td>
            <td>{{ $amIn ?: '-' }}</td>
            <td>{{ $amOut ?: '-' }}</td>
            <td>{{ $pmIn ?: '-' }}</td>
            <td>{{ $pmOut ?: '-' }}</td>
            <td>{{ $hrs > 0 ? number_format($hrs,2) : '-' }}</td>
            <td class="{{ $rec->verified ? 'ok' : 'pnd' }}">{{ $rec->verified ? 'Verified' : 'Pending' }}</td>
          </tr>
        @endforeach
        <tr class="mtotal">
          <td colspan="6" style="text-align:right; padding-right:10pt;">Month Total:</td>
          <td>{{ number_format($monthHours,2) }} hrs</td>
          <td></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Summary -->
  <table class="sum">
    <tr>
      <td>
        <span class="slbl">Total Hours Rendered</span>
        <span class="sval">{{ number_format($totalHours,2) }}</span>
      </td>
      <td>
        <span class="slbl">Required Hours</span>
        <span class="sval">{{ $required }}</span>
      </td>
      <td>
        <span class="slbl">Remaining Hours</span>
        <span class="sval">{{ number_format($remaining,2) }}</span>
      </td>
      <td>
        <span class="slbl">Completion Rate</span>
        <span class="sval">{{ $pct }}%</span>
      </td>
    </tr>
  </table>

  <!-- Certification -->
  <p class="cert">
    I certify on my honor that the above is a true and correct report of the hours of work performed,
    record of which was made daily at the time of arrival and departure from the company/organization.
  </p>

  <!-- Signatures -->
  <table class="sig">
    <tr>
      <td style="width:45%; text-align:center; vertical-align:bottom;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="text-align:center; font-weight:bold; font-size:11pt; text-transform:uppercase; border-bottom:1pt solid #000; padding-bottom:3pt;">{{ strtoupper($student->name) }}</td>
          </tr>
          <tr>
            <td style="text-align:center; font-size:7.5pt; color:#555; padding-top:4pt;">Signature of Intern over Printed Name / Date</td>
          </tr>
        </table>
      </td>
      <td style="width:10%;"></td>
      <td style="width:45%; text-align:center; vertical-align:bottom;">
        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="text-align:center; font-size:11pt; border-bottom:1pt solid #000; padding-bottom:3pt;">&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align:center; font-size:7.5pt; color:#555; padding-top:4pt;">Verified by Supervisor over Printed Name / Date</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</div>
</body>
</html>
