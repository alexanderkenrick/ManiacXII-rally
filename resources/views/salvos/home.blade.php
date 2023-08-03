@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/treasure.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/salvos.css') }}">
    <style>
        @import url('https://fonts.cdnfonts.com/css/montserrat');
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="image-background col-">

                <div class="healthbar-wrapper d-flex pt-5 py-3">
                    <div class="player-section hb">
                        <div class="team-select-section">
                            <select name="team" id="team" class="select2 w-50 mb-3" onchange="loadGanti()" required>
                                <option value="-" selected disabled>- Pilih Team -</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" id="{{ $team->id }}">
                                        {{ $team->account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <label for="health-player" class="health-label">Player</label> --}}
                        <div class="healthbar h-p">
                            <h5 style="color:white" class="label-hp"><span id="player_hp">-</span>/10000</h5>
                            <div id="health-player"></div>
                        </div>
                        <div class="krona-container d-flex">
                            <img src="{{ asset('../img/salvos/krona.png') }}" alt="krona" class="krona mt-2">
                            <p class="ps-1 mb-0 player-desc" style="color:white">Krona : <span id="krona">-</span></p>
                        </div>
                        <div class="weapon-container d-flex align-content-center">
                            <img src="{{ asset('../img/salvos/senjataLVL1.png') }}" alt="krona" class="krona mt-2">
                            <p class="player-desc" style="color:white">Weapon Level: <span id="weap_lv">-</span></p>
                        </div>
                    </div>
                    <h3 style="color:white">Turn </h3>
                    <div class="salvos-section hb">
                        <label for="health-salvos" class="health-label">Salvos</label>
                        <div class="healthbar h-s">
                            <h5 style="color:white" class="label-hp"><span id="enemy_hp">-</span>/10000</h5>
                            <div id="health-salvos"></div>
                        </div>
                        <div id="log" st+yle="padding-left:10px; padding-top:5px; ">
                            <p class="ms-3" style="color:white">Log <span id="log"></span></p>
                        </div>
                    </div>

                </div>
                <img src="{{ asset('../img/salvos/player_idle.gif') }}" alt="player" class="player">
                <img src="{{ asset('../img/salvos/dragon_idle.gif') }}" alt="dragon" class="dragon">
                <div class="actionbar w-100 position-absolute d-flex justify-content-center">
                    <button class="button-salvos" id="button-attack" onclick="prosesAttack()">Attack</button>
                    <button class="button-salvos" id="button-upgrade" onclick="prosesUpgrade()">Upgrade Weapon</button>
                    <button class="button-salvos">Buy Potion</button>
                    <button class="button-salvos">Revive</button>
                    <button class="button-salvos">Power Up</button>
                </div>
            </div>
        </div>


        <div>
            {{-- Team Select --}}

        </div>
        {{-- <h3 style="color:white">Ini Nama Boss</h3>
            <h5 style="color:white">HP <span id="enemy_hp">-</span></h5> --}}
    </div>
    </div>

    </div>
    <!-- action bawah -->

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            load();
        });

        const healthBarPlayer = (char, healthRemain) => {
            let width = Math.ceil(healthRemain / 100);
            let element;

            if (char == 'player') {
                element = document.getElementById("health-player");
            } else if (char == 'salvos') {
                element = document.getElementById("health-salvos");
            }

            element.style.width = width + '%';
        }

        const loadGanti = () => {
            load();
            $('#log').text('');
        }

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
                    healthBarPlayer('player', data[0].player_hp);
                    $("#enemy_hp").text(data[0].enemy_hp);
                    healthBarPlayer('salvos', data[0].enemy_hp);
                    $('#krona').text(data[0].krona);
                    $('#weap_lv').text(data[0].weap_lv);
                    $('#turn').text(data[0].turn);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesAttack = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.playerAttack') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    $('#log').text(data[0].msg);
                    load();
                    setTimeout(function() {
                        prosesEnemyAttack();
                    }, 2000);
                    load();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesEnemyAttack = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.enemyAttack') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    $('#log').text(data[0].msg);
                    load();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesUpgrade = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.upgrade') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    $('#log').text(data[0].msg);
                    load();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
