<table width="100%;" style="width: 100%; font-size:14px; padding-top:10px; padding-bottom:0px;">
    <tbody>
        <tr>
            <td style="line-height:23px;">
                <div style="font-weight:bold; display: block;">Hi <?= isset($first_name)?$first_name:'' ?>,</div>
                <div style="color:#4d4d4d; margin-top:10px;">Your account has been activated. Now you can login with your credentials.</div>
            </td>
        </tr>
        <?= $this->element('Admin.Layout/email_footer'); ?>
    </tbody>
</table>