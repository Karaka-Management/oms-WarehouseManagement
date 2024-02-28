<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Profile
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

$type = $this->data['type'];

echo $this->data['nav']->render();
?>
<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Type'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="name"><?= $this->getHtml('Name'); ?></label>
                    <input id="name" name="name" value="<?= $this->printHtml($type->name); ?>" disabled>
                </div>
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Localizations'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="localizationTable" class="default sticky fixed-5"
                data-tag="form"
                data-ui-element="tr"
                data-add-tpl=".oms-add-tpl-localization"
                data-update-form="localizationForm">
                <thead>
                    <tr>
                        <td>
                        <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <td><?= $this->getHtml('Name'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                        <td><?= $this->getHtml('Language'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                        <td class="wf-100"><?= $this->getHtml('Localization'); ?><i class="sort-asc g-icon">expand_less</i><i class="sort-desc g-icon">expand_more</i>
                <tbody>
                    <template class="oms-add-tpl-attribute">
                        <tr data-id="" draggable="false">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <input id="attributeTable-remove-0" type="checkbox" class="vh">
                                <label for="attributeTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="attributeTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="attributeTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                            <td data-tpl-text="/id" data-tpl-value="/id"></td>
                            <td data-tpl-text="/type" data-tpl-value="/type" data-value=""></td>
                            <td data-tpl-text="/language" data-tpl-value="/language"></td>
                            <td data-tpl-text="/l11n" data-tpl-value="/l11n"></td>
                        </tr>
                    </template>
                    <?php
                    $c        = 0;
                    $itemL11n = $this->data['l11nValues'];
                    foreach ($itemL11n as $value) : ++$c; ?>
                        <tr data-id="<?= $value->id; ?>">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <?php if (!$value->type->isRequired) : ?>
                                <input id="localizationTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                <label for="localizationTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="localizationTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="localizationTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                                <?php endif; ?>
                            <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                            <td data-tpl-text="/type" data-tpl-value="/type" data-value="<?= $value->type->id; ?>"><?= $this->printHtml($value->type->title); ?>
                            <td data-tpl-text="/language" data-tpl-value="/language"><?= $this->printHtml($value->language); ?>
                            <td data-tpl-text="/l11n" data-tpl-value="/l11n" data-value="<?= \nl2br($this->printHtml($value->content)); ?>"><?= \nl2br($this->printHtml(\substr($value->content, 0, 100))); ?>
                    <?php endforeach; ?>
                    <?php if ($c === 0) : ?>
                    <tr>
                        <td colspan="5" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                    <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
