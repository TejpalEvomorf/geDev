<?php $step=shaAppCheckStep($formOne['id']); ?>
<!--Personal details-->
<div class="col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">Application details</h2>
        </div>
        <div class="panel-body">
        <div class="text-center">
              <i class="mb-xl material-icons hfa_edit_page_icon">adjust</i>
        </div>
        
        <div class="pull-left">
        <h3 class="mt-n mb-n pt-xs">
        <small class="mt-sm
		<?php if($step>1){?>
        	colorLightgreen">
            Complete
        <?php }else{?>
        	colorBlue">
            Not filled
        <?php } ?>
        </small>
        </h3>
        </div>
        <a  href="<?=site_url()?>houses/application_edit_one/<?php echo $formOne['id']?>" target="_blank" class="m-n btn btn-raised pull-right btn-success">Edit</a>

        </div>
    </div>
</div>
<!--Personal details ENDS-->
