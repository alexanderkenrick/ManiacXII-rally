@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/treasure.css') }}">
@endsection

@section('content')

    <div class="container my-4">

        <div class="row">
            <div class="col-7 ">
                <div class="map-wrapper">
                    <div class="">
                        <table id="map-table">
                            @for ($baris = 1; $baris <= 10; $baris++)
                                <tr id="baris-{{$baris}}">
                                    @for ($kolom = 1; $kolom <= 10; $kolom++)
                                        <td id="{{ $baris }}-{{ $kolom }}" class="map-kolom">
                                            {{-- @if ($baris == 2 && $kolom == 4)
                                                <span class="pion">1</span>
                                                {{-- <span class="pion">2</span>
                                            @endif --}}
                                            <img src="{{ asset('/img/treasure/tanah.png') }}" alt=""
                                                class="map-tanah">
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div>

                </div>
            </div>

            {{-- Sisi Kanan --}}
            <div class="col-5">
                <div class="card" id="control-section">
                    <div class="card-body">
                        {{-- Team Select --}}
                        <div class="team-select-section">
                            <select name="team" id="team" class="select2 w-100" onchange="getTeamInventory()"
                                required>
                                <option value="-" selected disabled>- Pilih Team -</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" id="{{ $team->id }}">
                                        {{ $team->account->name }}
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
                                    <h2>Shovel</h2>
                                    <p>Jumlah : <span id="shovel-remaining">-</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="shovel-use">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/thief.png') }}" alt="" class="item-image"
                                        id="thief-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Thief Bag</h2>
                                    <p>Jumlah : <span id="thief-remaining">-</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="thief-use">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/angel.png') }}" alt="" class="item-image"
                                        id="angel-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Angel Card</h2>
                                    <p>Jumlah : <span id="angel-remaining">-</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="angel-use">Use</button>
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
                    alert(data[0].xPos + "-" + data[0].yPos + ":" + data[0].moves + "/" + data[0]
                        .outOfMove);

                    $(`#${data[0].yPos }-${data[0].xPos}`).html(
                        `<span class="pion">${team_id}</span>`
                        // kasih pengecekan is_digged
                    )
                    $('#sisa-gerakan').text(data[0].moves);
                
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
                    let team_inv = data[0].teamInventory;
                    console.log(team_inv);
                    $("#shovel-remaining").text(team_inv[0]);
                    $("#thief-remaining").text(team_inv[1]);
                    $("#angel-remaining").text(team_inv[2]);
                    console.log(data[0].moves, data[0].krona);
                    $('#sisa-gerakan').text(data[0].moves);
                    $('#krona').text(data[0].krona);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection