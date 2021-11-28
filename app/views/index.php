<div class="box">
    <form class="form form--finder-style" action="/search" method="post">

        <input class="form__field form__field--finder-style" id="index-finder" type="search" placeholder="Madrid">
        <select class="form__select form__select--finder-style">
            <option class="form__option" selected value="0">Tipo de spot</option>
            <option class="form__option" value="1">Todos</option>
            <option class="form__option" value="2">Parques y zonas verdes</option>
            <option class="form__option" value="3">Alojamiento</option>
            <option class="form__option" value="4">Bares y restaurantes</option>
            <option class="form__option" value="5">Tiendas de mascotas</option>
            <option class="form__option" value="6">Clínicas veterinarias</option>
            <option class="form__option" value="7">Guarderías caninas</option>
            <option class="form__option" value="8">Otros</option>
        </select>
        <input class="button" type="button" value="Buscar">
    </form>
    <span class="box__separation-line"></span>
    <h2 class="h2">Cerca de ti:</h2>
<?php render('components/geolocation/map.php', false);?>
</div>
