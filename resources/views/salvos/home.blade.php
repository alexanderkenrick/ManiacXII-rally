@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/treasure.css') }}">
    <style>
        .actionbar {
            background-color: rgb(206, 55, 43);
            overflow: hidden;
            position: fixed;
            left: 32px;
            right: 32px;
            bottom: 32px;
            height: 25%;
        }

        .actionbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .monster {
            animation: MoveUpDown 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
            position: absolute;
            bottom: 150px;
        }

        @keyframes MoveUpDown {
        0%, 100% {
            bottom: 150px;
        }
        50% {
            bottom: 175px;
        }
        }
    </style>
@endsection
@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-5">
            {{-- Team Select --}}
            <div class="team-select-section">
                <select name="team" id="team" class="select2 w-100" onchange="load()"
                    required>
                    <option value="-" selected disabled>- Pilih Team -</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" id="{{ $team->id }}">
                            {{ $team->account->name }}
                        </option>
                    @endforeach
                </select>
                <h3 style="color:white">HP <span id="player_hp">-</span></h3>
                <h3 style="color:white">Player's Turn</h3>
                <p style="color:white">Krona : <span id="krona">-</span></p>
            </div>
        </div>
        
        <div class="col-5">
            <h3 style="color:white">Ini Nama Boss</h3>
            <h5 style="color:white">HP <span id="enemy_hp">-</span></h5>
            <img src="{{ asset('/img/salvos/monster.png') }}" alt="" class="monster responsive" width="400">
        </div>
        <!-- action bawah -->
        <div class="actionbar">
            <a href="#home">Attack</a>
            <a href="#news">Nothing</a>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            load();
        });

        const load = () => {
            let team_id = $('#team').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.load') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    $("#player_hp").text(data[0].player_hp);
                    $("#enemy_hp").text(data[0].enemy_hp);
                    $('#krona').text(data[0].krona);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
