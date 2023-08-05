@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> --}}
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
                <div class="container-modal position-absolute" id="myModal" style="display: none;">
                    <div id="modal-header">
                        Market
                    </div>
                    <div id="modal-body" class="d-flex justify-content-center py-2">
                        <div class="d-flex">
                            <img src="{{ asset('../img/salvos/potion.png') }}" alt="potion" class="potion">
                            <div class="d-flex align-items-center pt-3">
                                <p>Pilih salah satu <em>potion</em> di bawah ini</p>
                            </div>
                        </div>
                    </div>
                    <div id="modal-footer" class="d-flex justify-content-center pb-3">
                        <button class="button-salvos market" onclick="prosesBuyPotion1()">
                            <img class="krona krona-icon" src="{{ asset('../img/salvos/krona.png') }}"
                                alt="">100/1000
                            hp</button>
                        <button class="button-salvos" onclick="prosesBuyPotion2()">
                            <img class="krona krona-icon"
                                src="{{ asset('../img/salvos/krona.png') }}" alt="">200/3000 hp</button>
                    </div>
                </div>
                <div class="healthbar-wrapper d-flex pt-5 py-3">
                    <div class="player-section hb">
                        <div class="team-select-section">
                            <select name="team" id="team" class="select2 w-100 mb-3" onchange="loadGanti()"
                                required>
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
                            <p class="ps-1 mb-0 player-desc" style="color:white"><span id="krona">-</span></p>
                        </div>
                        <div class="weapon-container d-flex align-content-center">
                            <img src="{{ asset('../img/salvos/senjataLVL1.png') }}" alt="krona" id="sword" class="krona mt-2">
                            <p class="player-desc" style="color:white">Level <span id="weap_lv">-</span></p>
                        </div>
                    </div>
                    <h3 style="color:white;text-align: center">Turn<br><span id="turn"></span><br><br>
                        {{-- <span
                            id="turn_sapa">Your Turn</span> --}}
                            <div id="log_get" st+yle="padding-left:10px; padding-top:5px; ">
                                <p class="ms-3" style="color:white"><span id="log"></span></p>
                            </div></h3>
                    <div class="salvos-section hb">
                        <label for="health-salvos" class="health-label">Salvos</label>
                        <div class="healthbar h-s">
                            <h5 style="color:white" class="label-hp"><span id="enemy_hp">-</span>/10000</h5>
                            <div id="health-salvos"></div>
                        </div>
                        
                    </div>


                    {{-- stuff --}}
                </div>
                <img src="{{ asset('../img/salvos/player_idle.gif') }}" alt="player" class="player">
                <img src="{{ asset('../img/salvos/slash.gif') }}" alt="slash" class="slash none">
                <img src="{{ asset('../img/salvos/fireball.gif') }}" alt="fireball" class="fireball none">
                <img src="{{ asset('../img/salvos/dragon_idle.gif') }}" alt="dragon" class="dragon">
                <div class="actionbar w-100 position-absolute d-flex justify-content-center" id="actionbar">
                    <button class="button-salvos px-4" id="button-attack" onclick="prosesAttack()"><img
                            src="{{ asset('../img/salvos/slash.gif') }}" alt="slash" class="icon"> Attack</button>
                    <button class="button-salvos px-4" id="button-upgrade" onclick="prosesUpgrade()"> <img
                            src="{{ asset('../img/salvos/senjataLVL2.png') }}" alt="pedang" class="icon">Upgrade
                        Weapon</button>
                    <button class="button-salvos px-4" id="button-potion" onclick="prosesBuyPotion()"><img
                            src="{{ asset('../img/salvos/potion.png') }}" alt="slash" class="icon">Buy
                        Potion</button>
                    <button class="button-salvos px-4" id="button-revive" onclick="prosesRevive()"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bandaid icon" viewBox="0 0 16 16">
                            <path
                                d="M14.121 1.879a3 3 0 0 0-4.242 0L8.733 3.026l4.261 4.26 1.127-1.165a3 3 0 0 0 0-4.242ZM12.293 8 8.027 3.734 3.738 8.031 8 12.293 12.293 8Zm-5.006 4.994L3.03 8.737 1.879 9.88a3 3 0 0 0 4.241 4.24l.006-.006 1.16-1.121ZM2.679 7.676l6.492-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492.001-.002Z" />
                            <path
                                d="M5.56 7.646a.5.5 0 1 1-.706.708.5.5 0 0 1 .707-.708Zm1.415-1.414a.5.5 0 1 1-.707.707.5.5 0 0 1 .707-.707ZM8.39 4.818a.5.5 0 1 1-.708.707.5.5 0 0 1 .707-.707Zm0 5.657a.5.5 0 1 1-.708.707.5.5 0 0 1 .707-.707ZM9.803 9.06a.5.5 0 1 1-.707.708.5.5 0 0 1 .707-.707Zm1.414-1.414a.5.5 0 1 1-.706.708.5.5 0 0 1 .707-.708ZM6.975 9.06a.5.5 0 1 1-.707.708.5.5 0 0 1 .707-.707ZM8.39 7.646a.5.5 0 1 1-.708.708.5.5 0 0 1 .707-.708Zm1.413-1.414a.5.5 0 1 1-.707.707.5.5 0 0 1 .707-.707Z" />
                        </svg>Revive</button>
                    <button class="button-salvos px-4" id="button-powerup" onclick="prosesPowerup()"><img
                            src="{{ asset('../img/salvos/powerUp.png') }}" alt="slash" class="icon">Power
                        Up</button>
                </div>
            </div>

        </div>

    </div>
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

        const prosesBuyPotion = () => {
            $('#myModal').toggle();
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
                    if (data[0].player_hp <= 0)
                        $('.player').hide();
                    else
                        $('.player').show();
                    if (data[0].enemy_hp <= 0)
                        $('.dragon').hide();
                    else
                        $('.dragon').show();
                    $('#krona').text(data[0].krona);
                    $('#weap_lv').text(data[0].weap_lv);
                    if (data[0].weap_lv == 1){
                        $('#sword').attr('src', "../img/salvos/senjataLVL1.png");
                    }else if (data[0].weap_lv == 2){
                        $('#sword').attr('src', "../img/salvos/senjataLVL2.png");
                    }else{
                        $('#sword').attr('src', "../img/salvos/senjataLVL3.png"); 
                    }
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
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 3200);
                        $('.player').attr('src', "../img/salvos/player_atk.gif");
                        setTimeout(() => {
                            $('.dragon').attr('src', "../img/salvos/dragon_hit.gif");
                        }, 2500);

                        setTimeout(() => {
                            $('.dragon').attr('src', "../img/salvos/dragon_idle.gif");
                            $('.slash').addClass('none');
                        }, 3000);
                        setTimeout(() => {
                            $('.slash').removeClass('none');
                            $('.player').attr('src', "../img/salvos/player_idle.gif");
                        }, 1600);
                    }else{
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                    }
                    setTimeout(function() {
                        $('#log').text(data[0].msg);
                        load();
                    }, 2500);
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
                    if (data[0].status == true) {
                        $('.dragon').attr('src', "../img/salvos/dragon_atk.gif");
                        setTimeout(() => {
                            $('.player').attr('src', "../img/salvos/player_hit.gif");
                        }, 2500);
                        setTimeout(() => {
                            $('.player').attr('src', "../img/salvos/player_idle.gif");
                            $('.fireball').addClass('none');
                        }, 3000);
                        setTimeout(() => {
                            $('.fireball').removeClass('none');
                        }, 1600);
                        setTimeout(() => {
                            $('.dragon').attr('src', "../img/salvos/dragon_idle.gif");
                        }, 2600);
                    }
                    setTimeout(function() {
                        load();
                        $('#log').text(data[0].msg);
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                    }, 3000);
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
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 2000);
                    }else{
                    }
                    setTimeout(function() {
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                        $('#log').text(data[0].msg);
                        load();
                    }, 2500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


        const prosesBuyPotion1 = () => {
            $('#myModal').hide();
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.buyPotion') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                    'buy': 1
                },
                success: function(data) {
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 2000);
                    }else{
                    }
                    setTimeout(function() {
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                        $('#log').text(data[0].msg);
                        load();
                    }, 1500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesBuyPotion2 = () => {
            $('#myModal').hide();
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.buyPotion') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                    'buy': 2
                },
                success: function(data) {
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 2000);
                    }else{
                    }
                    setTimeout(function() {
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                        $('#log').text(data[0].msg);
                        load();
                    }, 1500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesRevive = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.revive') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                    'buy': 2
                },
                success: function(data) {
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 2000);
                    }else{
                    }
                    setTimeout(function() {
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                        $('#log').text(data[0].msg);
                        load();
                    }, 2500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const prosesPowerup = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('salvos.powerup') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                    'buy': 2
                },
                success: function(data) {
                    $('#button-attack').attr('disabled', true);
                    $('#button-upgrade').attr('disabled', true);
                    $('#button-potion').attr('disabled', true);
                    $('#button-revive').attr('disabled', true);
                    $('#button-powerup').attr('disabled', true);
                    $('#turn_sapa').text("Enemy's Turn");
                    $('#actionbar').removeClass("actionbar");
                    $('#actionbar').addClass("actionbar-down");
                    if (data[0].status == true) {
                        setTimeout(function() {
                            prosesEnemyAttack();
                        }, 2000);
                    }else{
                    }
                    setTimeout(function() {
                        $('#button-attack').attr('disabled', false);
                        $('#button-upgrade').attr('disabled', false);
                        $('#button-potion').attr('disabled', false);
                        $('#button-revive').attr('disabled', false);
                        $('#button-powerup').attr('disabled', false);
                        $('#turn_sapa').text("Your Turn");
                        $('#actionbar').removeClass("actionbar-down");
                        $('#actionbar').addClass("actionbar");
                        $('#log').text(data[0].msg);
                        load();
                    }, 2500);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        $('#button-attack').click(function(e) {});
    </script>
@endsection
