<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

$types = $this->data['types'] ?? [];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head">
                <?= $this->getHtml('Stocks'); ?>
                <i class="g-icon download btn end-xs">download</i>
                <a class="button end-xs save" href="<?= UriFactory::build('{/base}/warehouse/stock/type/create'); ?>"><?= $this->getHtml('New', '0', '0'); ?></a>
            </div>
            <div class="slider">
            <table id="stockList" class="default sticky">
                <thead>
                <tr>
                    <td><?= $this->getHtml('ID', '0', '0'); ?>
                    <td class="wf-100"><?= $this->getHtml('Name'); ?>
                <tbody>
                <?php $count = 0; foreach ($types as $key => $value) :
                    ++$count;
                    $url = UriFactory::build('{/base}/warehouse/stock/type/view?id=' . $value->id);
                ?>
                    <tr data-href="<?= $url; ?>">
                        <td><a href="<?= $url; ?>"><?= $value->id; ?></a>
                        <td><a href="<?= $url; ?>"><?= $this->printHtml($value->getL11n()); ?></a>
                <?php endforeach; ?>
                <?php if ($count === 0) : ?>
                    <tr><td colspan="2" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                <?php endif; ?>
            </table>
            </div>
        </section>
    </div>
</div>
