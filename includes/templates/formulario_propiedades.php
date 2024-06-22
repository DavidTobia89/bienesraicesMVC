<fieldset>
    <legend>Informacion General</legend>
    <label for="titulo">Título:</label>
    <input id="titulo" name="propiedad[titulo]" type="text" placeholder="Título Propiedad" value="<?php echo s($propiedad->titulo); ?>">
    <label for="precio">Precio: </label>
    <input id="precio" name="propiedad[precio]" type="number" placeholder="Precio " value="<?php echo s($propiedad->precio); ?>">
    <label for="imagen">Imagen:</label>
    <input id="imagen" type="file" accept="image/jpeg, image/png" name="propiedad[imagen]">
    <?php if ($propiedad->imagen): ?>
        <img src="../../imagenes/<?php echo s($propiedad->imagen); ?>" class="imagen-small">
    <?php endif ?>
    <label for="descripcion">Descripción:</label>
    <textarea name="propiedad[descripcion]" id="descripcion" ><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>
<fieldset>
    <legend>Informacion sobre la Propiedad</legend>
    <label for="habitaciones">Habitaciones:</label>
    <input id="habitaciones" name="propiedad[habitaciones]" type="number" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">
    <label for="wc">Baños:</label>
    <input id="wc" type="number" name="propiedad[wc]wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">
    <label for="estacionamiento">Estacionamiento:</label>
    <input id="estacionamiento" name="propiedad[estacionamiento]estacionamiento" type="number" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
    
</fieldset>
<fieldset>
    <legend>Vendedor</legend>

    <select name="propiedad[vendedorID]" id="nombre_vendedor">
        <option selected value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor) { ?>
            <option <?php echo $propiedad->vendedorID === $vendedor->id ? 'selected' : '' ?> value="<?php echo s($vendedor->id); ?>"><?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
        <?php  } ?>
    </select>

</fieldset>