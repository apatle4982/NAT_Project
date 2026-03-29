<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeMaster $chargeMaster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Charge Master'), ['action' => 'edit', $chargeMaster->cgm_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Charge Master'), ['action' => 'delete', $chargeMaster->cgm_id], ['confirm' => __('Are you sure you want to delete # {0}?', $chargeMaster->cgm_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Charge Master'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Charge Master'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="chargeMaster view content">
            <h3><?= h($chargeMaster->cgm_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Cgm Title') ?></th>
                    <td><?= h($chargeMaster->cgm_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cgm Type') ?></th>
                    <td><?= h($chargeMaster->cgm_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cgm Id') ?></th>
                    <td><?= $this->Number->format($chargeMaster->cgm_id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
