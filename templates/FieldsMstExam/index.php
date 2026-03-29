<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FieldsMst> $fieldsMst
 */
?>
  

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">This section shows the overall listing of the All Users.</h5>
              
            </div> 
            <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-bordered" style="width:100%">
                <thead>
                <tr>
                    <!-- <th><?php //= __('Id') ?></th> -->
                    <th><?= __('Title') ?></th>
                     
                </tr>
            </thead>
            <tbody> 

                <?php  foreach($fieldSections as $fieldSection):  ?>
                            
                    <tr class="odd map-fld-title"> 
                        <td><?= h($fieldSection['section_name']) ?></td> 
                    </tr>
                     <?php    foreach($fieldSection['fields_mst'] as $fieldsMst): ?>

                        <tr>
                            <!-- <td><?php //= $this->Number->format($fieldsMst['fm_id']) ?></td> -->
                            <td><?= h($fieldsMst['fm_title']) ?></td> 
                        </tr>
                <?php endforeach; 
                endforeach; ?>
         
            </tbody>      
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
 