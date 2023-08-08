@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- QR Scanner --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    {{--  Toaster Sweet Alert  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style type="text/css">
        label {
            color: white;
        }

        h1 {
            color: white;
        }

        .select2 {
            width: 100%;
        }

        .submit-section {
            margin-top: 16px;
        }

        .submit-section .btn-submit {
            width: 60%;
        }

        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }

        .btn-submit {
            width: 60%;
            height: 40px;
            border: 2px solid #3C486B;
            border-radius: 12px;
            cursor: pointer;
            background-color: #f8f9fa;
            box-shadow: 0 4px #3C486B;
            transition: 0.1s ease;
        }

        .btn-submit:hover {
            background: #d14d72;
            color: #fcc8d1;
            border: 2px solid #0b2447;
        }

        .btn-submit:active {
            background-color: #D3D3D3;
            box-shadow: 0 2px #3C486B;
            border: 2px solid #3C486B;
            transform: translateY(4px);
            color: #2e2134;
        }

        .btn-submit-disabled {
            background-color: #D3D3D3;
            box-shadow: 0 2px #3C486B;
            transform: translateY(4px);
            cursor: default;
            color: #2e2134;
        }

        #reader {
            width: auto;
            background: #a5d7e8;
            border-radius: 15px;
        }

        .qr-section {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: center;
            border-radius: 15px;
        }


        .penpos-name {
            letter-spacing: 5px;
        }

        .poison {
            width: 8em;
            left: 4em;
            transform: rotate(15deg);
            bottom: 1em;
            animation: 5s infinite poisonShine;

        }

        .angel {
            width: 6em;
            transform: scaleX(-1);
            right: 10em;
            top: 15em;
            filter: drop-shadow(-1px 1px 00.5rem #7c7c7c)
        }

        .cloud {
            width: 25%;
            left: 3em;
            top: 25em;
            z-index: 1;
            filter: drop-shadow(0 1px 0.25rem #fef2f4);
            animation: cloud 6s 2s infinite ease-in-out;
        }

        .butterfly {
            width: 2em;
            height: 4em;
        }

        .butterfly1 {
            top: 30em;
            left: -10em;
            width: 5%;
            transform: scaleX(-1);
            filter: drop-shadow(0 0 00.5rem #ffd93d)
        }

        .moon {
            right: -6em;
            width: 8em;
            top: 5em;
        }

        .main-branch {
            z-index: -1;
            top: 35em;
            filter: drop-shadow(0 0 0.25rem #ffabab);
        }

        .cloud1 {
            width: 25%;
            top: 25em;
            right: 3em;
            filter: drop-shadow(1px 3px 0.5rem #fef2f4);
            z-index: 1;
            animation: cloud 6s infinite reverse 2s ease-in-out;
        }

        .branch1 {
            top: -5em;
            transform: rotate(10deg);
            left: -30em;
            width: 50%;
            filter: drop-shadow(0 0 0.75rem #4f200d)
        }

        /* media quaries */
        @media (max-width:1200px) {
            .cloud1 {
                right: 4em;
                z-index: 1;
            }

            .branch1 {
                top: -4em;
                left: -4em;
                width: 25em;
            }

            .moon {
                right: -1em;
            }

            .poison {
                z-index: 1;
                left: 1em;
                bottom: -1em;
            }

            .butterfly1 {
                left: -3em;
            }
        }

        @media (max-width:960px) {
            .cloud {
                left: 2em;
                top: 10em;
            }

            .poison {
                left: 1em;
                z-index: 1;
            }

            .cloud1 {
                right: 2em;
                top: 10em;
            }

            .branch1 {
                left: -9em;
                top: -7em;

            }

            .butterfly1 {
                left: -5em;
                top: 25em;
                width: 7%;
            }

            .branch1 {
                top: -3em;
            }

            .moon {
                top: 3em;
                width: 5em;
                right: 2em;
            }
        }

        @media (max-width:760px) {
            .cloud {
                left: 1em;
                z-index: 1;
            }

            .cloud1 {
                right: 1em;
            }

            .poison {
                left: 0;
                z-index: 1;
                bottom: 0.1em;
            }

            .moon {
                top: 2em;
                width: 4em;
                right: -1em;
            }

            .butterfly1 {
                left: -3em;
            }

            .branch1 {
                top: -5em;
                left: -10em;
                z-index: -1;
            }

        }

        @media(max-width:490px) {
            .poison {
                z-index: 1;
                width: 6em;
            }

            .moon {
                width: 3em;
                right: 2em;
            }

            .branch1 {
                top: -4em;
                left: -8em;
                z-index: -1;
            }

            .butterfly1 {
                display: none;
            }
        }

        /* animation */
        @keyframes poisonShine {

            0%,
            100% {
                filter: drop-shadow(0 0 0.25rem #bc905b)
            }

            50% {
                filter: drop-shadow(0 0 1rem #fef2f4)
            }
        }

        @keyframes cloud {

            0%,
            100% {
                transform: translateX(0px);
            }

            50% {
                transform: translateX(10px);
            }


        }
    </style>
@endsection

@section('content')
    <div class="container d-flex justify-content-center position-relative">
        <img class="w-50" src="{{ asset('../img/asset/Asset 1.png') }}" alt="logo-maniacxii">
        <img class="mt-lg-3 butterfly" src="{{ asset('../img/asset/Asset 4.png') }}" alt="logo">
        <img class="butterfly1 position-absolute" src="{{ asset('../img/asset/Asset 4.png') }}" alt="logo">
        <img class="moon position-absolute" src="{{ asset('../img/asset/Asset 3.png') }}" alt="moon">
        <img class="cloud position-absolute" src="{{ asset('../img/asset/Asset 15.png') }}" alt="cloud">
        <img class="cloud1 position-absolute" src="{{ asset('../img/asset/Asset 7.png') }}" alt="cloud">
        <img class="branch1 position-absolute" src="{{ asset('../img/asset/Asset 8.png') }}" alt="cloud">
    </div>
    <div class="container-fluid position-relative overflow-hidden">
        <img class="poison position-absolute" src="{{ asset('../img/treasure/poison.png') }}" alt="poison">

        <div class="container my-3 mt-lg-5">
            {{-- <div class="alert alert-info" role="alert">
            Gini dulu ya hehe
            <br>
            <sub>Ps. Req DDD design</sub>
        </div> --}}
            <div class="row">
                <div class="col">
                    <div class="card px-3">
                        <div class="card-header position-relative">

                            <h1 class="penpos-name" style="font-weight: bolder;">{{ $penpos->name }}</h1>
                        </div>
                        <div class="card-body">
                            <div class="qr-section">
                                <div id="reader" class="px-3 pt-4"></div>
                            </div>
                            @if (Session::has('valid'))
                                @if (Session::get('valid') == 'false')
                                    <div class="alert alert-danger" style="">
                                        Masukkan nama tim dan poin !</div>
                                @endif
                            @endif
                            <div class="input-section">
                                <div class="team-select my-2 ">
                                    <label for="team" style="">Nama Tim :</label>
                                    <br>
                                    <input type="text" id='team' value="" disabled>
                                    {{-- <select name="team" id="team" class="select2" required>
                                    <option value="-" selected disabled>- Pilih Team -</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}" id="{{ $team->id }}">
                                            {{ $team->account->name }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                </div>
                                <label for="inputPoin" style="">Input Poin :</label>
                                <br>
                                <input type="number" name="inputPoin" id="inputPoint" style="width: ;" required>
                            </div>
                            <div class="submit-section d-flex justify-content-center py-3">
                                <button class="btn btn-submit" onclick="inputPoin()" id="submitPoint">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="img-branch d-flex flex-column-reverse">
        <img class="position-absolute w-100 align-self-end main-branch" src="{{ asset('../img/asset/Asset 10 fixed.png') }}"
            alt="branch">
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();

            window.setTimeout(function() {
                $(".alert-danger").fadeTo(1000, 0).slideUp(800, function() {
                    $(this).remove();
                });
            }, 2000);
        });

        const Toaster = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        })

        $('#submitPoint').click(function() {
            $('#submitPoint').attr('disabled', 'disabled');
            $('#submitPoint').addClass('btn-submit-disabled');
            setTimeout(function() {
                $('#submitPoint').removeAttr('disabled');
                $('#submitPoint').removeClass('btn-submit-disabled');
            }, 2000);
        });


        const inputPoin = () => {
            const teamName = $('#team').val();
            const poin = $('#inputPoint').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('penpos.input') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_name': teamName,
                    'poin': poin,
                },
                success: function(data) {
                    console.log('Input poin berhasil!' + '\nTeam: ' + teamName +
                        "\nPoin: " + poin);
                    if (data[0].msg == "Success") {
                        Toaster.fire({
                            icon: 'success',
                            animation: true,
                            title: 'Input Poin Berhasil!'
                        });

                        $("#team").val('');
                        $("#inputPoint").val('');
                    } else {
                        Toaster.fire({
                            icon: 'error',
                            animation: true,
                            title: data[0].msg,
                        });

                        $("#team").val('');
                        $("#inputPoint").val('');
                    }
                    setTimeout(window.location.reload(), 1500);
                },
                error: function(data) {
                    console.log(data);
                    window.location.reload();
                }
            });
        }

        //============ QR ==============
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(`Code matched = ${decodedText}`, decodedResult);
            $('#team').attr('value', decodedText);
            navigator.vibrate(200);
            Toaster.fire({
                icon: 'success',
                animation: true,
                title: decodedText+" telah discan";
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:

        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@endsection
