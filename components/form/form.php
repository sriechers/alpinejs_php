<?php 
  $storage_type = isset($_PROPS["storage_type"]) ? $_PROPS["storage_type"] : "localStorage";
?>
<form x-data @submit.prevent="submitForm<?=$_UNIQUE_ID?>" action="<?=$_PROPS['action']?>"
  method="<?=$_PROPS['method']?>">
  <?php
      Component(  
        template: "./components/form/formInputField.php",
        state: [
            "label"=>"'E-Mail:'",
            "id"=>"'input-email'",
            "type"=>"'email'",
            "value"=>"''"
          ],
        props: [
          "parent_id"=>$_UNIQUE_ID
        ]
      );
      Component(
        template: "./components/form/formInputField.php",
        state: [
          "label"=>"'Password:'",
          "id"=>"'input-password'",
          "type"=>"'text'",
          "value"=>"''"
        ],
        props: [
          "parent_id"=>$_UNIQUE_ID
        ]
      );
  ?>
  <button class="bg-blue-500 text-white px-2 py-1 mt-2 rounded-md">Submit</button>

  <div class="mt-7">
    <span x-text="JSON.stringify($store.form_<?=$_UNIQUE_ID?>.formData)"></span>
  </div>
</form>

<script defer>
function submitForm<?=$_UNIQUE_ID?>() {
  const data = Object.assign({}, Alpine.store("form_<?=$_UNIQUE_ID?>").formData);
  console.log("Submit", data);
}

document.addEventListener('alpine:init', () => {
  const persistStore =
    <?=isset($_PROPS["use_persisted_form_state"]) && $_PROPS["use_persisted_form_state"] === true ? "true" : "false"?>;

  Alpine.store("form_<?=$_UNIQUE_ID?>", {
    formData: persistStore ? (JSON.parse(window.<?=$storage_type?>.getItem(
      "<?=$_PROPS['storage_name']?>")) || {}) : {},
    update({
      fieldName,
      value
    }) {
      this.formData[fieldName] = value;
      if (persistStore) {
        window.<?=$storage_type?>.setItem("<?=$_PROPS['storage_name']?>", JSON.stringify(this.formData));
      }
    }
  })
})
</script>