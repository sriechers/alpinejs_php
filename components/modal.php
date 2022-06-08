<?php
// Destructure $_STATE Array
['open'=>$open] = $_STATE;

?>

<div x-data="{<?=$_ALPINE_STATE?>}" @toggle-modal.window="open = !open" x-cloak @keydown.escape="open = false">
  <button @click="open = !open" class="bg-white px-5 py-2.5 rounded-md shadow">Toggle Modal</button>

  <template x-teleport="body">
    <div x-transition class="fixed top-0 left-0 h-screen w-screen backdrop-blur-sm z-50"
      style="background-color: rgba(255,255,255,0.7);" x-show="open">
      <div x-transition @click.outside="open = false"
        class="w-[70%] h-[50%] -top-1/2 m-auto flex flex-col justify-between px-4 py-2 border-2 border-slate-100 shadow-xl shadow-slate-200 transform translate-y-1/2 bg-white rounded-lg">
        <div>
          Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
          dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
          clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,
          consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
          sed
          diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
          takimata sanctus est Lorem ipsum dolor sit amet.
        </div>
        <div class="flex justify-end align-center">
          <button @click="open = false" class="bg-rose-500 px-5 py-2.5 rounded-md shadow">abbrechen</button>
        </div>
      </div>
    </div>
  </template>
</div>