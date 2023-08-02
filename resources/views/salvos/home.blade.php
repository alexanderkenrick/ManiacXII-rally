@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/treasure.css') }}">
    <style>
        @import url('https://fonts.cdnfonts.com/css/montserrat');
        .container-fluid {
            overflow: hidden;
        }

        .actionbar {
            position: fixed;
            left: 32px;
            right: 32px;
            bottom: 32px;
            height: 25%;
        }

        .selection {
            top: 20px;
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

        .player {
            width: 250px;
            height: 300px;
            align-self: flex-end;
        }

        .dragon {
            width: 700px;
            height: 400px;
            align-self: flex-end;
        }

        #playing-area {
            background-image: url('../img/salvos/bg_battle.png')
        }

        .row {
            height: 100vh;
        }

        .ground {
            /* background-image: url('img/salvos/bg_battle.png');
                object-fit: contain; */
        }

        .image-background {
            background-image: url('img/salvos/bg_battle.png');
            aspect-ratio: 16/9;
            background-position: center;
            background-size: cover;
            width: 100%;
            position: relative;
        }

        .dragon{
            position: absolute;
            right: 3%;
            bottom: 105px;
        }

        .player{
            position: absolute;
            left: 80px;
            bottom: 105px;
        }

        @keyframes MoveUpDown {

            0%,
            100% {
                bottom: 150px;
            }

            50% {
                bottom: 175px;
            }
        }

        .healthbar-wrapper{
            position: absolute;
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .hb{
            position: absolute;
            width: 300px;
            top: 20px;
        }

        .player-section{
            left: 20px
        }

        .salvos-section{
            right: 20px;
        }

        .healthbar{
            width: 100%;
            background: transparent;
            border: 3px solid yellow;
            transform: rotateY(0deg);
            border-radius: 8px;
        }
        .h-s{
            transform: rotateY(180deg);
        }

        .health-label{
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            color: #fff;
            text-indent: 10px;
            text-align: right;
        }

        #health-player{
            /* width: 100%; */
            width: 0;
            height: 30px;
            background: red;
            border-radius: 4px; 
            transition: linear 0.5s;
        }

        #health-salvos{
            width: 0;
            height: 30px;
            background:red;
            border-radius: 4px; 
            transition: linear 0.5s;
        }


    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 ground">
                <div class="image-background">
                    <div class="healthbar-wrapper">

                        <div class="player-section hb">
                            <label for="health-player" class="health-label">Player</label>
                            <div class="healthbar h-p">
                                <div id="health-player"></div>
                            </div>
                        </div>
                        
                        <div class="salvos-section hb">
                            <label for="health-salvos" class="health-label">Salvos</label>
                            <div class="healthbar h-s">
                                <div id="health-salvos"></div>
                            </div>
                        </div>
                        
                    </div>
                    <img src="{{ asset('../img/salvos/monster.png') }}" alt="player" class="player">
                    <img src="{{ asset('../img/salvos/dragon_idle.gif') }}" alt="dragon" class="dragon">

                    
                </div>
                
            </div>

            <div class="col-3">
                {{-- Team Select --}}
                <div class="team-select-section mb-3">
                    <select name="team" id="team" class="select2 w-50 mb-3" onchange="loadGanti()" required>
                        <option value="-" selected disabled>- Pilih Team -</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" id="{{ $team->id }}">
                                {{ $team->account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="description">
                    <h3 style="color:white">HP <span id="player_hp">-</span></h3>
                    <p style="color:white">Turn : <span id="turn">-</span></p>
                    <p style="color:white">Krona : <span id="krona">-</span></p>
                    <p style="color:white">Weap Lv : <span id="weap_lv">-</span></p>
                </div>
                <div class="col-6">
                    <h3 style="color:white">Ini Nama Boss</h3>
                    <h5 style="color:white">HP <span id="enemy_hp">-</span></h5>
                    <p style="color:white">Log <span id="log"></span></p>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- action bawah -->
    <div class="actionbar">
        {{-- <button class="button" id="button-attack" onclick="prosesAttack()">Attack</button>
            <button class="button" id="button-upgrade" onclick="prosesUpgrade()">Upgrade Weapon</button> --}}
    </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            load();
        });

        const healthBarPlayer = (char,healthRemain) => {
            let width = Math.ceil(healthRemain/100);

            let element;

            if(char=='player'){
                element = document.getElementById("health-player"); 
            }else if(char=='salvos'){
                element = document.getElementById("health-salvos"); 

            }
           
            element.style.width = width+'%';
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
