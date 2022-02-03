<div class="box">
    <div class="form form--finder-style form--850 form--615" id="finder-form">
        <input class="form__field form__field--finder-style form__field--850 form__field--615{" id="fav-address" name="fav-address"
        type="text" placeholder="Buscar por localización" onkeydown="checkEnterIsPressed(event, 'favs')">
        <select class="form__select form__select--finder-style form__select--850 form__select--615" id="fav-category" name="fav-category" onchange="hideMarkers()">
            <option class="form__option" selected value="1">Todos los spots</option>
            <option class="form__option" value="2">Parques y zonas verdes</option>
            <option class="form__option" value="3">Playas</option>
            <option class="form__option" value="4">Alojamiento</option>
            <option class="form__option" value="5">Bares y restaurantes</option>
            <option class="form__option" value="6">Tiendas de mascotas</option>
            <option class="form__option" value="7">Clínicas veterinarias</option>
            <option class="form__option" value="8">Guarderías caninas</option>
            <option class="form__option" value="9">Otros</option>
        </select>
        <input class="button button--615" id="finder-button" type="button" value="Buscar" onclick="findFavsFromAddres()">
    </div>
    <span class="box__separation-line"></span>
    <h2 class="h2">Tus spots favoritos:</h2>
<?php render('components/geolocation/map.php', false);?>
</div>