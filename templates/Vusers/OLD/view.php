<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->user_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->user_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->user_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User Name') ?></th>
                    <td><?= h($user->user_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Lastname') ?></th>
                    <td><?= h($user->user_lastname) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Phone') ?></th>
                    <td><?= h($user->user_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Email') ?></th>
                    <td><?= h($user->user_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Username') ?></th>
                    <td><?= h($user->user_username) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Original Password') ?></th>
                    <td><?= h($user->original_password) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Active') ?></th>
                    <td><?= h($user->user_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Deleted') ?></th>
                    <td><?= h($user->user_deleted) ?></td>
                </tr>
                <tr>
                    <th><?= __('Privileges2add') ?></th>
                    <td><?= h($user->privileges2add) ?></td>
                </tr>
                <tr>
                    <th><?= __('Privileges2edit') ?></th>
                    <td><?= h($user->privileges2edit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Privileges2delete') ?></th>
                    <td><?= h($user->privileges2delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($user->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Companyid') ?></th>
                    <td><?= $this->Number->format($user->user_companyid) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Groups') ?></h4>
                <?php if (!empty($user->groups)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Group Name') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->groups as $groups) : ?>
                        <tr>
                            <td><?= h($groups->group_id) ?></td>
                            <td><?= h($groups->group_name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Groups', 'action' => 'view', $groups->group_id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Groups', 'action' => 'edit', $groups->group_id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Groups', 'action' => 'delete', $groups->group_id], ['confirm' => __('Are you sure you want to delete # {0}?', $groups->group_id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
