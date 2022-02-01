<div class="box">
<form class="form" id="new-spot-form" method="POST" onkeydown="return event.key != 'Enter';">
    <div class="form--finder-style" id="finder-form">
        <input class="form__field form__field--finder-style" id="address" name="address"
        type="text" placeholder="Buscando ubicación" onkeydown="checkEnterIsPressed(event, 'index')">
        <select class="form__select form__select--finder-style" id="finder-category" name="category" placeholder="Todos los spots">
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
        <input class="button" id="finder-button" type="button" value="Buscar" onclick="prepareFinderQuery(true)">
    </div>
    <span class="box__separation-line"></span>
    <h2 class="h2">Cerca de ti:</h2>
<?php render('components/geolocation/map.php', false);?>
</div>