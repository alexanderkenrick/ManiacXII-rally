@extends('layouts.app')

@section('styles')
    <style type="text/css">
        label {
            color: #f6f1e9;
        }

        .card-header {
            color: #f6f1e9;
        }

        input.form-control {
            background: #a5d7e8;
            border: 2px solid #19376d;
        }

        input.form-control:focus {
            background: #f6f1e9;
        }

        .btn-login {
            background: #19376d;
            letter-spacing: 3px;
            color: #fef2f4;
        }

        .btn-login:hover {
            background: #a5d7e8;
            color: #0b2447;
            filter: drop-shadow(-1px 2px 0.25rem #a5d7e8);
            transition: 0.2s ease-in;
        }


        .header-login {
            letter-spacing: 5px;
        }

        .butterfly {
            right: 4rem;
            width: 5%;
            top: 1em;
        }

        .branch {
            width: 80%;
            position: absolute;
            right: 0;
            margin-top: 3em;
        }

        .moon {
            width: 20em;
            top: 25em;
            left: 3em;
        }

        .cloud {
            top: 36em;
            width: 20em;
            left: 5em;
        }

        .star1 {
            position: absolute;
            top: 10em;
            left: 7em;
            animation: 5s infinite alternate shine;
        }

        .star2 {
            position: absolute;
            bottom: 7em;
            right: 15em;
            animation: 5s infinite alternate-reverse shine;
        }

        .star3 {
            position: absolute;
            bottom: -10em;
            left: 20%;
            animation: 5s infinite ease-in-out shine;
        }

        .cloud1 {
            position: absolute;
            width: 15em;
            right: 5em;
            top: 20em;
            transform: scaleX(-1);

        }

        @media (max-width:960px) {
            .moon {
                right: 2em;
                top: 8em;
                width: 15em;
            }

            .cloud {
                top: 16em;
                left: 3em;
                width: 15em;
            }

            .star1 {
                top: 7em;
                left: 3em;
            }

            .star2 {
                right: 7em;
            }

            .cloud1 {
                right: 1em;
                top: 12em;
                width: 12em;
            }
        }

        @media (max-width:760px) {
            .moon {
                left: -10px;
                top: 5em;
            }

            .cloud {
                top: 13em;
                left: 1em;
                width: 13em;
            }

            .star1 {
                top: 5em;
            }

            .star2 {
                right: 3em;
            }

            .star3 {
                left: 6em;
            }

            .cloud1 {
                right: 1em;
                top: 15em;
                width: 10em;
            }
        }

        @media (max-width:490px) {
            .moon {
                left: -20px;
                width: 8em;
            }

            .cloud {
                top: 9em;
                width: 7em;
                left: -10px;
            }

            .star1 {
                top: 2em;
                width: 1.5em;
            }

            .star2 {
                width: 1.5em;
                right: 1em;
            }

            .star3 {
                width: 1.5em;
            }

            .cloud1 {
                width: 6em;
                display: none;
            }
        }

        @keyframes shine {

            0%,
            100% {
                filter: drop-shadow(0 0 0.5rem #ffd93d)
            }

            50% {
                filter: drop-shadow(0 0 1rem #ffd93d)
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid position-relative">
        <img class="star1" src="{{ asset('../img/asset/Asset 5.png') }}" alt="">
        <img class="star2" src="{{ asset('../img/asset/Asset 5.png') }}" alt="">
        <img class="star3" src="{{ asset('../img/asset/Asset 5.png') }}" alt="">
        <img class="moon position-absolute" src="{{ asset('../img/asset/Asset 6.png') }}" alt="moon">
        <img class="cloud position-absolute" src="{{ asset('../img/asset/Asset 15.png') }}" alt="cloud">
        <img class="cloud1" src="{{ asset('../img/asset/Asset 11.png') }}" alt="">
        <div class="container position position-relative">
            <div class="d-flex justify-content-center my-lg-4 my-3 position-relative">
                <img class="butterfly position-absolute" src="{{ asset('../img/asset/Asset 4.png') }}" alt=""
                    srcset="">
                <img class="w-75" src="{{ asset('../img/asset/Asset 1.png') }}" alt="maniac-xii">
            </div>
            <div class="row justify-content-center">
                <div class="col-10 col-md-8">
                    <div class="card p-2">
                        <div class="card-header">
                            <h1 class="header-login">{{ __('Login') }}</h1>
                        </div>

                        <div class="card-body ps-lg-5">
                            @if (Session::has('loginError'))
                                <div class="alert alert-danger" style="padding:8px 8px;margin:16px 0 16px 0 ;">
                                    {{ Session::get('loginError') }}</div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right text-lg-center">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right text-lg-center">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0 d-flex justify-content-center">
                                    <div
                                        class="col-md-8 offset-0 offset-md-0 d-flex justify-content-center flex-column sm-flex-column">
                                        <button type="submit" class="btn btn-login">
                                            {{ __('Login') }}
                                        </button>
                                        {{-- <br>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="branch" src="{{ asset('../img/asset/Asset 14.png') }}" alt="">
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            window.setTimeout(function() {
                $(".alert-danger").fadeTo(800, 0).slideUp(650, function() {
                    $(this).remove();
                });
            }, 2500);
        });
    </script>
@endsection
