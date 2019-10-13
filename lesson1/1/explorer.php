<?php

function getFolderAndFilesFromDirectory()
{
    $directory = 'C:/';
    if (isset($_GET['directory'])) {
        $directory = $_GET['directory'];
    }

    return new DirectoryIterator($directory);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Explorer</title>
</head>
<body>
<?php foreach (getFolderAndFilesFromDirectory() as $item):?>
        <?php if ('.' != $item) :?>
            <?php if (is_dir($item->getPathname())) :?>
                <div><a href="<?=$_SERVER['PHP_SELF'].'?directory='.$item->getPathName(); ?>"><?=$item; ?></a></div>
            <?php else :?>
                <div><?=$item; ?></div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>