
<div class="index-box">
    <form class="finder" action="/search" method="post">
        <input class="finder__field" type="search">
        <input class="finder__button" type="button" value="Buscar">
    </form>
    <h2 class="index-box__title">Cerca de ti:</h2>
<?php render('geolocation/map.php', false);?>
</div>
