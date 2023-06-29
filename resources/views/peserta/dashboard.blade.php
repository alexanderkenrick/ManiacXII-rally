@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection

@section('content')
    <div class="container">
        <div class="alert alert-info" role="alert">
            Gini dulu ya hehe
          </div>
        <div class="row match-height d-flex justify-content-between">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <p>Nama Tim : <span id="teamName">{{ $team->account->name }}</span></p>
                            <p>Poin Tim : <span id="teamPoint">{{ $currency }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')

@endsection
