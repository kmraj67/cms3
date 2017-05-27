<table width="100%;" style="width: 100%; font-size:14px; padding-top:10px; padding-bottom:40px;">
    <tbody>
        <tr>
            <td style="line-height:23px;">
                <div style="font-weight:bold; display: block;">Hi <?= isset($first_name)?$first_name:'' ?>,</div>
                <div style="color:#4d4d4d; margin-top:10px;">
                    We received a request to change your password. Please <a href="<?php echo isset($reset_url)?$reset_url:''; ?>">click here</a> to get the reset password link.
                </div>
            </td>
        </tr>
        <?= $this->element('Admin.Layout/email_footer'); ?>
    </tbody>
</table>