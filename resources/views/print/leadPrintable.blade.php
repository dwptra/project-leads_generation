<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Print</title>

    <script>
      window.onload = function() {
        window.print();
        setTimeout(function(){window.close();}, 1000);
      }
    </script>
</head>
<body>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Owner</th>
            <th scope="col">Brand</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Instagram</th>
            <th scope="col">Tiktok</th>
            <th scope="col">Other</th>
            <th scope="col">History Date</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($leads as $user)
            <tr>
                <th>{{ $user->id}}</th>
                <th>{{ $user->name}}</th>
                <th>{{ $user->owner ? $user->owner->name : '-' }}</th>
                <th>{{ $user->brand ?? '-' }}</th>
                <th>{{ $user->phone ?? '-' }}</th>
                <th>{{ $user->email ?? '-' }}</th>
                <th>{{ $user->instagram ?? '-' }}</th>
                <th>{{ $user->tiktok ?? '-' }}</th>
                <th>{{ $user->other ?? '-' }}</th>
                <th>{{ $historyDates->where('leads_id', $user->id)->first() ? $historyDates->where('leads_id', $user->id)->first()->last_history_date : '-' }}
                </th>
                <th>{{ $user->status }}</th>
            </tr>
            @endforeach
        </tbody>
      </table>


        


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>