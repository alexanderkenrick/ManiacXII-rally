@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--  Toaster Sweet Alert  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style type="text/css">
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
            background: #D3D3D3;
            color: #2e2134;
            border: 2px solid #3C486B;
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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="alert alert-info" role="alert">
            Gini dulu ya hehe
            <br>
            <sub>Ps. Req DDD design</sub>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h1 style="font-weight: bolder;">{{ $penpos->name }}</h1>
                    </div>
                    <div class="card-body">
                        @if (Session::has('valid'))
                            @if (Session::get('valid') == 'false')
                                <div class="alert alert-danger" style="">
                                    Masukkan nama tim dan poin !</div>
                            @endif
                        @endif
                        <div class="input-section">
                            <div class="team-select my-2 ">
                                <label for="team" style="">Pilih Tim :</label>
                                <br>
                                <select name="team" id="team" class="select2" required>
                                    <option value="-" selected disabled>- Pilih Team -</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}" id="{{ $team->id }}">
                                            {{ $team->account->name }}
                                        </option>
                                    @endforeach
                                </select>
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
            const teamId = $('#team').val();
            const poin = $('#inputPoint').val();



            $.ajax({
                type: 'POST',
                url: '{{ route('penpos.input') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'team_id': teamId,
                    'poin': poin,
                },
                success: function(data) {
                    console.log('Input poin berhasil!' + '\nTeam: ' + teamId +
                        "\nPoin: " + poin);
                    Toaster.fire({
                        icon: 'success',
                        animation: true,
                        title: 'Input Poin Berhasil!'
                    });

                    $("#team").val('');
                    $("#inputPoint").val('');

                },
                error: function(data) {
                    window.location.reload();
                }
            });


        }
    </script>
@endsection
