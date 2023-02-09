<?php

/**
 * @var string $html
 * @var array $data
 */

static $index;

$index = $index ? $index + 1 : 0;

?>

<div class="chapter-wrapper" data-index="<?= $index; ?>">
    <div class="chapter-head">
        <div class="chapter-desciption-wrapper">
            <span class="chapter-number"><?= $data['number'] ?>.</span>
            <textarea
                    name="chapter-name-<?= $data['number'] ?>"
                    class="chapter-name-textarea"
                    rows="1"
                    style="overflow: hidden; height: 29px;"><?= $data['title']; ?></textarea>
        </div>
    </div>
    <div class="chapter-questions-list">
        <?= $html; ?>
    </div>
</div>