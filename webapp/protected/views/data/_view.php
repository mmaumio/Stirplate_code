  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo $data->name ?></h3>
  </div>
  <div class="modal-body">

      <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
          <?php foreach ($data->columnMappings as $mapping) { ?>
            <th><?php echo $mapping->originalLabel ?></th>
          <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row) { ?>
          <tr>
          <?php foreach ($row as $column) { ?>
            <td><?php echo $column ?></td>
          <?php } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>