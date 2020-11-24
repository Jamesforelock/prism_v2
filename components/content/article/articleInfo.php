<?php
function articleInfo ($title, $description, $picturePath, $date) {
    echo '<div class="col-md-10 blogShort">
                     <h1>'.$title.'</h1>
                     <img src="'.$picturePath.'" width="620px" alt="post img" class="pull-left img-responsive postImg img-thumbnail margin10">
                     <article><p>
                       <p>
                         '.$description.'
                         </p>
                        <p class="card-text">'.date("d.m.Y", strtotime($date)).'</p>
                     </article>
                
                 </div>
	</div>';
}