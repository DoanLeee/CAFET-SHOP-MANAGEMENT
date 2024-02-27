<!DOCTYPE html>
<html lang="en">

<head>


    @include("Admin.Share.css")

</head>

<body>
    @include("Admin.Share.header")
    @include("Admin.Share.menu")


    <main id="main" class="main">
        @yield('noi_dung')
    </main>


    {{-- <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer> --}}

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    @include("Admin.Share.js")
    @yield("js")



</body>

</html>
