 <div class="widget-heading" style="padding-left:0;">Note HISTORY</div>

               <div class="widget-body" style="border-bottom:0px;"> 

					<?php   if(!empty($note)){  ?>
                    <input type="checkbox" class="read-more-state" id="extraNotes" />					
					<ul class="timeline read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;" id="allhfanote">
					<?php   foreach($note as $valK=>$val): ?>

				



                        <li style="padding-bottom: 0;" class="timeline-grey <?php if($valK>2){?>read-more-target<?php } ?>">

                            <div class="timeline-icon"><i class="material-icons">alarm</i></div>

                            <div class="timeline-body">

                                <div class="timeline-header">

                                    <span data-id="<?php echo @$val['sha_id'] ?>" data-postid="<?php echo @$val['id']?>" data-toggle="modal" data-target="#model_hfafamilynoteedit" class="notes-list-head author tyuedit" onclick="$('#clientfaAgreementseditParent').hide();"><?php  echo  $val['note_title']?></span>

                                    <span class="date"><?php  if($val['note_date']!='0000-00-00'){echo  date('d M Y',strtotime($val['note_date']));}else{echo  date('d M Y',strtotime($val['note_created']));}?>
                                    <?php
                                    	if($val['employee']!='0')
										{
											$emp=employee_details($val['employee']);
											echo ' by '.$emp['fname'];
										}
									?>
                                    </span>

                                    <span class="note-badge"> <i style="font-size: 16px; margin-left:20px;" class="material-icons">attach_file</i><?php echo @$val['totaldoc']?></span>

                                    <span data-pid="<?php echo @$val['sha_id'] ?>" data-id="<?php echo @$val['id']?>" class="note-delete notdel">×</span>

                                </div>

                            </div>

                        </li>     

<?php endforeach; ?>	
</ul>

<?php 
if(count($note)>3){?>
<label for="extraNotes" class="read-more-trigger">See all</label>
<?php
  }}
else {?>

					<div class="m-n form-group" style="margin-left: -16px !important;">

						  

							 Notes history not found 

					  </div>



<?php } ?>	

                </div>

				<script>

				$(document).ready(function(){ 


	$("label[for='extraNotes']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraNotes']").text('See less');
		else
			$("label[for='extraNotes']").text('See all');
			
			},500);
		
	});

				$('.tyuedit').on('click',function(){

					

	var id=$(this).data('id');

	var noteid=$(this).data('postid');

	$('#updateHfaNotesFamilyFormedit').html('');

	$('#clientfaAgreementsedit').html('');

	$('#notesidedit').val(noteid);

	$.ajax({

		url:site_url+'sha/noteContent/'+id+'/'+noteid,

		success:function(data)

			{

				$('#updateHfaNotesFamilyFormedit').html(data);
				$('#notes_date').datepicker({
							orientation: "bottom",
							todayHighlight: true,
							format:'dd/mm/yyyy',
							autoclose:true
						});
			}

		});
		$.ajax({

		url:site_url+'sha/notedocumentlist/'+id+'/'+noteid,

		success:function(data)

			{

				$('#clientfaAgreementsedit').html(data);

				if($('#clientfaAgreementsedit div.panel-body > p').length>0)

					$('#clientfaAgreementseditParent').show();	

			}

		});

		

	

})

		$(".notdel").click(function(){

	var id =$(this).data('id');

	var pid =$(this).data('pid');

	bootbox.dialog({

				message: "Are you sure you wish to delete this note?",

				title: "Delete",

				buttons: {

					  danger: {

						label: "Delete",

						className: "btn-danger",

						callback: function() {



								$.ajax({

		url:site_url+'sha/deletenote/'+id,

		success:function(data)

			{

				  allnote(pid);

				 notiPop('success','Note deleted successfully','');

			//	$('#updateHfaNotesFamilyFormedit').html(data);

			}

		});



							}

						}

					}

				});



	

	

})



				})

				</script>

			