<div id="activity-table" class="table-responsive boa">
    <table class="table table-striped table-bordered table-condensed">
        <thead class="boa">
             <tr>
            <?php if ($manager) { ?>
                <th><?= $this->lang->line('hw_user') ?></th>
            <?php } ?>
                <th><?= $this->lang->line('hw_date') ?></th>
                <th><?= $this->lang->line('hw_activity') ?></th>
                <th><?= $this->lang->line('hw_comments') ?></th>
                <th><?= $this->lang->line('hw_quantity') ?></th>
                <th><?= $this->lang->line('hw_points') ?></th>
                <th><?= $this->lang->line('hw_total') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="boa">
        <?php foreach($rows as $row) {
            $row['manager'] = $manager;
            echo $this->wellness->activity_log_table_row('', $row);
        } ?>
        </tbody>
    </table>
</div>