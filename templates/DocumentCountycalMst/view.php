<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentCountycalMst $documentCountycalMst
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document Countycal Mst'), ['action' => 'edit', $documentCountycalMst->Id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document Countycal Mst'), ['action' => 'delete', $documentCountycalMst->Id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentCountycalMst->Id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document Countycal Mst'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document Countycal Mst'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="documentCountycalMst view content">
            <h3><?= h($documentCountycalMst->Id) ?></h3>
            <table>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= $documentCountycalMst->has('State') ? $this->Html->link($documentCountycalMst->State->id, ['controller' => 'States', 'action' => 'view', $documentCountycalMst->State->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('State Name') ?></th>
                    <td><?= h($documentCountycalMst->State_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('County Name') ?></th>
                    <td><?= h($documentCountycalMst->County_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Name') ?></th>
                    <td><?= h($documentCountycalMst->document_type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($documentCountycalMst->Id) ?></td>
                </tr>
                <tr>
                    <th><?= __('County Id') ?></th>
                    <td><?= $documentCountycalMst->County_id === null ? '' : $this->Number->format($documentCountycalMst->County_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Id') ?></th>
                    <td><?= $documentCountycalMst->document_type_id === null ? '' : $this->Number->format($documentCountycalMst->document_type_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $this->Number->format($documentCountycalMst->is_active) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
