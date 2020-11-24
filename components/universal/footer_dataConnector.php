<?php
// Отображение главной информации о компании ======================================================================
echo '<div class="row justify-content-around">';
$footer_content_mainInfo = fopen($_SERVER['DOCUMENT_ROOT'].'/vistavca/edit/footer_content_mainInfo.txt', "r");
if($footer_content_mainInfo) { // Если файл успешно открылся
    while(!feof($footer_content_mainInfo)) { // Пока не будет достигнут конец файла
        $textString = fgets($footer_content_mainInfo, 999); // Получаем очередную строку
        // Если строка не начинается с "~" (не является подсказочной строкой)
        if(substr($textString, 0 , 1) != "~") {
            // Если строка не начинается с "_" (не является элементом списка)
            if(substr($textString, 0, 1) != "_") {
                // Если строка является командой закрытия списка
                if (substr($textString, 0, 1) == "#") {
                    echo '
                </ul>
            </div>
            ';
                }
                // Если строка не является командой закрытия списка, то она является командой открытия списка с titl'ом $textstring
                else {
                    echo '
                <div class="col">
                    <span class="footer__title">'.$textString.'</span>
                    <ul class="list">
            ';
                }
            }
            // Если строка начинается с "_" (является элементом списка)
            else {
                echo '<li class="list__item">'.substr($textString, 1).'</li>';
            }
        }

    }
}
else { // Если файл открыться не смог
    echo "Sorry, but main information about us is temporarily unavailable";
}
fclose($footer_content_mainInfo); // Закрытие файла
echo '</div>';

// Отображение информации о группах компании в соц. сетях =========================================================
echo '<div class="social">';
$footer_content_socialInfo = fopen($_SERVER['DOCUMENT_ROOT'].'/vistavca/edit/footer_content_socialInfo.txt', "r");
if($footer_content_socialInfo) { // Если файл успешно открылся
    while(!feof($footer_content_socialInfo)) {
        $textString = fgets($footer_content_socialInfo);
        // Если строка не начинается с "~" (не является подсказочной строкой)
        if (substr($textString, 0, 1) != "~") {
            $spacePos=strpos($textString, " "); // Находим позицию ближайшего пробела
            $beforeSpace=substr($textString, 0, $spacePos); // Обрезаем строку от начала до позиции ближашейго пробела
            switch ($beforeSpace) {
                case "VK:":
                    echo '<a href="'.substr($textString, $spacePos+1).'" class="social__link" target="_blank"><i class="social__icon fab fa-vk"></i></a>';
                    break;
                case "Twitter:":
                    echo '<a href="'.substr($textString, $spacePos+1).'" class="social__link" target="_blank"><i class="social__icon fab fa-twitter"></i></a>';
                    break;
                case "Instagram:":
                    echo '<a href="'.substr($textString, $spacePos+1).'" class="social__link" target="_blank"><i class="social__icon fab fa-instagram"></i></a>';
                    break;
            }
        }
    }
}
else { // Если файл открыться не смог
    echo 'Sorry, but information about us in social networks is temporarily unavailable';
}
echo '</div>';
fclose($footer_content_socialInfo);