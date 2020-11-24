<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/vistavca/components/content/articles/article.php';
function EditArticleModal ($articleData, $type) {
    if($articleData['Picture'] === "") $articlePicture = 'noPhoto_a.png';
    else $articlePicture = $articleData['Picture'];
    return '
        <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Article edit</h5>
                        <button type="button" class="close" onclick="deleteModal()" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" >&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modal-form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input class="form-control" onkeyup="setEditedArticleEnteredTitle()" placeholder="Title" value="'.$articleData["Name"].'" id="editedArticle_title" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Text</label>
                                <textarea onkeyup="setEditedArticleEnteredText()" class="form-control" rows="5" placeholder="Text" id="editedArticle_text" autocomplete="off">'.$articleData["Description"].'</textarea>
                            </div>
                            <div class="form-group">
                                <label for="editArticle_image">Image: </label>
                                <input type="file" accept="/image/*" id="editedArticle_image" onchange="changeImage()">
                            </div>
                        </form>
                        <span>Here you can see the appearance of a future article</span>
                        <br>
                        <span class="btn btn-danger" onclick="removeEditedArticleImage()">Clear image</span>
                        <span class="btn btn-warning" onclick="restoreImage()">Restore image</span>
                            '.
        Article($articleData["ID"], $articleData["Name"], $articleData["Description"], "assets/i/$type/$articlePicture", $articleData["Date"])
        .'
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="uploadEditedArticleData()">Accept changes</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}

