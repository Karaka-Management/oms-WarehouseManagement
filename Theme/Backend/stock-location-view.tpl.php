<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Profile
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\WarehouseManagement\Models\NullStockLocation;
use phpOMS\Uri\UriFactory;

$location = $this->data['location'] ?? new NullStockLocation();
$isNew    = $location->id === 0;

echo $this->data['nav']->render();
?>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="locationForm" method="<?= $isNew ? 'PUT' : 'POST'; ?>" action="<?= UriFactory::build('{/api}warehouse/stock/location?csrf={$CSRF}'); ?>">
                <div class="portlet-head"><?= $this->getHtml('Location'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iLocationId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                        <input type="text" id="iLocationId" name="id" value="<?= $location->id; ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="iLocationStock"><?= $this->getHtml('Stock'); ?></label>
                        <input type="text" id="iLocationStock" name="stock" value="<?= $location->stock->id; ?>"<?= $isNew ? ' required' : ' disabled'; ?>>
                    </div>

                    <div class="form-group">
                        <label for="iLocationName"><?= $this->getHtml('Name', '0', '0'); ?></label>
                        <input type="text" name="name" value="<?= $this->printHtml($location->name); ?>">
                    </div>

                    <div class="form-group">
                        <label for="iLocationType"><?= $this->getHtml('Type'); ?></label>
                        <select id="iLocationType" name="type">
                        <?php foreach ($this->data['types'] as $type) : ?>
                            <option value="<?= $type->id; ?>"<?= $type->id === $location->type->id ? ' selected' : ''; ?>><?= $this->printHtml($type->getL11n()); ?>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="portlet-foot">
                    <?php if ($isNew) : ?>
                        <input type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>" name="create-location">
                    <?php else : ?>
                        <input type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>" name="save-location">
                        <input class="cancel end-xs" type="submit" value="<?= $this->getHtml('Delete', '0', '0'); ?>" name="delete-location">
                    <?php endif; ?>
                </div>
            </form>
        </section>
    </div>
</div>

<?php if (!$isNew) : ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="shelfForm" action="<?= UriFactory::build('{/api}warehouse/stock/location/shelf?csrf={$CSRF}'); ?>" method="post"
                data-ui-container="#shelfTable tbody"
                data-add-form="shelfForm"
                data-add-tpl="#shelfTable tbody .oms-add-tpl-shelf">
                <div class="portlet-head"><?= $this->getHtml('Shelf'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iShelfId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                        <input type="text" id="iShelfId" name="id" data-tpl-text="/id" data-tpl-value="/id" disabled>
                    </div>

                    <div class="form-group">
                        <label for="iShelfName"><?= $this->getHtml('Name', '0', '0'); ?></label>
                        <input type="text" name="name" data-tpl-value="/name" value="">
                    </div>

                    <input type="hidden" name="location" value="<?= $location->id; ?>">
                </div>
                <div class="portlet-foot">
                    <input id="bShelfAdd" formmethod="put" type="submit" class="add-form" value="<?= $this->getHtml('Add', '0', '0'); ?>">
                    <input id="bShelfSave" formmethod="post" type="submit" class="save-form vh button save" value="<?= $this->getHtml('Update', '0', '0'); ?>">
                    <input type="submit" class="cancel-form vh button close" value="<?= $this->getHtml('Cancel', '0', '0'); ?>">
                </div>
            </form>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Shelfs'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="shelfTable" class="default sticky"
                data-tag="form"
                data-ui-element="tr"
                data-add-tpl=".oms-add-tpl-shelf"
                data-update-form="shelfForm">
                <thead>
                    <tr>
                        <td>
                        <td><?= $this->getHtml('ID', '0', '0'); ?>
                        <td class="wf-100"><?= $this->getHtml('Name', '0', '0'); ?>
                <tbody>
                    <template class="oms-add-tpl-shelf">
                        <tr class="animated medium-duration greenCircleFade" data-id="" draggable="false">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <input id="shelfTable-remove-0" type="checkbox" class="vh">
                                <label for="shelfTable-remove-0" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="shelfTable-remove-0" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="shelfTable-remove-0" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                            <td data-tpl-text="/id" data-tpl-value="/id"></td>
                            <td data-tpl-text="/name" data-tpl-value="/name"></td>
                        </tr>
                    </template>
                    <?php $c = 0;
                    foreach ($location->shelfs as $key => $value) :
                        ++$c;
                        $url = UriFactory::build('{/base}/warehouse/stock/location/shelf/view?id=' . $value->id);
                    ?>
                        <tr data-id="<?= $value->id; ?>">
                            <td>
                                <i class="g-icon btn update-form">settings</i>
                                <input id="shelfTable-remove-<?= $value->id; ?>" type="checkbox" class="vh">
                                <label for="shelfTable-remove-<?= $value->id; ?>" class="checked-visibility-alt"><i class="g-icon btn form-action">close</i></label>
                                <span class="checked-visibility">
                                    <label for="shelfTable-remove-<?= $value->id; ?>" class="link default"><?= $this->getHtml('Cancel', '0', '0'); ?></label>
                                    <label for="shelfTable-remove-<?= $value->id; ?>" class="remove-form link cancel"><?= $this->getHtml('Delete', '0', '0'); ?></label>
                                </span>
                            <td data-tpl-text="/id" data-tpl-value="/id"><?= $value->id; ?>
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