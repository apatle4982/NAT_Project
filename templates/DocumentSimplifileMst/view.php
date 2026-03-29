<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentSimplifileMst $documentSimplifileMst
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document Simplifile Mst'), ['action' => 'edit', $documentSimplifileMst->Id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document Simplifile Mst'), ['action' => 'delete', $documentSimplifileMst->Id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentSimplifileMst->Id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document Simplifile Mst'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document Simplifile Mst'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="documentSimplifileMst view content">
            <h3><?= h($documentSimplifileMst->Id) ?></h3>
            <table>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= $documentSimplifileMst->has('State') ? $this->Html->link($documentSimplifileMst->State->id, ['controller' => 'States', 'action' => 'view', $documentSimplifileMst->State->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Name') ?></th>
                    <td><?= h($documentSimplifileMst->document_type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($documentSimplifileMst->Id) ?></td>
                </tr>
                <tr>
                    <th><?= __('County Id') ?></th>
                    <td><?= $documentSimplifileMst->County_id === null ? '' : $this->Number->format($documentSimplifileMst->County_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document Type Id') ?></th>
                    <td><?= $documentSimplifileMst->document_type_id === null ? '' : $this->Number->format($documentSimplifileMst->document_type_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $this->Number->format($documentSimplifileMst->is_active) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
