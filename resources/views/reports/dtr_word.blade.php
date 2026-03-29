<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<?mso-application progid="Word.Document"?>
<w:wordDocument xmlns:w="http://schemas.microsoft.com/office/word/2003/wordml"
  xmlns:wx="http://schemas.microsoft.com/office/word/2003/auxHint"
  xmlns:o="urn:schemas-microsoft-com:office:office">
  <w:body>

    <!-- Title -->
    <w:p>
      <w:pPr><w:jc w:val="center"/><w:spacing w:after="0"/></w:pPr>
      <w:r><w:rPr><w:b/><w:sz w:val="28"/><w:color w:val="1a3a6b"/></w:rPr>
        <w:t>Republic of the Philippines</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:pPr><w:jc w:val="center"/><w:spacing w:after="0"/></w:pPr>
      <w:r><w:rPr><w:b/><w:sz w:val="22"/></w:rPr>
        <w:t>College of Computing and Information Technology</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:pPr><w:jc w:val="center"/><w:spacing w:after="60"/></w:pPr>
      <w:r><w:rPr><w:b/><w:sz w:val="36"/><w:color w:val="1a3a6b"/></w:rPr>
        <w:t>DAILY TIME RECORD</w:t>
      </w:r>
    </w:p>
    <w:p>
      <w:pPr><w:jc w:val="center"/><w:spacing w:after="120"/></w:pPr>
      <w:r><w:rPr><w:sz w:val="18"/><w:color w:val="555555"/></w:rPr>
        <w:t>CS Form No. 48 — OJT Monitoring System</w:t>
      </w:r>
    </w:p>

    <!-- Info Table -->
    <w:tbl>
      <w:tblPr>
        <w:tblW w:w="9360" w:type="dxa"/>
        <w:tblBorders>
          <w:top w:val="single" w:sz="4" w:color="000000"/>
          <w:left w:val="single" w:sz="4" w:color="000000"/>
          <w:bottom w:val="single" w:sz="4" w:color="000000"/>
          <w:right w:val="single" w:sz="4" w:color="000000"/>
          <w:insideH w:val="single" w:sz="4" w:color="cccccc"/>
          <w:insideV w:val="single" w:sz="4" w:color="cccccc"/>
        </w:tblBorders>
      </w:tblPr>
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>
          <w:p><w:r><w:rPr><w:sz w:val="16"/><w:color w:val="666666"/></w:rPr><w:t>Name of Intern</w:t></w:r></w:p>
          <w:p><w:r><w:rPr><w:b/><w:sz w:val="22"/></w:rPr><w:t>{{ strtoupper($student->name) }}</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>
          <w:p><w:r><w:rPr><w:sz w:val="16"/><w:color w:val="666666"/></w:rPr><w:t>Company / Organization</w:t></w:r></w:p>
          <w:p><w:r><w:rPr><w:b/><w:sz w:val="22"/></w:rPr><w:t>{{ strtoupper($company) }}</w:t></w:r></w:p>
        </w:tc>
      </w:tr>
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>
          <w:p><w:r><w:rPr><w:sz w:val="16"/><w:color w:val="666666"/></w:rPr><w:t>Email Address</w:t></w:r></w:p>
          <w:p><w:r><w:rPr><w:sz w:val="20"/></w:rPr><w:t>{{ $student->email }}</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>
          <w:p><w:r><w:rPr><w:sz w:val="16"/><w:color w:val="666666"/></w:rPr><w:t>Date Generated</w:t></w:r></w:p>
          <w:p><w:r><w:rPr><w:sz w:val="20"/></w:rPr><w:t>{{ now()->format('F d, Y') }}</w:t></w:r></w:p>
        </w:tc>
      </w:tr>
    </w:tbl>

    <w:p><w:pPr><w:spacing w:after="80"/></w:pPr></w:p>

    <!-- DTR Table -->
    <w:tbl>
      <w:tblPr>
        <w:tblW w:w="9360" w:type="dxa"/>
        <w:tblBorders>
          <w:top w:val="single" w:sz="6" w:color="000000"/>
          <w:left w:val="single" w:sz="6" w:color="000000"/>
          <w:bottom w:val="single" w:sz="6" w:color="000000"/>
          <w:right w:val="single" w:sz="6" w:color="000000"/>
          <w:insideH w:val="single" w:sz="4" w:color="cccccc"/>
          <w:insideV w:val="single" w:sz="4" w:color="cccccc"/>
        </w:tblBorders>
      </w:tblPr>
      <!-- Header Row -->
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="600" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>Day</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="700" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>Wkday</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>AM Arrival</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>AM Departure</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>PM Arrival</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>PM Departure</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1260" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>Hrs Worked</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1000" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="1a3a6b"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="16"/><w:color w:val="FFFFFF"/></w:rPr><w:t>Verified</w:t></w:r></w:p></w:tc>
      </w:tr>

      @foreach($byMonth as $ym => $records)
      @php $monthLabel = \Carbon\Carbon::parse($ym.'-01')->format('F Y'); $monthHours = 0; @endphp
      <!-- Month Header -->
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="9360" w:type="dxa"/><w:gridSpan w:val="8"/><w:shd w:val="clear" w:color="auto" w:fill="dce8ff"/></w:tcPr>
          <w:p><w:r><w:rPr><w:b/><w:sz w:val="20"/><w:color w:val="1a3a6b"/></w:rPr><w:t>{{ $monthLabel }}</w:t></w:r></w:p>
        </w:tc>
      </w:tr>

      @foreach($records as $rec)
      @php
        $hrs = 0; $amIn=''; $amOut=''; $pmIn=''; $pmOut='';
        if ($rec->time_out) {
          $hrs = round(\Carbon\Carbon::parse($rec->time_in)->diffInMinutes(\Carbon\Carbon::parse($rec->time_out))/60,2);
          $monthHours += $hrs;
          $tIn = \Carbon\Carbon::parse($rec->time_in);
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
      @endphp
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="600" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $rec->date->format('d') }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="700" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $rec->date->format('D') }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $amIn ?: '-' }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $amOut ?: '-' }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $pmIn ?: '-' }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $pmOut ?: '-' }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1260" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $hrs > 0 ? number_format($hrs,2) : '-' }}</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1000" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t>{{ $rec->verified ? 'Verified' : 'Pending' }}</w:t></w:r></w:p></w:tc>
      </w:tr>
      @endforeach

      <!-- Month Total -->
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="8360" w:type="dxa"/><w:gridSpan w:val="7"/><w:shd w:val="clear" w:color="auto" w:fill="eef2ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="right"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="18"/></w:rPr><w:t>Month Total:</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1260" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="eef2ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr><w:r><w:rPr><w:b/><w:sz w:val="18"/></w:rPr><w:t>{{ number_format($monthHours,2) }} hrs</w:t></w:r></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="1000" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="eef2ff"/></w:tcPr>
          <w:p></w:p></w:tc>
      </w:tr>
      @endforeach

    </w:tbl>

    <w:p><w:pPr><w:spacing w:after="80"/></w:pPr></w:p>

    <!-- Summary Table -->
    <w:tbl>
      <w:tblPr>
        <w:tblW w:w="9360" w:type="dxa"/>
        <w:tblBorders>
          <w:top w:val="single" w:sz="6" w:color="000000"/>
          <w:left w:val="single" w:sz="6" w:color="000000"/>
          <w:bottom w:val="single" w:sz="6" w:color="000000"/>
          <w:right w:val="single" w:sz="6" w:color="000000"/>
          <w:insideV w:val="single" w:sz="4" w:color="cccccc"/>
        </w:tblBorders>
      </w:tblPr>
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="2340" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="f0f4ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Total Hours Rendered</w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="32"/><w:color w:val="1a3a6b"/></w:rPr><w:t>{{ number_format($totalHours,2) }}</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="2340" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="f0f4ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Required Hours</w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="32"/><w:color w:val="1a3a6b"/></w:rPr><w:t>{{ $required }}</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="2340" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="f0f4ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Remaining Hours</w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="32"/><w:color w:val="1a3a6b"/></w:rPr><w:t>{{ number_format($remaining,2) }}</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="2340" w:type="dxa"/><w:shd w:val="clear" w:color="auto" w:fill="f0f4ff"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Completion Rate</w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="32"/><w:color w:val="1a3a6b"/></w:rPr><w:t>{{ $pct }}%</w:t></w:r></w:p>
        </w:tc>
      </w:tr>
    </w:tbl>

    <w:p><w:pPr><w:spacing w:after="120"/></w:pPr></w:p>

    <!-- Certification -->
    <w:p>
      <w:r><w:rPr><w:i/><w:sz w:val="18"/><w:color w:val="333333"/></w:rPr>
        <w:t>I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from the company/organization.</w:t>
      </w:r>
    </w:p>
    <w:p><w:pPr><w:spacing w:after="600"/></w:pPr></w:p>

    <!-- Signature Table -->
    <w:tbl>
      <w:tblPr>
        <w:tblW w:w="9360" w:type="dxa"/>
        <w:tblBorders><w:insideV w:val="none"/></w:tblBorders>
      </w:tblPr>
      <w:tr>
        <w:tc><w:tcPr><w:tcW w:w="4200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/><w:pBdr><w:bottom w:val="single" w:sz="6" w:color="000000"/></w:pBdr></w:pPr>
            <w:r><w:rPr><w:b/><w:sz w:val="20"/></w:rPr><w:t>{{ strtoupper($student->name) }}</w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Signature of Intern / Date</w:t></w:r></w:p>
        </w:tc>
        <w:tc><w:tcPr><w:tcW w:w="960" w:type="dxa"/></w:tcPr><w:p></w:p></w:tc>
        <w:tc><w:tcPr><w:tcW w:w="4200" w:type="dxa"/></w:tcPr>
          <w:p><w:pPr><w:jc w:val="center"/><w:pBdr><w:bottom w:val="single" w:sz="6" w:color="000000"/></w:pBdr></w:pPr>
            <w:r><w:rPr><w:sz w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r></w:p>
          <w:p><w:pPr><w:jc w:val="center"/></w:pPr>
            <w:r><w:rPr><w:sz w:val="16"/><w:color w:val="555555"/></w:rPr><w:t>Verified by Supervisor / Date</w:t></w:r></w:p>
        </w:tc>
      </w:tr>
    </w:tbl>

  </w:body>
</w:wordDocument>
