<div class="page-heading"><h1>Edit new APU company</h1></div>

<div class="container-fluid">
                                
<div data-widget-group="group1">
	<div class="row">
    
    <div class="col-sm-12">
			
			<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
				<div class="panel-body">
							
							<form class="" id="formCreateApuCompany">
                            
                            <div class="form-group width-fifty-left">
								<label for="cname" class="control-label">Company name</label>
								<input type="text" class="form-control" id="cname" name="cname" placeholder="Company name" value="<?=$apu_company['company_name']?>" required>
							</div>
							<div class="form-group width-fifty-right">
								<label for="phone" class="control-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"  placeholder="Phone" value="<?=$apu_company['phone']?>"  required>
							</div>
						   
                          <div class="form-group width-fifty-left">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"  placeholder="Email"  value="<?=$apu_company['email']?>" data-parsley-type="email" required>
                        </div>
                            
                         <div class="form-group width-fifty-right">
                              <label for="name" class="control-label">Contact name</label>
                              <input type="text" class="form-control" id="name" name="name"   value="<?=$apu_company['name']?>" placeholder="Contact name">
                          </div>
              			<input type="hidden" name="id" id="id" value="<?=$apu_company['id']?>" />
							 </form>
						</div>
						
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn-raised btn-primary btn" id="submitBtnCreateApuCompany">Submit</button>
                                    <img src="<?=loadingImagePath()?>" id="formCreateApuCompanyProcess" style="display:none;">
                                </div>
                            </div>
						</div>
                        
				</div>
				
			</div>
		</div>
	</div>
  </div>
  </div>