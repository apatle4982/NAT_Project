<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyMst $companyMst
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Company Mst'), ['action' => 'edit', $companyMst->cm_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Company Mst'), ['action' => 'delete', $companyMst->cm_id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyMst->cm_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Company Mst'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Company Mst'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="companyMst view content">
            <h3><?= h($companyMst->cm_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Cm Sales Representative') ?></th>
                    <td><?= h($companyMst->cm_sales_representative) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Comp Name') ?></th>
                    <td><?= h($companyMst->cm_comp_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Proper Name') ?></th>
                    <td><?= h($companyMst->cm_proper_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm First Name') ?></th>
                    <td><?= h($companyMst->cm_first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Last Name') ?></th>
                    <td><?= h($companyMst->cm_last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Url') ?></th>
                    <td><?= h($companyMst->cm_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Logo') ?></th>
                    <td><?= h($companyMst->cm_logo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm City') ?></th>
                    <td><?= h($companyMst->cm_City) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm State') ?></th>
                    <td><?= h($companyMst->cm_State) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Zip') ?></th>
                    <td><?= h($companyMst->cm_zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm County') ?></th>
                    <td><?= h($companyMst->cm_County) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Phone') ?></th>
                    <td><?= h($companyMst->cm_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Fax') ?></th>
                    <td><?= h($companyMst->cm_fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Email') ?></th>
                    <td><?= h($companyMst->cm_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Partner') ?></th>
                    <td><?= h($companyMst->cm_partner) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm OwnedBy') ?></th>
                    <td><?= h($companyMst->cm_ownedBy) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Partner Cmp') ?></th>
                    <td><?= h($companyMst->cm_partner_cmp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Partner Type') ?></th>
                    <td><?= h($companyMst->cm_partner_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Clients') ?></th>
                    <td><?= h($companyMst->cm_clients) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Delivery Zip') ?></th>
                    <td><?= h($companyMst->cm_delivery_zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Delivery City') ?></th>
                    <td><?= h($companyMst->cm_delivery_City) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Delivery State') ?></th>
                    <td><?= h($companyMst->cm_delivery_State) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Delivery County') ?></th>
                    <td><?= h($companyMst->cm_delivery_County) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Enabled') ?></th>
                    <td><?= h($companyMst->cm_enabled) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Approved') ?></th>
                    <td><?= h($companyMst->cm_approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm PricingInfo') ?></th>
                    <td><?= h($companyMst->cm_pricingInfo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm SpecialInst') ?></th>
                    <td><?= h($companyMst->cm_specialInst) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Checkinsheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_checkinsheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Qcsheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_qcsheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Accsheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_accsheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Recsheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_recsheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm S2csheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_s2csheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Rf2psheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_rf2psheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Cmposheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_cmposheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Mssheet Prefix') ?></th>
                    <td><?= h($companyMst->cm_mssheet_prefix) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Checkinsheet Dt') ?></th>
                    <td><?= h($companyMst->cm_checkinsheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Qcsheet Dt') ?></th>
                    <td><?= h($companyMst->cm_qcsheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Accsheet Dt') ?></th>
                    <td><?= h($companyMst->cm_accsheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Recsheet Dt') ?></th>
                    <td><?= h($companyMst->cm_recsheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm S2csheet Dt') ?></th>
                    <td><?= h($companyMst->cm_s2csheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Rf2psheet Dt') ?></th>
                    <td><?= h($companyMst->cm_rf2psheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Cmposheet Dt') ?></th>
                    <td><?= h($companyMst->cm_cmposheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Mssheet Dt') ?></th>
                    <td><?= h($companyMst->cm_mssheet_dt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Sheet Name') ?></th>
                    <td><?= h($companyMst->cm_sheet_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cm Id') ?></th>
                    <td><?= $this->Number->format($companyMst->cm_id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Cm Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($companyMst->cm_address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Cm Address1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($companyMst->cm_address1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Cm Delivery Add1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($companyMst->cm_delivery_add1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Cm Delivery Add2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($companyMst->cm_delivery_add2)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($companyMst->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('User Name') ?></th>
                            <th><?= __('User Lastname') ?></th>
                            <th><?= __('User Phone') ?></th>
                            <th><?= __('User Email') ?></th>
                            <th><?= __('User Username') ?></th>
                            <th><?= __('User Password') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Original Password') ?></th>
                            <th><?= __('User Companyid') ?></th>
                            <th><?= __('User Active') ?></th>
                            <th><?= __('User Deleted') ?></th>
                            <th><?= __('Privileges2add') ?></th>
                            <th><?= __('Privileges2edit') ?></th>
                            <th><?= __('Privileges2delete') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($companyMst->users as $users) : ?>
                        <tr>
                            <td><?= h($users->user_id) ?></td>
                            <td><?= h($users->user_name) ?></td>
                            <td><?= h($users->user_lastname) ?></td>
                            <td><?= h($users->user_phone) ?></td>
                            <td><?= h($users->user_email) ?></td>
                            <td><?= h($users->user_username) ?></td>
                            <td><?= h($users->user_password) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->original_password) ?></td>
                            <td><?= h($users->user_companyid) ?></td>
                            <td><?= h($users->user_active) ?></td>
                            <td><?= h($users->user_deleted) ?></td>
                            <td><?= h($users->privileges2add) ?></td>
                            <td><?= h($users->privileges2edit) ?></td>
                            <td><?= h($users->privileges2delete) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->user_id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->user_id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->user_id)]) ?>
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
