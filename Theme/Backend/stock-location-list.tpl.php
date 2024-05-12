<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

$locations = $this->data['locations'] ?? [];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Locations'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table id="stockList" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                    <td><?= $this->getHtml('Stock'); ?>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                    <td><?= $this->getHtml('Type'); ?>
                <tbody>
                <?php $count = 0; foreach ($locations as $key => $value) :
                    ++$count;
                    $url = UriFactory::build('{/base}/warehouse/stock/location/view?{?}&id=' . $value->id);
                ?>
                    <tr data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><?= $value->id; ?></a>
                        <td><a href="<?= $url; ?>"><?= $value->stock->name; ?></a>
                        <td><a href="<?= $url; ?>"><?= $value->name; ?></a>
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($value->type->getL11n()); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
