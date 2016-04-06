<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>
<?php foreach($goals as $g) {
    $class = ($this->session->userdata('hwnumber') == $g['ID']) ? 'you' : '';
    if ($g['anonymous'] == '1' && $allow_edit == false) {
            $g['cn'] = $this->lang->line('hw_anonymous');
    }
    if ($g['status'] == "6" || $allow_edit == false) {
        $button = "";
    }else{
        $button = "<button type='button' "
                    . "id='{$g['idgoals']}' "
                    . "class='btn btn-xs btn-boa pull-right delete-me'>"
                    . $this->lang->line('hw_delete')
                    . "</button>";
    }
    if ($g['public'] == '0' || $g['public'] === NULL) {
        $public_1 = "";
        $public_0 = "active";
    }else{
        $public_1 = "active";
        $public_0 = "";
    }
    if ($g['anonymous'] == '0' || $g['anonymous'] === NULL) {
        $anonymous_1 = "";
        $anonymous_0 = "active";
    }else{
        $anonymous_1 = "active";
        $anonymous_0 = "";
    }

    $dropdown = "";
    if ($manager){
        $name_html = "<span class='$class'>".$g['cn']."</span> <span class='yellow'>|</span> ";
        $dropdown = "<dt class='highlight'>".$this->lang->line('hw_status')."</dt>";
        $dropdown .= "<dd>"
                        .$this->editable->generate(
                            'status', 
                            $g['status'], 
                            'select', 
                            'Status', 
                            'goal', 
                            $g['idgoals'],
                            '',
                            $status_array,
                            $manager)
                        . "</dd>";
    }elseif ($allow_edit == false) {
        $name_html = "<span class='$class'>".$g['cn']."</span> <span class='yellow'>|</span> ";
    }else{
        $name_html = "";
    }
    ?>

    <div class='panel panel-default'>
        <div class='panel-heading' 
             data-parent='#accordion' 
             data-target='#collapse<?= $g['idgoals'] ?>' 
             data-toggle='collapse' 
             aria-expanded='true' 
             aria-controls='collapse<?= $g['idgoals'] ?>' 
             role='tab' 
             id='heading<?= $g['idgoals'] ?>'>
            <h4 class='panel-title'>
                <?= $name_html.$g['name'] ?> 
                <span class='yellow'>|</span> 
                <?= date("M jS", strtotime($g['timestamp'])) ?>
            </h4>
        </div>
        <div id='collapse<?= $g['idgoals'] ?>' 
             class='panel-collapse collapse' 
             role='tabpanel' 
             aria-labelledby='heading<?= $g['idgoals'] ?>'>
            <div class='panel-body'>
                <div>
                    <?= $button ?>
                    <dl class='dl-horizontal'>
                        <?= $dropdown ?>
                        <dt class='highlight'><?= $this->lang->line('hw_add_goal_start') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'start_date', 
                                        $g['start_date'], 
                                        'date', 
                                        'Start Date', 
                                        'goal', 
                                        $g['idgoals'], 
                                        '', 
                                        '', 
                                        $allow_edit) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_add_goal_end') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'end_date', 
                                        $g['end_date'], 
                                        'date', 
                                        'End Date', 
                                        'goal', 
                                        $g['idgoals'], 
                                        '', 
                                        '', 
                                        $allow_edit) ?> 
                            </dd>
                        
                        <dt class='highlight'><?= $this->lang->line('hw_description') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'description', 
                                        $g['description'], 
                                        'textarea', 
                                        'Description', 
                                        'goal', 
                                        $g['idgoals'], 
                                        '', 
                                        '', 
                                        $allow_edit) ?> 
                            </dd>
                <?php if ($allow_edit == true) { ?>
                        <dt class='highlight'><?= $this->lang->line('hw_currently') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'progress', 
                                        $g['progress'], 
                                        'textarea', 
                                        'Current progress', 
                                        'goal', 
                                        $g['idgoals']) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_benefits') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'benefit', 
                                        $g['benefit'], 
                                        'textarea', 
                                        'Goal Benefits', 
                                        'goal', 
                                        $g['idgoals']) ?>
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_proof') ?> </dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'prove', 
                                        $g['prove'], 
                                        'textarea', 
                                        'Goal Proof', 
                                        'goal', 
                                        $g['idgoals']) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_add_goal_t1') ?>
                            <?= $this->editable->generate(
                                    't1points', 
                                    $g['t1points'], 
                                    'number', 
                                    'Tier 1 points', 
                                    'goal', 
                                    $g['idgoals'], 
                                    'yellow',
                                    '',
                                    $manager) ?> 
                        </dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'tier1', 
                                        $g['tier1'], 
                                        'textarea', 
                                        'Tier 1', 
                                        'goal', 
                                        $g['idgoals']) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_add_goal_t2') ?>
                            <?= $this->editable->generate(
                                    't2points', 
                                    $g['t2points'], 
                                    'number', 
                                    'Tier 2 points', 
                                    'goal', 
                                    $g['idgoals'], 
                                    'yellow',
                                    '',
                                    $manager) ?> 
                        </dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'tier2', 
                                        $g['tier2'], 
                                        'textarea', 
                                        'Tier 2', 
                                        'goal', 
                                        $g['idgoals']) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_add_goal_t3') ?>
                            <?= $this->editable->generate(
                                    't3points', 
                                    $g['t3points'], 
                                    'number', 
                                    'Tier 3 points', 
                                    'goal', 
                                    $g['idgoals'], 
                                    'yellow',
                                    '',
                                    $manager) ?> 
                        </dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'tier3', 
                                        $g['tier3'], 
                                        'textarea', 
                                        'Tier 3', 
                                        'goal', 
                                        $g['idgoals']) ?> 
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_points') ?> </dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'points', 
                                        $g['points'], 
                                        'number', 
                                        'Goal points', 
                                        'goal', 
                                        $g['idgoals'],
                                        'yellow',
                                        '',
                                        $manager) ?>
                            </dd>
                            
                        <dt class='highlight'><?= $this->lang->line('hw_comments') ?></dt>
                            <dd>
                                <?= $this->editable->generate(
                                        'notes', 
                                        $g['notes'], 
                                        'textarea', 
                                        'Comittee Notes', 
                                        'goal', 
                                        $g['idgoals'],
                                        '',
                                        '',
                                        $manager) ?>
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_public') ?></dt>
                            <dd>
                                <div class='form-group'>
                                    <div class='btn-group public-goal-button'>
                                        <button class='btn btn-boa <?= $public_1 ?>' 
                                                type='button' 
                                                data-name='public' 
                                                data-value='1' 
                                                data-pk='<?= $g['idgoals'] ?>'>
                                             <?= $this->lang->line('hw_yes') ?>
                                        </button>
                                        <button class='btn btn-boa <?= $public_0 ?>' 
                                                type='button' 
                                                data-name='public' 
                                                data-value='0' 
                                                data-pk='<?= $g['idgoals'] ?>'>
                                            <?= $this->lang->line('hw_no') ?>
                                        </button>
                                    </div>
                                </div>
                            </dd>
                        <dt class='highlight'><?= $this->lang->line('hw_anonymous') ?></dt>
                            <dd>
                                <div class='form-group'>
                                    <div class='btn-group public-goal-button'>
                                        <button class='btn btn-boa <?= $anonymous_1 ?>' 
                                                type='button' 
                                                data-name='anonymous' 
                                                data-value='1' 
                                                data-pk='<?= $g['idgoals'] ?>'>
                                            <?= $this->lang->line('hw_yes') ?>
                                        </button>
                                        <button class='btn btn-boa <?= $anonymous_0 ?>' 
                                                type='button' 
                                                data-name='anonymous' 
                                                data-value='0' 
                                                data-pk='<?= $g['idgoals'] ?>'>
                                            <?= $this->lang->line('hw_no') ?>
                                        </button>
                                     </div>
                                </div>
                            </dd>
                <?php } ?>
                    </dl>
                </div>
            
            </div>
        </div>
    </div>
<?php } ?>
</div>