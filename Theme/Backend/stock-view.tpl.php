<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Profile
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\WarehouseManagement\Models\NullStock;
use phpOMS\Uri\UriFactory;

$stock = $this->data['stock'] ?? new NullStock();
$isNew = $stock->id === 0;

echo $this->data['nav']->render();
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="stockForm" method="<?= $isNew ? 'PUT' : 'POST'; ?>" action="<?= UriFactory::build('{/api}warehouse/stock?csrf={$CSRF}'); ?>">
            <div class="portlet-head"><?= $this->getHtml('Stock'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="iStockId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                    <input type="text" id="iStockId" name="id" value="<?= $stock->id; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="iName"><?= $this->getHtml('Name'); ?></label>
                    <input id="iName" type="text" name="name" value="<?= $this->printHtml($stock->name); ?>">
                </div>
            </div>
            <div class="portlet-foot">
                <?php if ($isNew) : ?>
                    <input type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>" name="create-stock">
                <?php else : ?>
                    <input type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>" name="save-stock">
                    <input class="cancel end-xs" type="submit" value="<?= $this->getHtml('Delete', '0', '0'); ?>" name="delete-stock">
                <?php endif; ?>
            </div>
        </section>
        </form>
    </div>
</div>

<?php if (!$isNew) : ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="locationForm" action="<?= UriFactory::build('{/api}warehouse/stock/location?csrf={$CSRF}'); ?>" method="post"
                data-ui-container="#locationTable tbody"
                data-add-form="locationForm"
                data-add-tpl="#locationTable tbody .oms-add-tpl-location">
                <div class="portlet-head"><?= $this->getHtml('Location'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iLocationId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                        <input type="text" id="iLocationId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                    </div>

                    <div class="form-group">
                        <label for="iLocationName"><?= $this->getHtml('Name', '0', '0'); ?></label>
                        <input type="text" name="name" data-tpl-value="/name" value="">
                    </div>

                    <div class="form-group">
                        <label for="iLocationType"><?= $this->getHtml('Type'); ?></label>
                        <select id="iLocationType" name="type" data-tpl-text="/type" data-tpl-value="/type">
                        <?php foreach ($this->data['types'] as $type) : ?>
                            <option value="<?= $type->id; ?>"><?= $this->printHtml($type->getL11n()); ?>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="stock" value="<?= $stock->id; ?>">
                </div>
                <div class="portlet-foot">
                    <input id="bLocationAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                    <input id="bLocationSave" formmethod="post" type="submit" class="save-form vh button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                    <input type="submit" class="cancel-form vh button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
                </div>
            </form>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Locations'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="locationTable" class="default sticky"
                data-tag="form"
                data-ui-element="tr"
                data-add-tpl=".oms-add-tpl-location"
                data-update-form="locationForm">
                <thead>
                    <tr>
                        <td>
                        <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <td><?= $this->getHtml('Type', '0', '0'); ?>
                        <td class="wf-100"><?= $this->getHtml('Name', '0', '0'); ?>
                <tbody>
                    <template class="oms-add-tpl-location">
                        <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <input id="locationTable-remove-0" type="checkbox" class="vh">
                                <label for="locationTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="locationTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="locationTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                            <td data-tpl-text="/id" data-tpl-value="/id"></td>
                            <td data-tpl-text="/type" data-tpl-value="/type" data-value=""></td>
                            <td data-tpl-text="/name" data-tpl-value="/name"></td>
                        </tr>
                    </template>
                    <?php $c = 0;
                    foreach ($stock->locations as $key => $value) :
                        ++$c;
                        $url = UriFactory::build('{/base}/warehouse/stock/location/view?id=' . $value->id);
                    ?>
                        <tr data-id="<?= $value->id; ?>">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <input id="locationTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                <label for="locationTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="locationTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="locationTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                            <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
                            <td data-tpl-text="/type" data-tpl-value="/type" data-value="<?= $value->type->id; ?>"><?= $this->printHtml($value->type->getL11n()); ?>
                            <td data-tpl-text="/name" data-tpl-value="/name"><a class="content" href="<?= $url; ?>"><?= $value->name; ?></a>
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
<?php endif; ?>