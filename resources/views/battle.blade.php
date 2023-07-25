@extends('layouts.app')


@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style type="text/css">
    div{
        border-radius: 5px; 
    }
    #red{
        background-color: red;
        padding: 10px;
    }
    #blue{
        background-color: blue;
        padding: 30px;
    }
    .salvos-container{
        margin: 20px;
        background-color: white;
        height: 500px;
    }
    .main-container{
        padding: 10px 50px;
    }
    .desc1{
        background-color: bisque;
        width: 100%;
    }
    .desc2{
        background-color: azure;
        width: 100%;
        margin-top: 30px;
        height: 390px;
    }
    .select2{
        width: 100%;
        margin:20px 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="main-container">
    <div class="row">
        <div id="red" class ="col-8">
          <div class="salvos-container">
            column
          </div>
        </div>
        <div id="blue" class="col">
          <div class="desc1">
            <label for="team_name">Nama Tim: </label>
            <select class="select2" name="team_name">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
              </select>
          </div>
          <div class="desc2">

          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
//In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection