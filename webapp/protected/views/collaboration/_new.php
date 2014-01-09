<!-- Modal -->
<div id="addCollaboratorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Collaborator</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" action="/collaboration/addUser" method="post">
      <input type="hidden" name="studyId" value="<?php echo $study->id ?>">
    <!--
    <div>&nbsp;</div>
    <fieldset>
    <div class="control-group">
      <label class="control-label" for="invitedEmailOrName">Email or Name</label>
      <div class="controls">
        <input id="invitedEmailOrName" name="invitedEmailOrName" placeholder="Enter an email address or a user name" class="input-xlarge" required="" type="text" autocomplete="off">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="role">Role</label>
      <div class="controls">
        <select id="role" name="role" class="input-xlarge" required="">
           <option value="">---</option>
           <option value="admin">Admin</option>
           <option value="write">Collaborator</option>
           <option value="read">View Only</option>
        </select>
        <input type="hidden" name="studyId" value="<?php echo $study->id ?>">
      </div>
    </div>
    </fieldset>
  -->
  <table class="table table-striped table-bordered table-condensed">
    <tr>
      <th>&nbsp;</th>
      <th>User</th>
      <th>Role</th>
    </tr>
  <?php $ctr = 0; ?>
  <?php foreach ($users as $user) { ?>
    <tr>
      <td style="text-align:center"><input type="checkbox" name="users[<?php echo $ctr ?>][id]" value="<?php echo $user->id ?>"></td>
      <td><?php echo $user->getName() ?></td>
      <td>
        <label class="radio inline" for="radios-0">
          <input type="radio" name="users[<?php echo $ctr ?>][role]" value="admin">Admin
        </label>
        <label class="radio inline" for="radios-1">
          <input type="radio" name="users[<?php echo $ctr ?>][role]" value="default" checked="checked">Default
        </label>
      </td>
    </tr>
    <?php $ctr++; ?>
  <?php } ?>
  </table>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary">Add Collaborator(s)</button>
    </form>
  </div>
  
</div>

<script>
$(document).ready(function() {
  /*
  $('#invitedEmailOrName').typeahead({
    source: function (query, process) {
        return $.get('/collaboration/autoComplete', { query: query }, function (data) {
            return process(data.options);
        });
    }
});
*/

});

</script>

