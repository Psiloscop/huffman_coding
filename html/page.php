<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Huffman coding</title>

    <link href="../assets/styles.css" rel="stylesheet">
    <script src="../assets/scripts.js"></script>
</head>
<body>
<h3>The Huffman coding</h3>
<h3>By Filipovich Sergey from SE-1-12</h3>
<div id="input">
    <form action="../index.php" method="post">
        <textarea name="message" id="input_string"><?= isset($input_string) ? $input_string : ''; ?></textarea>
        <br/>

        <input type="radio" name="command" id="encode" value="encode"
            <?= !isset($command) || isset($command) && $command === 'encode'? 'checked="checked"' : '' ?> />
        <label for="encode">Encode</label>
        <br/>

        <input type="radio" name="command" id="decode" value="decode"
            <?= (isset($command) && $command === 'decode') ? 'checked="checked"' : '' ?> />
        <label for="decode">Decode</label>
        <hr/>

        <input type="submit" name="execute" value="Execute" onclick="return check_text_area();" />
    </form>
</div>
<div id="output">
    <textarea id="result_info" ><?= isset($output_string) ? $output_string : ''; ?></textarea>
    <div id="tree">
        <?= isset($image_path) ? '<img src="../images/'.$image_path.'"/>' : ''; ?>
    </div>
</div>
</body>
</html>