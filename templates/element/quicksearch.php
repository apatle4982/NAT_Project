<?php if(!$user_Gateway){ ?>
<div class="input-container-floating -floating search-section">
    <?= $this->Form->create(null, ['horizontal'=>true, 'action'=>'/master-data/advance-search']) ?>
        <input type="text" name="NATFileNumber" class="form-control" id="NATFileNumber" aria-required="true" Placeholder="NAT File Number">
        <input type="text" name="PartnerFileNumber" class="form-control" id="PartnerFileNumber" aria-required="true" Placeholder="Partner File Number">
        <input type="text" name="Grantors" class="form-control" id="mortgagorgrantor" aria-required="true" Placeholder="Grantor(s)">
        <input type="text" name="State" class="form-control" id="State" aria-required="true" Placeholder="State">
        <input type="text" name="County" class="form-control" id="County" aria-required="true" Placeholder="County">
        <div class="submit">
            <input type="submit" id="searchBtnId" class="btn btn-success" style="padding:3px 10px!important;" value="Quick Search">
            <?php  //echo $this->Html->link(__('Advance Search'), ['controller' => 'master-data', 'action'=>'advance-search'],['class'=>'btn btn-success']); ?>
        </div>
    <?= $this->Form->end() ?>
</div>
<?php } ?>