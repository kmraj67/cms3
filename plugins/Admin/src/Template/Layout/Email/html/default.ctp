<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $this->fetch('title') ?></title>
	<style>
      .inner-slots td{
      padding-top: 10px;
      }
      td{
        vertical-align: top
      }
    </style>
  </head>
  <body bgcolor="#f2f2f2" style="font-family: arial; font-size: 13px; color:#000;">
    <div style="width: 100%">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#fff; max-width:800px;">
        <tbody>
          <tr style="border:0;border-collapse:collapse;background-color:#000;">
            <td style="margin:0;float:left;padding:10px 15px;font-size:25px;color: #fff;"><?= SITE_TITLE ?></td>
          </tr>
          <tr>
            <td class="outer-padding" style="background: #fff; border:1px solid #e3e3e3; padding: 15px;">
            	<?= $this->fetch('content') ?>
            </td>
          </tr>          
          <tr style="float:left; width:100%; background:#f2f2f2; padding:20px 0; text-align: center;">
            <td style="float:left; width:100%;">
              <div style="width:80%; text-align:center; margin:auto; padding-top: 10px; font-size: 12px; color: #4d4d4d;">This Email was sent from notification-only address that can not accept incoming emails.<br/>Please do not reply to this message.</div>
            </td>
          </tr>
          <tr style="border:0; background-color:#000;">
            <td style="margin:0;padding:15px 15px;font-size:12px;color: #fff; text-align: center; line-height: 18px;">For any futher assistance<br/>Email :- <a style="color:#fff; text-decoration: underline;" href="mailto:<?php echo SUPPORT_EMAIL; ?>"><?php echo SUPPORT_EMAIL; ?></a>  or Call :- <?php echo SUPPORT_PHONE; ?></td>
          </tr>
        </tbody>
      </table>
      <!-- main-table -->
    </div>
  </body>
</html>