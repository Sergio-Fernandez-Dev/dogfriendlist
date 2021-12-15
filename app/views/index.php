<div class="box">
    <div class="form form--finder-style" id="finder-form" action="#">
        <input class="form__field form__field--finder-style" id="finder-input" name="place" type="text" placeholder="Buscando ubicación">
        <select class="form__select form__select--finder-style" id="finder-category" name="category">
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
        <input class="button" id="finder-button" type="button" value="Buscar" onclick="prepareFinderQuery()">
    </div>
    <span class="box__separation-line"></span>
    <h2 class="h2">Cerca de ti:</h2>
<?php render('components/geolocation/map.php', false);?>
</div>
