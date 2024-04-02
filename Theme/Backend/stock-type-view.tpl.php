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

use Modules\WarehouseManagement\Models\NullStockType;
use phpOMS\Uri\UriFactory;

$type  = $this->data['type'] ?? new NullStockType();
$isNew = $type->id === 0;

echo $this->data['nav']->render();
?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <form id="typeForm" method="<?= $isNew ? 'PUT' : 'POST'; ?>" action="<?= UriFactory::build('{/api}warehouse/stock/type?csrf={$CSRF}'); ?>">
            <div class="portlet-head"><?= $this->getHtml('Type'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="iTypeId"><?= $this->getHtml('ID', '0', '0'); ?></label>
                    <input type="text" id="iTypeId" name="id" value="<?= $type->id; ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="name"><?= $this->getHtml('Name'); ?></label>
                    <input id="name" type="text" name="name" value="<?= $this->printHtml($type->name); ?>"<?= $isNew ? ' required' : ' disabled'; ?>>
                </div>
            </div>
            </form>
        </section>
    </div>
</div>

<?php if (!$isNew) : ?>
<div class="row">
    <?= $this->data['l11nView']->render(
        $this->data['l11nValues'],
        [],
        '{/api}warehouse/stock/type/l11n?csrf={$CSRF}'
    );
    ?>
</div>
<?php endif; ?>
