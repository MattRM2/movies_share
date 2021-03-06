<?php

session_start();

require_once ('database.php'); 
require_once ('navbar.php');

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATA, DB_PORT);
$query_genre = "SELECT * FROM categ";
$result_query_genre = mysqli_query($conn, $query_genre);
$my_result = mysqli_fetch_all($result_query_genre, MYSQLI_ASSOC);
$bool_title = true;
$bool_date = true;
$bool_synopsis = true;
$bool_poster = true;
$bool_genre = true;

$titleVal = '';
$dateVal = '';
$synopsisVal = '';
$posterVal = '';



if (isset($_GET['id'])) {
    $idMovie = $_GET['id'];
    $queryMovie = "SELECT * FROM movies WHERE movie_id=$idMovie";
    $sendRequest = mysqli_query($conn, $queryMovie);
    $currentMovie = mysqli_fetch_assoc($sendRequest);
    $titleVal = $currentMovie['title'];
    $dateVal = $currentMovie['release_date'];
    $synopsisVal = $currentMovie['synopsis'];
    $posterVal = $currentMovie['poster'];
    $categVal = $currentMovie['categ_id'];
}

if(isset($_POST['submit'])){

    if(empty($_POST['title'])){
       $bool_title = false;

    }
    if(empty($_POST['date'])){
        $bool_date = false;

    }
    if(empty($_POST['synopsis'])){
        $bool_synopsis = false;
    
    }
    if(empty($_POST['poster'])){
        $bool_poster = false;

    }
    
    if(empty($_POST['genre'])){
        $bool_genre = false;
    
    }

    if ($bool_title && $bool_date && $bool_synopsis && $bool_poster && $bool_genre) {
        
        $title = $_POST['title'];
        $date = $_POST['date'];
        $synopsis = $_POST['synopsis'];
        $poster = $_POST['poster'];
        $genre = $_POST['genre'];
        $query = "INSERT INTO movies (title, release_date, synopsis, poster, categ_id) VALUE ('$title', '$date', '$synopsis', '$poster', $genre)";

        if (isset($_GET['id'])) {
            $idMovie = $_GET['id'];
            $query = "UPDATE movies SET title = '$title', release_date = '$date', synopsis = '$synopsis', poster = '$poster', categ_id = '$genre' WHERE movie_id='$idMovie'";
            $msg = 'movie successfully modified!';
        }

        $result_query = mysqli_query($conn, $query);
        $msg = 'movie successfully added!';

        if($result_query){
                echo $msg;
            }else{
                echo 'error : movie not added / modified!';
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" id="addForm">
        <input type="text" value="<?= $titleVal?>" name="title" placeholder="Add a title...">
        <input type="date" value="<?= $dateVal?>" name="date">
        <input type="text" value="<?= $synopsisVal?>" name="synopsis" placeholder="Add a synopsis...">
        <input type="text" value="<?= $posterVal?>" name="poster" placeholder="Add a poster...">
        <!-- <select id="genre" name="genre">
            <?php

            foreach ($my_result as $key => $value) {
                if ($value['categ_id'] == $categVal) {
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
                echo '<option value="' . $value['categ_id'] . '"'. $selected .'>'. $value['categ_id'] . '-'. $value['genre'] . '</option>';
            }

            ?>
        </select> -->

        <select id="genre" name="genre">
            <?php
            foreach ($my_result as $key => $value) {
                if ($value['categ_id'] == $categVal) {
                    echo '<option value="' . $value['categ_id'] . '" selected>'. $value['categ_id'] . '-'. $value['genre'] . '</option>';
                }else{
                    echo '<option value="' . $value['categ_id'] . '">'. $value['categ_id'] . '-'. $value['genre'] . '</option>';
                }
            }

            ?>
        </select>

        <!-- <select id="genre" name="genre">
            <?php foreach ($my_result as $key => $value) : ?>
                <option value="<?= $value['categ_id']; ?>" <?= ($value['categ_id'] == $categVal)? 'selected' : ''; ?>>
                <?= $value['categ_id'] . '-'. $value['genre']?>
                </option>
            <?php endforeach; ?>
        </select> -->

        <input type="submit" name="submit">

    
    </form>


