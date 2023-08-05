@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/treasure.css') }}">
@endsection

@section('content')
    <div class="mx-1 my-4 d-flex align-items-center w-100 justify-content-center" style="height:90vh">

        <div class="row px-2 w-100">
            <div class="col-8 ">
                <div class="map-wrapper">
                    <div class="marking">
                        <table id="map-table">

                        </table>
                        @for ($i = 1; $i <= 10; $i++)
                            @php
                                $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
                            @endphp
                            <span id='x-{{ $i }}'>{{ $alpha[$i - 1] }}</span>
                        @endfor
                        @for ($i = 1; $i <= 15; $i++)
                            <span id='y-{{ $i }}'>{{ $i }}</span>
                        @endfor
                    </div>

                </div>
            </div>

            {{-- Sisi Kanan --}}
            <div class="col-4">
                <div class="card" id="control-section">
                    <div class="card-body">
                        {{-- Team Select --}}
                        <div class="team-select-section">
                            <select name="team" id="team" class="select2 w-100" onchange="getTeamInventory()"
                                required>
                                <option value="-" selected disabled>- Pilih Team -</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" id="{{ $team->id }}">
                                        [{{ $team->id }}]&nbsp;{{ $team->account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Timer --}}
                        <div class="timer-section mt-4">
                            <div class="time">
                                <div class="row">
                                    <div class="col d-flex justify-content-start">
                                        Timer
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <span id="timer">05:00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timer-button-section d-flex justify-content-center">
                                <button class="button" id="button-start">Start</button>
                                <button class="button" id="button-pause">Pause</button>
                                <button class="button" id="button-reset">Reset</button>
                            </div>
                        </div>

                        {{-- Inventory --}}
                        <div class="inventory-section p-3 mt-4 ">
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/shovel.png') }}" alt="" class="item-image"
                                        id="shovel-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Shovel <span style="font-size: 16px">(100)</span></h2>
                                    <p>Jumlah : <span id="shovel-remaining">-</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="shovel-use" onclick="useShovel()">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/thief.png') }}" alt="" class="item-image"
                                        id="thief-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Thief Bag <span style="font-size: 16px">(200)</span></h2>                                </div>
                                <div class="button-container">
                                    <button class="button" id="thief-use" onclick="useThief()">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/angel.png') }}" alt="" class="item-image"
                                        id="angel-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Angel Card <span style="font-size: 16px">(150)</span></h2>
                                    <p>Status : <span id="angel-status">Inactive</span></p>
                                
                                </div>
                                <div class="button-container">
                                    <button class="button" id="angel-use" onclick="useAngel()">Use</button>
                                </div>
                            </div>
                        </div>

                        {{-- Krona & Sisa Gerak --}}
                        <div class="krona-section mt-2">
                            <p>Krona : <span id="krona">-</span></p>
                            <p>Sisa Gerakan : <span id="sisa-gerakan">-</span></p>
                        </div>

                        {{-- Movement Button --}}
                        <div class="movement-section mt-3">
                            <button class="button" id="btn-up" onclick="updatePosition('up')">U</button>
                            <button class="button" id="btn-right" onclick="updatePosition('right')">R</button>
                            <button class="button" id="btn-down" onclick="updatePosition('down')">D</button>
                            <button class="button" id="btn-left" onclick="updatePosition('left')">L</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            updateMap();
        });

        let shovelUsed = false;

        // Timer
        var timer;
        var second = 300;
        var running = false;
        $(document).on('click', '#button-start', function() {
            if (!running) {
                $("#timer").css('display', 'inline');
                $('#button-start').attr('disabled', true);
                $('#button-start').addClass('button-disabled');
                $('#button-pause').removeClass('button-disabled');
                $('#button-pause').removeAttr('disabled');
                shovelUsed = false;
                running = true;
                timer = setInterval(function() {
                    second--;
                    // $("#timer").text(second);
                    showTimer(second);
                    if (second <= 0) {
                        $("#timer").text('Waktu Habis');
                        // alert('Waktu Habis');
                        Swal.fire({
                            icon: 'warning',
                            title: "Waktu Habis"
                        });
                        running = false;
                        clearInterval(timer);
                        second = 300;
                    }
                }, 1000);
            }
        });

        $(document).on('click', '#button-pause', function() {
            // $("#timer").text(second);
            $('#button-pause').addClass('button-disabled');
            $('#button-pause').attr('disabled', true);
            $('#button-start').removeClass('button-disabled');
            $('#button-start').removeAttr('disabled');
            showTimer(second);
            running = false
            clearInterval(timer);
        });

        $(document).on('click', '#button-reset', function() {
            $("#timer").text('05:00');
            $('#button-start').removeAttr('disabled');
            $('#button-start').removeClass('button-disabled');
            $('#button-pause').removeClass('button-disabled');
            $('#button-pause').removeAttr('disabled');
            running = false;
            clearInterval(timer);
            second = 300;
        });

        function showTimer(second) {
            let minute = second / 60;
            let seconds = second % 60;

            let minuteString = parseInt(minute).toString();
            let secondString = seconds.toString();
            if (minuteString.length == 1) {
                minuteString = "0" + minuteString;
            }
            if (secondString.length == 1) {
                secondString = "0" + secondString;
            }

            $("#timer").text(`${minuteString}:${secondString}`);
        }
        // End of Timer

        const updatePosition = (movement) => {
            let team_id = $('#team').val();
            let xMove = 0;
            let yMove = 0;

            if (movement == 'up') {
                yMove = -1;
            } else if (movement == 'right') {
                xMove = 1;
            } else if (movement == 'down') {
                yMove = 1;
            } else if (movement == 'left') {
                xMove = -1;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.updatePost') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': team_id,
                    'xMove': xMove,
                    'yMove': yMove,
                },
                success: function(data) {
                    $('#sisa-gerakan').text(data[0].moves);
                    updateMap();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const getTeamInventory = () => {
            let team_id = $('#team').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.getInv') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {

                    // console.log(team_inv);
                    $("#shovel-remaining").text(data[0].shovel);
                    $('#sisa-gerakan').text(data[0].moves);
                    console.log(data[0].angelStatus);
                    if(data[0].angelStatus==0){
                        $('#angel-status').text('Inactive');
                        $('#angel-status').addClass("badge bg-danger");
                    }else if(data[0].angelStatus==1){
                        $('#angel-status').text('Active');
                        $('#angel-status').addClass("badge bg-success");
                    }
                    $('#krona').text(data[0].krona);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const refreshInventory = () => {
            let team_id = $('#team').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.refInv') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    $("#shovel-remaining").text(data[0].shovel);
                    $('#sisa-gerakan').text(data[0].moves);
                    
                    if(data[0].angelStatus==0){
                        $('#angel-status').text('Inactive');
                        $('#angel-status').addClass("badge bg-danger");
                        $('#angel-status').removeClass("badge bg-success");   
                    }else if(data[0].angelStatus==1){
                        $('#angel-status').text('Active');
                        $('#angel-status').removeClass("badge bg-danger");                        
                        $('#angel-status').addClass("badge bg-success");
                    }
                    $('#krona').text(data[0].krona);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const updateMap = () => {
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.updateMap') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                },
                success: function(data) {
                    document.getElementById("map-table").innerHTML = '';
                    // console.log(data[0].array_Team.length);
                    let counterId = 0;
                    let playerCount = 0;
                    for (let i = 0; i < 10; i++) {
                        document.getElementById("map-table").innerHTML += `<tr id="baris-${i+1}">`;
                        let kolom = '';
                        for (let j = 0; j < 15; j++) {
                            let tempRow = data[0].array_Map[counterId]['row'];
                            let tempCol = data[0].array_Map[counterId]['column'];

                            if (data[0].array_Map[counterId]['digged'] == '1') {
                                if ((tempRow == 1) || (tempCol == 15) || (tempCol == 1) || (tempRow ==
                                    15)) {
                                    kolom +=
                                        `<td id="${tempRow}-${tempCol}" class="map-kolom" onclick='startPosition(${tempRow},${tempCol})'></td>`;
                                } else {
                                    kolom += `<td id="${tempRow}-${tempCol}" class="map-kolom"></td>`;
                                }

                            } else {
                                if ((tempRow == 1) || (tempCol == 15) || (tempCol == 1) || (tempRow ==
                                    15)) {
                                    kolom +=
                                        `<td id="${tempRow}-${tempCol}" class="map-kolom"><img src="{{ asset('/img/treasure/tanah.png') }}" alt="" class="map-tanah" onclick='startPosition(${tempRow},${tempCol})'></td>`;
                                } else {
                                    kolom +=
                                        `<td id="${tempRow}-${tempCol}" class="map-kolom"><img src="{{ asset('/img/treasure/tanah.png') }}" alt="" class="map-tanah"></td>`;
                                }

                            }
                            counterId += 1;
                        }
                        kolom += `</tr>`;

                        document.getElementById(`baris-${i+1}`).innerHTML += kolom;
                    }

                    if (data[0].array_Team.length) {
                        for (let playerCount = 0; playerCount < data[0].array_Team.length; playerCount++) {
                            let tempSpan =
                                `<span class="pion">${data[0].array_Team[playerCount]['teams_id']}</span>`;
                            let tempId =
                                `${data[0].array_Team[playerCount]['row']}-${data[0].array_Team[playerCount]['column']}`;
                            // console.log(tempId);
                            document.getElementById(tempId).innerHTML += tempSpan;
                        }
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        // setInterval(updateMap, 3000);

        const addShovel = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.addShovel') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                },
                success: function(data) {
                    getTeamInventory();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        $('#team').change(function(e) {
            shovelUsed = false;
        });

        const removeShovel = () => {
            if (shovelUsed == false) {
                let team_id = $('#team').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('treasure.removeShovel') }}',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'id': team_id,
                    },
                    success: function(data) {
                        getTeamInventory();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
            getTeamInventory();
        }

        const useShovel = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.useShovel') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': team_id,
                    'id': team_id,
                },
                success: function(data) {

                    alert(data[0].msg);
                    $('#krona').text(data[0].krona);
                    refreshInventory();
                    updateMap();
                    shovelUsed = true;
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const useThief = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.useThief') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': team_id,
                    'id': team_id,
                },
                success: function(data) {
                    alert(data[0].msg);
                    $('#krona').text(data[0].krona);
                    refreshInventory();
                    updateMap();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const useAngel = () => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.useAngel') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': team_id,
                    'id': team_id,
                },
                success: function(data) {
                    alert(data[0].msg);
                    refreshInventory();
                    updateMap();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const buyItem = (items_id) => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.buyItem') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': team_id,
                    'items_id': items_id,
                },
                success: function(data) {
                    alert(data[0].msg);
                    refreshInventory();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        const startPosition = (row, col) => {
            let team_id = $('#team').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('treasure.startPost') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': team_id,
                    'row': row,
                    'col': col,
                },
                success: function(data) {
                    if (data[0].msg != "") {
                        alert(data[0].msg);
                    }
                    getTeamInventory();
                    updateMap();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
