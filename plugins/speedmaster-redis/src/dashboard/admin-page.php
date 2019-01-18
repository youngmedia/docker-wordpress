<?php
global $smaddons;
function cvalue($key) {
  if (defined($key))
    if (constant($key) === true)
      return 'true';
    else if (constant($key) === false)
      return 'false';
    else
      return esc_attr(constant($key));
  else
    return '<em>N/A</em>';
}
?>
<div class="wrap">
  <div class="container">


    <div class="row mb-4">
      <div class="col-8">
        <h2>Speedmaster <span class="text-muted">with in-memory Redis cache.</span></h2>
      </div>
      <div class="col-4 text-right">
        <h2 class="text-muted"><?= count($cached_pages); ?> cached pages</h2>
      </div>
    </div>

    <table class="table table-striped">
      <tbody>
        <?php foreach ($smaddons as $addon): ?>
        <tr>
          <th><?=esc_attr($addon['title']); ?></th>
          <td>
            <?=esc_attr($addon['description']); ?><br>
            <small><?=esc_attr($addon['file_path']); ?></small>
          </td>
          <td class="text-right">
            <?php 
            if (true == $addon['activated']) 
              echo 'activated'; 
            else
              echo 'not active';
            ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="row">
      <div class="col-12">
        <h5 class="mt-3 mb-3">Config variables</h5>
        <table class="table table-striped">
          <thead>
            <th>VARIABLE</th>
            <th>VALUE</th>
          </thead>
          <tbody>
            <?php foreach ($smaddons as $addon): ?>
              <?php if (isset($addon['vars'])): foreach($addon['vars'] as $var): ?>
              <tr>
                <td><?php echo $var; ?></td>
                <td><?php echo cvalue($var);?></td>
              </tr>
              <?php endforeach; endif; ?>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>


  </div>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style type="text/css">
.wrap {
  padding-top: 60px;
}

table.table tr td, table.table tr th {
  vertical-align: middle;
  font-size: 13px;
}

/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  margin-top: 6px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ecc71;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2ecc71;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.total_cached_pages {
  font-size: 20px;
}
</style>