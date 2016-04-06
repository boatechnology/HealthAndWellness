<table id="leaderboard" class="table table-condensed  mytable">
    <thead class='boa'>
        <tr>
            <th><?= $this->lang->line('hw_consistency_rank') ?></th>
            <th><?= $this->lang->line('hw_consistency_id') ?></th>
            <th><?= $this->lang->line('hw_consistency') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        foreach($points as $value) {
            # if we're on the row of the current user, highlight the row
            $class = ($this->session->userdata('hwnumber') == $value['hwnumber']) ? 'you' : ''; ?>
            <tr data-toggle='tooltip' class='<?= $class ?>'
            <?php # include tooltip with users real name for admins only
                if ($this->session->userdata('isadmin') == 1){
                    echo " data-content='".$value['cn']." - ".$value['total_points']."'";
                } ?>
                >
                <td><?= $counter ?></td>
                <td><?= $value['hwnumber'] ?></td>
                <td><?= $value['consistency_total'] ?>/<?= (date('m')-1) ?></td>
            </tr>
            <?php
            $counter++;
        } ?>
    <tbody>
</table>