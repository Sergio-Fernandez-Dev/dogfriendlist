<?php 

    $user = $_SESSION['user'];
?>
<form class="form" id="new-spot-form" method="POST" >
    <div class="form--finder-style form form--635">
        <input class="form__field form__field--finder-style form__field--635" type="text" name="title" placeholder="Título" required><br>
            <select class="form__select form__select--635" name="category">
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
    <div class="form form--finder-style form--635">
        <input class="form__field form__field--finder-style form__field--850 form__field--635" id="new-spot-finder-form" type="text" name="address" 
        placeholder="Dirección (opcional)" onkeydown="checkEnterIsPressed(event, 'new-spot')"><br>
        <input class="button button--25rem button--850 button--635 " id="finder-button" type="button" value="Buscar" onclick="findNewSpot()">
    </div>
    <div class="box__separation-line"></div>

    <input type="hidden" name="lat" id="lat" required>
    <input type="hidden" name="lng" id="lng" required>
    <input type="hidden" name="address" id="address" required>
    <input type="hidden" name="user_id" id="user_id" value= <?php echo $user['id']; ?> >
    
    <?php render('components/geolocation/map.php', base_page: false);?>

    <div class="form__textarea-box">
        <div class="form__textarea-column">
            <label class="form__label">Descripción:</label><br>
            <textarea class="textarea" name="description" cols="30" rows="10" required></textarea><br>
        </div>
        <div class="form__button-box">
            <input class="button button--full" type="submit" value="Crear spot" onclick="sendForm()">   
            <input class="button button--red button--spaced" type="button" id="cancel" value="Cancelar">
        </div>
    </div>
</form>