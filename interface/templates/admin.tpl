<p>Welcome, {$user->name}</p>

{if $user->isAdmin()}
You have <b>{$reviewCnt}</b> works awaiting review.
{/if}