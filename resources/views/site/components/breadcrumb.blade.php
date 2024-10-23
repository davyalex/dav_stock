<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a id="goBack" href="#">Retour</a></li>
                <li><a href="{{route('accueil')}}">Accueil</a></li>
                <li class="active">@yield('title') </li>
            </ul>
        </div>
    </div>
</div>

<script>
    // go to back
    document.getElementById('goBack').addEventListener('click', function() {
        window.history.back();
        setTimeout(function() {
            location.reload();
        }, 500);
    });
</script>