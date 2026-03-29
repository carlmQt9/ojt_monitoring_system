<?xml version="1.0" encoding="UTF-8"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:x="urn:schemas-microsoft-com:office:excel">
  <Styles>
    <Style ss:ID="title">
      <Font ss:Bold="1" ss:Size="14" ss:Color="#1a3a6b"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="header">
      <Font ss:Bold="1" ss:Color="#FFFFFF"/>
      <Interior ss:Color="#1a3a6b" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
      <Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/></Borders>
    </Style>
    <Style ss:ID="subheader">
      <Font ss:Bold="1" ss:Color="#1a3a6b"/>
      <Interior ss:Color="#dce8ff" ss:Pattern="Solid"/>
    </Style>
    <Style ss:ID="even">
      <Interior ss:Color="#f5f8ff" ss:Pattern="Solid"/>
    </Style>
    <Style ss:ID="bold">
      <Font ss:Bold="1"/>
    </Style>
    <Style ss:ID="pct">
      <NumberFormat ss:Format="0.00&quot;%&quot;"/>
    </Style>
    <Style ss:ID="num">
      <NumberFormat ss:Format="0.0000"/>
    </Style>
    <Style ss:ID="center">
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="green">
      <Font ss:Bold="1" ss:Color="#276221"/>
      <Interior ss:Color="#d4edda" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
    <Style ss:ID="blue">
      <Font ss:Bold="1" ss:Color="#0c4a6e"/>
      <Interior ss:Color="#dbeafe" ss:Pattern="Solid"/>
      <Alignment ss:Horizontal="Center"/>
    </Style>
  </Styles>

  <!-- Sheet 1: Summary -->
  <Worksheet ss:Name="Summary">
    <Table ss:DefaultColumnWidth="120">
      <Column ss:Width="220"/>
      <Column ss:Width="160"/>
      <Row ss:Height="30">
        <Cell ss:MergeAcross="1" ss:StyleID="title"><Data ss:Type="String">OJT Monitoring System — System Report</Data></Cell>
      </Row>
      <Row>
        <Cell ss:MergeAcross="1"><Data ss:Type="String">Generated: {{ now()->format('F d, Y H:i') }}</Data></Cell>
      </Row>
      <Row/>
      <Row>
        <Cell ss:StyleID="subheader"><Data ss:Type="String">Metric</Data></Cell>
        <Cell ss:StyleID="subheader"><Data ss:Type="String">Value</Data></Cell>
      </Row>
      <Row>
        <Cell><Data ss:Type="String">Total Users</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $totalUsers }}</Data></Cell>
      </Row>
      <Row ss:StyleID="even">
        <Cell><Data ss:Type="String">Total Students</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $totalStudents }}</Data></Cell>
      </Row>
      <Row>
        <Cell><Data ss:Type="String">Total Supervisors</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $totalSupervisors }}</Data></Cell>
      </Row>
      <Row ss:StyleID="even">
        <Cell><Data ss:Type="String">Total Coordinators</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $totalCoordinators }}</Data></Cell>
      </Row>
      <Row>
        <Cell><Data ss:Type="String">Required OJT Hours</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $required }}</Data></Cell>
      </Row>
      <Row ss:StyleID="even">
        <Cell><Data ss:Type="String">Students Completed</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $completedCount }}</Data></Cell>
      </Row>
      <Row>
        <Cell><Data ss:Type="String">Overall Completion Rate</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="String">{{ $completionRate }}%</Data></Cell>
      </Row>
    </Table>
  </Worksheet>

  <!-- Sheet 2: Student Progress -->
  <Worksheet ss:Name="Student Progress">
    <Table ss:DefaultColumnWidth="120">
      <Column ss:Width="160"/>
      <Column ss:Width="200"/>
      <Column ss:Width="180"/>
      <Column ss:Width="110"/>
      <Column ss:Width="110"/>
      <Column ss:Width="110"/>
      <Column ss:Width="100"/>
      <Column ss:Width="100"/>
      <Row ss:Height="24">
        <Cell ss:StyleID="header"><Data ss:Type="String">Name</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Email</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Company</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Hours Completed</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Hours Required</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Remaining Hours</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Progress %</Data></Cell>
        <Cell ss:StyleID="header"><Data ss:Type="String">Status</Data></Cell>
      </Row>
      @foreach($students as $i => $s)
      @php $style = ($i % 2 === 0) ? '' : 'even'; @endphp
      <Row>
        <Cell ss:StyleID="{{ $style }}"><Data ss:Type="String">{{ $s['name'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $style }}"><Data ss:Type="String">{{ $s['email'] }}</Data></Cell>
        <Cell ss:StyleID="{{ $style }}"><Data ss:Type="String">{{ $s['company'] }}</Data></Cell>
        <Cell ss:StyleID="num"><Data ss:Type="Number">{{ $s['hours_completed'] }}</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="Number">{{ $s['required'] }}</Data></Cell>
        <Cell ss:StyleID="num"><Data ss:Type="Number">{{ $s['remaining'] }}</Data></Cell>
        <Cell ss:StyleID="center"><Data ss:Type="String">{{ $s['pct'] }}%</Data></Cell>
        <Cell ss:StyleID="{{ $s['status'] === 'Completed' ? 'green' : 'blue' }}"><Data ss:Type="String">{{ $s['status'] }}</Data></Cell>
      </Row>
      @endforeach
    </Table>
  </Worksheet>

</Workbook>
