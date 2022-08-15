<div
  x-data="{<?=$_ALPINE_STATE?>}"
  x-cloak
>
  <p id="myTest">Dies ist ein Test <?=$_PROPS["index"]?></p>
</div>

<?php /* Component Styles laden */ ?>
<link rel="stylesheet" href="/components/test/test.css" data-include-once/>

<?php /* Component Script laden */ ?>
<script src="/components/test/test.js" defer data-include-once></script>