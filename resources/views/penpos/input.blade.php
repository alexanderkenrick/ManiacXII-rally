@extends('layouts.app')

@section('styles')
    {{-- Bootstrap Select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style type="text/css">
        .select2 {
            width: 100%;
            max-width: 200px;
        }

        .submit-section{
            
        }
        .submit-section .btn-submit{
            width: 60%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="alert alert-info" role="alert">
            Gini dulu ya hehe
          </div>
        <div class="card">
            <div class="card-header">
                <span id="namapos">Nama Pos</span>
            </div>
            <div class="card-body">
                <div class="input-section">
                    <div class="team-select my-2 ">
                        <label for="team" style="width: 80px;">Pilih Tim :</label>
                        <select name="team[]" id="team" class="select2">
                            <option value="-" selected disabled>- Pilih Team -</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <label for="inputPoin" style="width: 80px;">Input Poin :</label>
                    <input type="text" name="inputPoin" id="inputPoin" style="width: 200px;">
                </div>
                <div class="submit-section d-flex justify-content-center py-3">
                    <button class="btn btn-primary btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection
