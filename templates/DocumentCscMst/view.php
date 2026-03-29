<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentCscMst $documentCscMst
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document Csc Mst'), ['action' => 'edit', $documentCscMst->Id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document Csc Mst'), ['action' => 'delete', $documentCscMst->Id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentCscMst->Id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document Csc Mst'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document Csc Mst'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="documentCscMst view content">
            <h3><?= h($documentCscMst->Id) ?></h3>
            <table>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= $documentCscMst->has('State') ? $this->Html->link($documentCscMst->State->id, ['controller' => 'States', 'action' => 'view', $documentCscMst->State->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Name') ?></th>
                    <td><?= h($documentCscMst->document_type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($documentCscMst->Id) ?></td>
                </tr>
                <tr>
                    <th><?= __('County Id') ?></th>
                    <td><?= $documentCscMst->County_id === null ? '' : $this->Number->format($documentCscMst->County_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Id') ?></th>
                    <td><?= $documentCscMst->document_type_id === null ? '' : $this->Number->format($documentCscMst->document_type_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $this->Number->format($documentCscMst->is_active) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
