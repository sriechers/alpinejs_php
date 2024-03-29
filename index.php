<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  // require_once("./alpinejs-renderer/Component.php");
  require_once("./alpinejs-renderer/ComponentManager.php");
  $ComponentManager = new ComponentManager();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>Alpinejs + PHP 🚀</title>
  <!-- DEMO ONLY TAILWIND CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- ALPINE JS -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
  body {
    padding: 2rem;
  }

  [x-cloak] {
    display: none !important;
  }
  </style>

</head>

<body>
  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Test</h2>
    <?php
    $ComponentManager->component(
      template: "./components/test/test.php",
      props: [
        "index"=>"1"
      ]
    );

    $ComponentManager->component(
      template: "./components/test/test.php",
      props: [
        "index"=>"2"
      ]
    );

    $ComponentManager->component(
      template: "./components/test/test.php",
      props: [
        "index"=>"3"
      ]
    );
    ?>
  </section>

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Button mit Zähler</h2>
    <?php
    $ComponentManager->component(
      template: "./components/like_button.php",
      state: [
        "count"=> 10,
        "title"=>"'Ich bin ein toller Button!'"
      ],
      props: [
        "class"=>"likeButton mb-5",
      ]
    );

    $ComponentManager->component(
      template: "./components/like_button.php",
      state: [
        "count"=> 10,
        "title"=>"'Ich bin ein zweiter toller Button!'"
      ],
      props: [
        "class"=>"likeButton mb-5",
      ]
    );

    ?>
  </section>


  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Dropdown Menü<h2>
    <?php   
    $ComponentManager->component(  
      template: "./components/dropdown.php",
      state: [
        "title"=>"'dropdown'",
        "open"=>false
      ],
      props: [
        "add_task_below"=>"add task below",
        "add_task_above"=>"add task above",
        "edit_task"=>"edit",
        "delete_task"=>"delete"
      ]
    );
    ?>
  </section>

  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Formular (mit localStorage)<h2>
    <?php   
    $ComponentManager->component(  
      template: "./components/form/form.php",
      state: [],
      props: [
        "action"=>$_SERVER['PHP_SELF'],
        "method"=>"POST",
        "use_persisted_form_state"=>true,
        "storage_type"=>"localStorage",
        "storage_name"=>"my_form_state"
      ]
    );
    ?>
  </section>

  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Accordion Gruppe</h2>
    <?php
    $ComponentManager->component(
      template: "./components/accordion_group.php",
      props: [
        "items" => [
          [
            "title"=>"test 1",
            "content"=>"That's nice! ✌️"
          ],
          [
            "title"=>"test 2",
            "content"=>"Test 2 <strong>content</strong> woooow!"
          ]
        ],
        "selected_item_index"=>2
    ]
    );
    ?>
  </section>

  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Passwort Feld</h2>
    <?php   
    $ComponentManager->component(  
      template: "./components/password_input.php",
      state: [
        "isVisible"=>false,
      ]
    );
    ?>
  </section>

  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Modal</h2>
    <?php
    $ComponentManager->component(
      template: "./components/modal.php",
      state: [
        "open" => false 
      ]
    );
    ?>
  </section>

  <hr class="border-1 border-slate-100">

  <section class="my-20">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Liste mit Suche</h2>
    <?php
    $ComponentManager->component(
      template: "./components/searchable_list.php",
      props: [
        "items"=>"test"
      ]
    );
    ?>
  </section>

  <?php 
  echo ComponentManager::get_styles();
  echo ComponentManager::get_scripts();
  ?>
</body>


</html>