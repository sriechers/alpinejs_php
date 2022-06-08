<div x-data="{<?=$_ALPINE_STATE?>, 
    toggle(){
      if (this.open) {
          return this.close()
      }

      this.$refs.button.focus()

      this.open = true  
    },
    close(focusAfter){
        if (! this.open) return

        this.open = false

        focusAfter && focusAfter.focus()
    }
  }" x-on:keydown.escape.prevent.stop="close($refs.button)"
  x-on:focusin.window="!$refs.panel.contains($event.target) && close()" x-id="['dropdown-button']" class="relative">
  <button x-ref="button" @click="toggle()" :aria-expanded="open" :aria-controls="$id('dropdown-button')" type="button"
    class="bg-white px-5 py-2.5 rounded-md shadow">
    <span><?=$_STATE["title"]?></span>
    <span aria-hidden="true">&darr;</span>
  </button>

  <div x-ref="panel" x-show="open" x-transition.origin.top.left @click.outside="close($refs.button)"
    :id="$id('dropdown-button')" style="display: none;"
    class="absolute left-0 mt-2 w-40 bg-white rounded shadow-md overflow-hidden">
    <div>
      <a href="#" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
        <?=$_PROPS['add_task_below']?>
      </a>

      <a href="#" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
        <?=$_PROPS['add_task_above']?>
      </a>
    </div>

    <div class="border-t border-gray-200">
      <a href="#" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
        <?=$_PROPS['edit_task']?>
      </a>

      <a href="#" disabled class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
        <?=$_PROPS['delete_task']?>
      </a>
    </div>
  </div>
</div>