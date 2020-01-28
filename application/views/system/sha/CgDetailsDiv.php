<?php 
	$cgDetails=getCaregiverDetail($guardian_assigned);
?>
<div  class="table-responsive" id="careGiverDiv">
<?php if($guardian_assigned!='0'){?>
    <table class="table about-table" style="margin:0 !important;">
        <tbody class="CGDetails">
       
        <?php if($cgDetails['phone']!=''){
				$phone = $cgDetails['phone'];
			}else{
				$phone = 'na';
			}
			?>

			<tr><td><b>Primary Contact: </b><?=$phone?></td></tr>
            <tr><td><b>Primary Email: </b><?=$cgDetails['email']?></td></tr>
        
        </tbody>
    </table>
    <?php } ?>
</div>