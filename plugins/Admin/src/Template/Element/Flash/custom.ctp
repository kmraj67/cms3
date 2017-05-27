<?php if(isset($flashError) && !empty($flashError)): ?>
<div class="error-message rong-input server-side-error-msg"><span><?= $flashError ?></span></div>
<?php else: ?>
<div class="error-message rong-input server-side-error-msg" style="display: none;"><span></span></div>
<?php endif; ?>