<tr class='editme'>
    <?php if ($manager) { ?>
        <td class='' data-title='User'><?= $username ?></td>
    <?php } ?>
    <td><?= $this->editable->generate('date', 
                                $date, 
                                'date', 
                                'Date', 
                                'activity_log', 
                                $idactivity_log,
                                '',
                                '',
                                $manager) ?>
    </td>
    <td><?= $name ?></td>                
    <td><?= $this->editable->generate('comments', 
                                $comments, 
                                'textarea', 
                                'User Comments', 
                                'activity_log', 
                                $idactivity_log) ?>
    </td>
    <td><?= $this->editable->generate('quantity', 
                                str_replace(".0", "", (string)number_format ($quantity, 1, ".", "")), 
                                'number', 
                                'Quantity', 
                                'activity_log', 
                                $idactivity_log,
                                '',
                                '') ?>
    </td>
    <td><?= $activitypoints ?>
        <span class='yellow'>/</span>
        <?= $factor ?>
    </td>
    <td><?= $points ?></td>
    <td>
        <?php # If not manager it means we're the actual user so include 'add today' button
        if (!$manager) { ?> 
            <button type='button' class='btn btn-boa btn-xs readd-activity' 
                    data-idusers='<?= $this->session->userdata('idusers') ?>' 
                    data-date='<?= date('M d') ?>' 
                    data-idactivities='<?= $idactivities ?>' 
                    data-quantity='<?= $quantity ?>'>
                <?= $this->lang->line('hw_activity_table_add_today') ?> 
            </button>
        <?php } ?>
        <button type='button' class='btn btn-boa btn-xs delete-activity' data-pk='<?= $idactivity_log ?>'> <?= $this->lang->line('hw_delete') ?></button>
    </td>
</tr>
