<div class="<?=$_PROPS['class']?>" x-cloak x-data="{<?=$_ALPINE_STATE?>}">
  <h3 class="mb-2"><?=$_STATE["title"]?></h3>
  <div class="flex items-center">
    <button class="rounded-md bg-blue-500 px-4 py-2 text-white" @click="count++">click
      me</button>
    <p class="ml-3">
      clicks: <span x-text="count"><?=$_STATE["count"]?></span>
    </p>
  </div>
</div>