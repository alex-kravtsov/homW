<h2 class="rp-title">Объект <?php echo $object->object_id ?></h2>

<p class="rp-district"><b>Город: <?php echo $object->district ?></b></p>

<hr />

<p class="rp-about"><b>Об апартаментах:</b></p>

<table class="rp-properties">

  <thead>
    <tr>
      <th>Комнат:</th>
      <th>Квадратная площадь:</th>
      <th>Этаж:</th>
      <th>Стоимость:</th>
      <th>Цена за метр:</th>
    </tr>
  </thead>

  <tbody>

    <tr>

      <td><?php echo $object->rooms ?></td>
      <td><?php echo $object->square ?></td>
      <td><?php echo $object->floor ?></td>
      <td><?php echo number_format($object->price, 2, '.', '') ?> €</td>

      <?php if(is_numeric($object->price_per_metr) ): ?>
        <td><?php echo number_format($object->price_per_metr, 2, '.', '') ?> €</td>
      <?php else: ?>
        <td><?php echo $object->price_per_metr ?></td>
      <?php endif ?>

    </tr>

  </tbody>

</table>

<hr />

<div class="rp-description"><?php echo $object->description ?></div>
