<p>
  <a href="work.php?id={$work->id}&action=showEmailForm" title="Send In Email"><img src="images/email_button.gif" alt="Send In Email" border="0" align="Center"></a>
  <a href="work.php?id={$work->id}&action=showPDF" title="Download As PDF"><img src="images/pdf_button.gif" alt="Download As PDF" border="0" align="Center"></a>
  {if $work->getAttributeValue('ISBN') != ""}
  <a href="http://www.amazon.com/exec/obidos/tg/detail/-/{$work->getAttributeValue('ISBN')|replace:"-":""}" title="Buy From Amazon"><img src="images/amazon_button.gif" alt="Buy From Amazon" border="0" align="Center"></a>
  {/if}
</p>


<h1>{$work->title}</h1>
<h2>{$work->subtitle}</h2>
<h2>{$work->paralleltitle}</h2>

<p>
  {$translator->translate('By', $language)}: 
  {foreach from=$authorList item=author}
    {$author->fname} {$author->lname}
  {/foreach}
</p>

<table cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="label">{$translator->translate('Publisher')}: </td>
    <td>{$publisher->name} - {$publisher->location}</td>
  </tr>
  <tr>
    <td class="label">{$translator->translate('Publish Year')}: </td>
    <td>{$work->publish_year}</td>
  </tr>
  
  {foreach from=$data key=field item=value}
  <tr>
    <td class="label">{$translator->translate($field)}: </td>
    <td>{$value}</td>
  </tr>
  {/foreach}
</table>

<p>
  <b>APA Citation Format:</b><br>
  <pre width="80">{$APACitation|escape}</pre>
</p>

<p>
<b>Find Similiar Works:</b>
{foreach from=$branchList item=branch}
  <p>{$branch}</p>
{/foreach}
</p>