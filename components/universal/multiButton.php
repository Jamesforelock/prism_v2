<div class="buttons">
    <button class="multiButton multiButton_disabled" onclick="toggleButtons()" title="Admin tool">
        <i class="fas fa-pencil-ruler"></i>
    </button>
    <button class="subButton subButton_disabled" data-toggle="modal" data-target="#createArticleModal" title="Create a new article">
        <i class="fas fa-plus"></i>
    </button>
    <button class="subButton subButton_disabled" data-toggle="modal" data-target="#editArticlesModal" title="Edit articles">
        <i class="fas fa-pencil-alt"></i>
    </button>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/createArticleModal/createArticleModal.php'?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/editArticlesModal/editArticlesModal.php'?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/universal/setAssistantsModal/setAssistantsModal.php'?>

<script src="./scripts/multiButton.js"></script>
<script src="./scripts/editArticlesModal.js"></script>
<script src="./scripts/editArticleModal.js"></script>
<script src="./scripts/setAssistantsModal.js"></script>