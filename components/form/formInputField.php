<?php 
  // Destructure $_STATE Array
  ['id'=>$id, 'label'=>$label, 'type'=>$type, 'value'=>$value] = $_STATE;

  // get the key for the value variable 
  $value_key = get_key($value, $_STATE);
?>

<div x-data="{<?=$_ALPINE_STATE?>}" class="mb-5">
  <label class="block text-sm font-bold" for="<?=$id?>">
    <?=$label?>
  </label>
  <input style="min-width: 36rem;" class="flex items-center space-x-2 rounded-md bg-gray-50 p-2 my-2" x-init="$nextTick(() => {
      value = $store?.form_<?=$_PROPS['parent_id']?>?.formData['<?=$id?>'] || ''
    })" @input.debounce="$store.form_<?=$_PROPS['parent_id']?>.update({
    fieldName: '<?=$id?>',
    value: $el.value
  })" id="<?=$id?>" name="<?=$id?>" type="<?=$type?>" x-model="<?=$value_key?>" />
</div>