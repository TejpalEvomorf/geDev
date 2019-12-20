<?php
foreach($students as $student)
{
  echo '
  <div class="warningRowParent">
  <div class="warningRow">
  <div class="warningCol warningColName" style="color:#424242; font-weight:normal;">'.$student['fname'].' '.$student['lname'].'
  </div>
  </div>
</div>';
}
?>

