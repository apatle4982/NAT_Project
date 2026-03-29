<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				 
				<div class="ibox-content">
					
						<center>
							<?php if($is_fileExist){ ?>
								<object style="width:100%; height:100%;">
									<embed src="<?= $this->Url->build('/'.$pdf_fullpath, ['fullBase' => true]) ?>" style="width:100%; min-width:350px; height:768px;" type='application/pdf'>
								</object>
                                <br><br>
							    <input type="button" class="btn btn-primary m-t" value="Close This Window" onclick="self.close()"/>
							<?php }else{
								
								$myText = 'Please be advised that this document is not yet available for viewing.<br> Please check back soon or email '.CUSTOMER_EMAIL.' for status.';
								echo $this->Text->autoLinkEmails($myText, ['escape'=>false]);
							?>

							<br><br>
							<input type="button" class="btn btn-primary m-t" value="Close This Window" onclick="self.close()"/>
							
						<?php } ?>
						</center>
					
				</div>
			</div>
		</div>
	</div>
</div>
