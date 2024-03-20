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

$stock = $this->data['stock'];

echo $this->data['nav']->render();
?>
<div class="row">
    <div class="col-xs-12">
    <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Stock'); ?></div>
            <div class="portlet-body">
                <div class="form-group">
                    <label for="name"><?= $this->getHtml('Name'); ?></label>
                    <input id="name" name="name" value="<?= $this->printHtml($stock->name); ?>">
                </div>
            </div>
        </section>
    </div>
</div>