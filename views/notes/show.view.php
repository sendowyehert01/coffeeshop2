<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <p class="mb-6">
        <a href="/notes" class="text-blue-500 underline">Go Back</a>
      </p>
          <p><?= $note['body'] ?></p>

          <footer class="mt-6">
            <a href="/notes/edit?id=<?= $note['id'] ?>" class="rounded-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit Note</a>
          </footer>

          <!-- <form method="POST" class="mt-6">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="text-sm text-red-500">Delete</button>
          </form> -->
    </div>
  </main>
  
<?php require base_path('views/partials/foot.php') ?>