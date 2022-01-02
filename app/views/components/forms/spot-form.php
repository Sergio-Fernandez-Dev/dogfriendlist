<div class="form" id="new-spot-form" >
    <div class="form--finder-style">
        <input class="form__field form__field--finder-style" type="text" name="title" placeholder="Título" required><br>
        <select class="form__select" name="category-new-spot">
                <option class="form__option" selected value="2">Parques y zonas verdes</option>
                <option class="form__option" value="3">Playas</option>
                <option class="form__option" value="4">Alojamiento</option>
                <option class="form__option" value="5">Bares y restaurantes</option>
                <option class="form__option" value="6">Tiendas de mascotas</option>
                <option class="form__option" value="7">Clínicas veterinarias</option>
                <option class="form__option" value="8">Guarderías caninas</option>
                <option class="form__option" value="9">Otros</option>
            </select><br>
    </div>
    <div class="form form--finder-style">
        <input class="form__field form__field--finder-style" id="new-spot-finder-form" type="text" name="address" placeholder="Dirección (opcional)" onkeydown="checkEnterIsPressed(event, 'new-spot')"><br>
        <input class="button button--25rem" id="finder-button" type="button" value="Buscar" onclick="findNewSpot()">
    </div>
    <div class="box__separation-line"></div>
    
    <?php render('components/geolocation/map.php', base_page: false);?>

    <div class="form__textarea-box">
        <div class="form__textarea-column">
            <label class="form__label">Descripción:</label><br>
            <textarea class="textarea" name="description" cols="30" rows="10" required></textarea><br>
        </div>
        <div class="form__button-box form__button-box--column">
            <input class="button" type="submit" name="submit" value="Crear spot">   
            <input class="button button--red" type="submit" name="cancel" value="Cancelar">
        </div>
    </div>
</div>

