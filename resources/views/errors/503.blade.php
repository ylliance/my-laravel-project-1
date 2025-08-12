<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Argon Dashboard') }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <link type="text/css" href="{{ asset('argon') }}/css/error.css" rel="stylesheet">

</head>

<body>
    {{-- <div class="not-found-wrap text-center"> --}}
    <div class="div-error">
        <form action="active" method="post">

            <h1 class="text-60 c-white">

                <i class="fas fa-skull-crossbones"></i>
            </h1>

            <p class="text-36 subheading mb-3 c-white">Licence de-activated!</p>
            <p class="mb-4  text-muted text-20">We think your licence is de-active, please active to continue.</p>
            <div class="form-group">
                <label for="usr"><b> Licence Number:</b></label>
                <input type="text" value="{{old('license_code')}}" class="form-control" name="license_code" required>
            </div>
            <div class="form-group">
                <label for="pwd"><b> Name:</b></label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-lg btn-success">Active</button>
            <a href="https://support.ondemandscripts.com/" class="btn btn-lg btn-warning"> Contact
                Support</a>

            @if(app('request')->input('status'))
            <p class="mb-4   text-20 c-yellow">{{app('request')->input('status')}}</p>
            @endif
        </form>
    </div>
    {{-- </div> --}}
    <div class="waveWrapper waveAnimation">

        <div class="waveWrapperInner bgTop">
            <div class="wave waveTop">
            </div>
        </div>
        <div class="waveWrapperInner bgMiddle">
            <div class="wave waveMiddle">
            </div>
        </div>
        <div class="waveWrapperInner bgBottom">
            <div class="wave waveBottom">
            </div>
        </div>
    </div>
</body>

</html>
