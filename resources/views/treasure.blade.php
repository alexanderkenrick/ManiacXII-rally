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
                        <table>
                            @for ($baris = 1; $baris <= 10; $baris++)
                                <tr>
                                    @for ($kolom = 1; $kolom <= 10; $kolom++)
                                        <td id="{{ $baris }}-{{ $kolom }}" class="map-kolom">
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
                            <select name="" id="" class="select2 w-100" style=" ">
                                <option value="" selected disabled>--Pilih Team--</option>
                                @for ($team = 1; $team <= 20; $team++)
                                    <option value="">Team {{ $team }}</option>
                                @endfor
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
                                        <span>05:00</span>
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
                                    <img src="{{ asset('/img/treasure/shovel.png') }}" alt="" class="item-image" id="shovel-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Shovel</h2>
                                    <p>Jumlah : <span id="shovel-remaining">3</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="shovel-use">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/thief.png') }}" alt="" class="item-image" id="thief-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Thief Bag</h2>
                                    <p>Jumlah : <span id="thief-remaining">3</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="thief-use">Use</button>
                                </div>
                            </div>
                            <div class="item">
                                <div class="image-container">
                                    <img src="{{ asset('/img/treasure/angel.png') }}" alt="" class="item-image" id="angel-image">
                                </div>
                                <div class="text-container px-3">
                                    <h2>Angel Card</h2>
                                    <p>Jumlah : <span id="angel-remaining">3</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button" id="angel-use">Use</button>
                                </div>
                            </div>
                        </div>

                        {{-- Krona & Sisa Gerak --}}
                        <div class="krona-section mt-2">
                            <p>Krona : <span id="krona">300</span></p>
                            <p>Sisa Gerakan : <span id="sisa-gerakan">3</span></p>
                        </div>

                        {{-- Movement Button --}}
                        <div class="movement-section mt-3">
                            <button class="button" id="btn-up">U</button>
                            <button class="button" id="btn-right">R</button>
                            <button class="button" id="btn-down">D</button>
                            <button class="button" id="btn-left">L</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
