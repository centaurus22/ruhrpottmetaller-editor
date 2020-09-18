<div id="leiste_buttons">
    <a href="?<?= http_build_query($this->_['request_prev_month'],'', '&amp;') ?>" />
        <button>&lt;&lt;</button>
    </a>
    <a href="?<?= http_build_query($this->_['request_now'],'', '&amp;') ?>" />
        <button>&nbsp;o</button>
    </a>
    <a href="?<?= http_build_query($this->_['request_next_month'],'', '&amp;') ?>" />
        <button>>></button>
    </a>
    <div class="month"><?= $this->_['month_human'] ?></div>
</div>
