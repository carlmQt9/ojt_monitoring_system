<?xml version="1.0" encoding="UTF-8"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:x="urn:schemas-microsoft-com:office:excel">
  <Styles>
    <Style ss:ID="header">
      <Font ss:Bold="1" ss:Color="#FFFFFF"/>
      <Interior ss:Color="#1a3a6b" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="even">
      <Interior ss:Color="#f5f8ff" ss:Pattern="Solid"/>
    </Style>
    <Style ss:ID="center">
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="center_even">
      <Alignment ss:Horizontal="Center"/>
      <Interior ss:Color="#f5f8ff" ss:Pattern="Solid"/>
    </Style>
    <Style ss:ID="green">
      <Font ss:Bold="1" ss:Color="#276221"/>
      <Interior ss:Color="#d4edda" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="yellow">
      <Font ss:Color="#856404"/>
      <Interior ss:Color="#fff3cd" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="num">
      <NumberFormat ss:Format="0.0000"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
  </Styles>
  <Worksheet ss:Name="Attendance">
    <Table ss:DefaultColumnWidth="110">
      <Column ss:Width="90"/>
      <Column ss:Width="160"/>
      <Column ss:Width="180"/>
      <Column ss:Width="90"/>
      <Column ss:Width="90"/>
      <Column ss:Width="90"/>
      <Column ss:Width="90"/>
      <Column ss:Width="90"/>
      <Row ss:Height="24">
        <Cell ss:StyleID="header"><Data ss:Type="String">Date</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Student Name</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Company</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Time In</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Time Out</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Hours Worked</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Status</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Verified</Data></Cell>
      </Row>
      @foreach($records as $i => $r)
      @php $e = ($i % 2 === 0) ? '' : 'even'; $ce = ($i % 2 === 0) ? 'center' : 'center_even'; @endphp
      <Row>
        <Cell ss:StyleID="{{ $ce }}"><Data ss:Type="String">{{ $r['date'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $e }}"><Data ss:Type="String">{{ $r['name'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $e }}"><Data ss:Type="String">{{ $r['company'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $ce }}"><Data ss:Type="String">{{ $r['time_in'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $ce }}"><Data ss:Type="String">{{ $r['time_out'] }}</Data></Cell>
        <Cell ss:StyleID="num"><Data ss:Type="Number">{{ $r['hours'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $r['status'] === 'approved' ? 'green' : 'yellow' }}"><Data ss:Type="String">{{ ucfirst($r['status']) }}</Data></Cell>
        <Cell ss:StyleID="{{ $r['verified'] ? 'green' : 'yellow' }}"><Data ss:Type="String">{{ $r['verified'] ? 'Yes' : 'No' }}</Data></Cell>
      </Row>
      @endforeach
    </Table>
  </Worksheet>
</Workbook>
