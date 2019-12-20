   
        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Transport information</h2>
            </div>
            <div class="panel-body">
            		<button class="btn-raised btn-primary btn btn-sm" style="margin-bottom: 40px;" onclick="hfaTransportInfoPopContent(<?=$formOne['id']?>,'add');">Add Transport Info</button> 
                <div id="transportListDiv" style="padding-left:20px;">
                    <?php $this->load->view('system/hfa/transportList');?>
                </div>
            </div>
        </div> 
        
        
        
        <!--Add new incident Start-->
        <div class="modal fade" id="model_hfaTransportInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title"><span id="model_hfaTransportInfo_titlePart">Add new</span>  Transport information</h2>
                        </div>
                        
                        <div class="modal-body">
                            <form id="hfaTransportInfo_form"></form>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-raised" id="hfaTransportInfo_submit">Submit</button>
                            <img src="<?=loadingImagePath()?>" id="hfaTransportInfo_process" style="margin-right:16px;display:none;">
                        </div>
                    </div><!-- /.modal-content -->
                </div>
        </div><!-- /.modal -->
        <!--Add new incident end-->   
