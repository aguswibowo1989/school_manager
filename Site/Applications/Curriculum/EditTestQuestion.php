<?php

    require("config.php");
    
    $testbankid  = getUnescapedGET("testbankid");
    
    if (! $testbankid) {
        trigger_error("Test bank ID is a require parameter", E_USER_ERROR);
    }
    
    $testbank = get_testquestion($testbankid);
     
    $config['local']['title'] = $config['local']['name'] . ": Edit Test Question";
    layout_begin();
    
?>

<table class="FormTable">
<form action="UpdateTestQuestion.php" method="POST">

<input type="hidden" name="orig_answer" value="<?= $testbank['answer'] ?>">
<input type="hidden" name="orig_question" value="<?= $testbank['question'] ?>">
<input type="hidden" name="testbankid" value="<?= $testbank['id'] ?>">

<tr class="FormTable">
<th class="FormTable">Question</th>
</tr>

<tr>
<td>
<textarea name="question" cols=60 rows=10><?= $testbank['question'] ?></textarea>
</td>
</tr>


<tr class="FormTable">
<th class="FormTable">Answer</th>
</tr>

<tr>
<td>
<textarea name="answer" cols=60 rows=5><?= $testbank['answer'] ?></textarea>
</td>
</tr>


<tr class="FormTable">
<td class="FormTable">
<input type=submit name=action value="Update Test Question">&nbsp;&nbsp;
<input type=submit name=action value="Cancel">
</td>
</tr>
</form>
</table>

<?php
    
    layout_end();

?>
