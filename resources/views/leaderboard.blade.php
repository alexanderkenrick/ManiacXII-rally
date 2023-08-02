<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous" defer></script>
    <style>
        body {
            height: 100vh;
            padding: 0 10rem;
            background-color: #0C2548;
        }

        .leaderboard {
            max-width: 1845px;
        }
    </style>
</head>
<body class="d-flex justify-content-center">
    <div class="h-100 w-100 overflow-auto leaderboard">
        <table class="table table-secondary">
            <thead class="table-dark">
                <tr>
                    <th class="text-center fs-4 py-4">Nama Tim</th>
                    <th class="text-center fs-4 py-4">Rally Point</th>
                    <th class="text-center fs-4 py-4">Game Besar Point</th>
                    <th class="text-center fs-4 py-4">Total Point</th>
                </tr>
            </thead>
            <tbody>
            @php
                // 10 tim yg lolos penyisihan
                $cnt = 1;
            @endphp
            @foreach($teamsData as $team => $data)
                @if($cnt <= 10)
                    <tr class="table-success">
                        <td class="text-center fs-5 fw-bold py-4">{{ $team }}</td>
                        <td class="text-center fs-5 py-4">{{ $data["rally_point"]  }}</td>
                        <td class="text-center fs-5 py-4">{{ $data["game_besar_point"] }}</td>
                        <td class="text-center fs-5 fw-semibold py-4">{{ $data["total_point"] }}</td>
                    </tr>
                    @php($cnt++)
                @else
                    <tr>
                        <td class="text-center fs-5 fw-bold py-4">{{ $team }}</td>
                        <td class="text-center fs-5 py-4">{{ $data["rally_point"]  }}</td>
                        <td class="text-center fs-5 py-4">{{ $data["game_besar_point"] }}</td>
                        <td class="text-center fs-5 fw-semibold py-4">{{ $data["total_point"] }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
