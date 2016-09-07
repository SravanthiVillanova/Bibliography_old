<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Panta Rhei Project: Error</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <p align="center">
  <table cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
    <tr>
      <td align="Center">
        <h2>An error has occured</h2>
        <p class="errorMsg">{$error->getMessage()}</p>
        <p class="errorStmt">{$error->getDebugInfo()}</p>
        <p>Please contact your administrator to report the problem</p>
        <p class="errorDebug">
        <B>DEBUG</b><br>
        {foreach from=$error->backtrace item=backtrace}
          In {$backtrace.file} on line {$backtrace.line} in function {$backtrace.function}<br>
        {/foreach}
      </td>
    </tr>
  </table>
  </p>
</body>
</html>
