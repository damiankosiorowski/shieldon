<?php
/**
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * php version 7.1.0
 *
 * @category  Web-security
 * @package   Shieldon
 * @author    Terry Lin <contact@terryl.in>
 * @copyright 2019 terrylinooo
 * @license   https://github.com/terrylinooo/shieldon/blob/2.x/LICENSE MIT
 * @link      https://github.com/terrylinooo/shieldon
 * @see       https://shieldon.io
 */

declare(strict_types=1);

defined('SHIELDON_VIEW') || die('Illegal access');

use function Shieldon\Firewall\_e;

$timezone = '';

?>

<div class="so-dashboard">
    <div id="so-rule-table-form" class="so-datatables">
        <div class="so-datatable-heading">
            <?php _e('panel', 'excl_heading_urls', 'Exclusion URLs'); ?>
            <br />
        </div>
        <div class="so-datatable-description">
            <?php _e('panel', 'excl_description', 'Please enter the begin with URLs you want them excluded from Shieldon protection.'); ?>
            <br />
        </div>
        <div class="so-rule-form iptables-form">
            <form method="post" onsubmit="freezeUI();">
                <div class="d-inline-block align-top">
                    <label for="url-path"><?php _e('panel', 'auth_label_url_path', 'URL Path'); ?></label><br />
                    <input name="url" id="url-path" type="text" value="" class="regular-text">
                    <span class="form-text text-muted">e.g. <code>/url-path/</code></span>
                </div>
                <div class="d-inline-block align-top">
                    <label>&nbsp;</label><br />
                    <?php echo $this->fieldCsrf(); ?>
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="order" value="">
                    <input type="submit" name="submit" id="btn-add-rule" class="button button-primary" value="<?php _e('panel', 'auth_btn_submit', 'Submit'); ?>">
                </div>
            </form>
        </div>
    </div>
    <br />
    <?php if (empty($exclusion_list)) : ?>
    <div id="so-table-container" class="so-datatables">
        <table id="so-datalog" class="cell-border compact stripe responsive" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td>
                        <?php _e('panel', 'ipma_text_nodata', 'No data is available now.'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div id="so-table-loading" class="so-datatables">
        <div class="lds-css ng-scope">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div id="so-table-container" class="so-datatables" style="display: none;">
        <table id="so-datalog" class="cell-border compact stripe responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php _e('panel', 'auth_label_url_path', 'URL Path'); ?></th>
                    <th><?php _e('panel', 'auth_label_remove', 'Remove'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($exclusion_list)) : ?>
                <?php foreach ($exclusion_list as $i => $urlInfo) : ?>
                <tr>
                    <td><?php echo $urlInfo['url']; ?></td>
                    <td><button type="button" class="button btn-remove-ip" data-order="<?php echo $i; ?>"><i class="far fa-trash-alt"></i></button></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
	<br />
</div>
<div class="so-qp-dashboard">
	<div id="so-rule-table-form" class="so-datatables">
		<div class="so-datatable-heading">
			<?php _e('panel', 'excl_heading_query_params', 'Exclusion query params'); ?>
			<br />
		</div>
		<div class="so-datatable-description">
			<?php _e('panel', 'excl_description_query_params', 'Please enter comma-separated name of query params you want them excluded from Shieldon protection.'); ?>
			<br />
		</div>
		<div class="so-rule-form iptables-form">
			<form method="post" onsubmit="freezeUI();">
				<div class="d-inline-block align-top">
					<label for="query-params"><?php _e('panel', 'auth_label_query_params', 'Set of query params names'); ?></label><br />
					<input name="query_params" id="query-params" type="text" value="" class="regular-text">
					<span class="form-text text-muted">e.g. <code>abc,redirect</code></span>
				</div>
				<div class="d-inline-block align-top">
					<label>&nbsp;</label><br />
					<?php echo $this->fieldCsrf(); ?>
					<input type="hidden" name="action" value="add-qp">
					<input type="hidden" name="order" value="">
					<input type="submit" name="submit" id="btn-add-rule-qp" class="button button-primary" value="<?php _e('panel', 'auth_btn_submit', 'Submit'); ?>">
				</div>
			</form>
		</div>
	</div>
	<br />
	<?php if (empty($exclusion_query_params_list)) : ?>
		<div id="so-qp-table-container" class="so-datatables">
			<table id="so-qp-datalog" class="cell-border compact stripe responsive" cellspacing="0" width="100%">
				<tbody>
				<tr>
					<td>
						<?php _e('panel', 'ipma_text_nodata', 'No data is available now.'); ?>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<div id="so-qp-table-loading" class="so-datatables">
			<div class="lds-css ng-scope">
				<div class="lds-ripple">
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div id="so-qp-table-container" class="so-datatables" style="display: none;">
		<table id="so-qp-datalog" class="cell-border compact stripe responsive" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th><?php _e('panel', 'auth_label_query_params', 'Sets of params'); ?></th>
				<th><?php _e('panel', 'auth_label_remove', 'Remove'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if (!empty($exclusion_query_params_list)) : ?>
				<?php foreach ($exclusion_query_params_list as $i => $params) : ?>
					<tr>
						<td><?php echo implode(', ', $params); ?></td>
						<td><button type="button" class="button btn-remove-ip" data-order="<?php echo $i; ?>"><i class="far fa-trash-alt"></i></button></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<script>

    $(function() {
        $('#so-datalog').DataTable({
            'responsive': true,
            'paging': false,
            'initComplete': function(settings, json) {
                $('#so-table-loading').hide();
                $('#so-table-container').fadeOut(800);
                $('#so-table-container').fadeIn(800);
            }
        });

		$('#so-qp-datalog').DataTable({
			'responsive': true,
			'paging': false,
			'initComplete': function(settings, json) {
				$('#so-qp-table-loading').hide();
				$('#so-qp-table-container').fadeOut(800);
				$('#so-qp-table-container').fadeIn(800);
			}
		});

        $('.so-dashboard').on('click', '.btn-remove-ip', function() {
            var order = $(this).attr('data-order');

            $('.so-dashboard [name=order]').val(order);
            $('.so-dashboard [name=action]').val('remove');
            $('#btn-add-rule').trigger('click');
        });

		$('.so-qp-dashboard').on('click', '.btn-remove-ip', function() {
			var order = $(this).attr('data-order');

			$('.so-qp-dashboard [name=order]').val(order);
			$('.so-qp-dashboard [name=action]').val('remove-qp');
			$('#btn-add-rule-qp').trigger('click');
		});
    });

</script>
