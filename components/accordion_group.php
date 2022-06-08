<?php
// Destructure $_STATE Array
// ['items'=>$items] = $_STATE;

// // get the key for the value variable
// $value_key = get_key($value, $_STATE);
?>


<div class="bg-white max-w-xl border border-gray-200 rounded-md"
  x-data="{selected: <?=$_PROPS['selected_item_index']?>}" x-cloak @keydown.escape="selected = 0">
  <ul class="shadow-box">
    <?php 
        for($i = 0; $i < count($_PROPS["items"]); $i++) {
        $items = $_PROPS["items"];
        $real_index = $i + 1;
        $container_name = "container_".$real_index."_".$_COMPONENT_ID; 
      ?>
    <li data-id="<?=$container_name?>" class="relative border-b border-gray-200">

      <button type="button" class="w-full px-8 py-6 text-left"
        @click="selected !== <?=$real_index?> ? selected = <?=$real_index?> : selected = null">
        <div class="flex items-center justify-between">
          <span>
            <?=$items[$i]["title"]?>
          </span>
        </div>
      </button>

      <div class="relative overflow-hidden transition-all max-h-0 duration-500 ease-out" x-ref="<?=$container_name?>"
        x-bind:style="selected == <?=$real_index?> ? 'max-height: ' + $refs.<?=$container_name?>.scrollHeight + 'px' : '0px'"
        x-init="$nextTick(() => {
          if(selected == <?=$real_index?>){
            $refs.<?=$container_name?>.style.maxHeight = $refs.<?=$container_name?>.scrollHeight + 'px'
          } else {
            $refs.<?=$container_name?>.style.maxHeight = '0px'
          }
        })">
        <div class="p-6">
          <?=$items[$i]["content"]?>
          <div class="mt-3">
            <button @click="$dispatch('toggle-modal')" class="bg-white px-5 py-2.5 rounded-md shadow">open</button>
          </div>
        </div>
      </div>

    </li>
    <?php } ?>

  </ul>
</div>