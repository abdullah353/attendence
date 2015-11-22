<head>
  <title> Tesla Attendace System </title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/table.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div class="container">
    <h2>Attendance Overview</h2>

    <table class="col-xs-12" id="rounded-corner">
      <thead>
        <tr>
          <th>Name</th><th>Check IN</th><th>Check Out</th>
        </tr>
      </thead>

      <tbody>
        @foreach (json_decode($employees) as $employee)
          @if( count($employee->checkins) == 0 )
            <tr class="absent">
              <td>{{ $employee->name }}</td><td> - </td><td> - </td>
            </tr>

          @elseif ( count($employee->checkins) == 1)
            <tr>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->checkins[0]->checkin }}</td>
              <td>-</td>
            </tr>

          @elseif ( count($employee->checkins) == 2 )
            <tr>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->checkins[0]->checkin }}</td>
              <td>{{ $employee->checkins[0]->checkin }}</td>
            </tr>

          @else
            <tr>
              <td>{{ $employee->name }}</td><td> NA </td><td> NA </td>
            </tr>

          @endif 

        @endforeach
      </tbody>
    </table>
  </div><!-- .container -->
</body>
