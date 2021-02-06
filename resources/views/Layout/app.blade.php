<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>EMS-Employee Mangement System</title>
    @include('Links.links')
    <style>
        .ajax-loader {
      visibility: hidden;
      background-color: rgba(255,255,255,0.7);
      position: absolute;
      z-index: +100 !important;
      width: 100%;
      height:100%;
    }

    .ajax-loader img {
      position: relative;
      top:50%;
      left:50%;
    }
    </style>
</head>
<body>
    @include('Navbar.navbar')

</body>
@include('Links.scripts')
@yield('addscriptscontent')
</html>
