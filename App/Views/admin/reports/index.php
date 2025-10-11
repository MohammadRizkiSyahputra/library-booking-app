<?php
use App\Core\App;
use App\Core\Form\Form;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Generate Reports</h2>

<?php $f = Form::begin('/admin/reports/generate', 'get'); ?>
  <div>
    <label for="start_date">Start Date</label>
    <input type="date" id="start_date" name="start_date" value="<?= date('Y-m-01') ?>" required>
  </div>

  <div>
    <label for="end_date">End Date</label>
    <input type="date" id="end_date" name="end_date" value="<?= date('Y-m-d') ?>" required>
  </div>

  <?= Form::button('Generate Report') ?>
<?php Form::end(); ?>

<p><a href="/admin">Back to Admin Dashboard</a></p>
